<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Controllers\ProjectUserController;
    use App\Models\User;
    use App\Utils\{
        Form,
        Response,
        Email,
        Session
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações do Usuário
     *
     * @author Mário Guilherme
     */
    class UserController extends Controller {
        private User $userModel;

        /**
         *  Método responsável de instanciar o modelo de Usuário.
         * @return void
         */
        private function GetModel() {
            $this->userModel = new User();
        }

        public function Index() : void {
            $this->GetModel();
            (Array) $data = [
                "title" => "Usuários",
                "css" => "users",
                "btns" => $this->RenderButtons(),
                "courses" => (new CourseController)->GetAllCourses(),
                "js" => "users"
            ];
            $this->View("Users/index", $data);
        }

        public function ViewByID(Int $id_user) : void {
            $this->GetModel();
            (Array) $user = $this->userModel::Select("", "id_user = ?", "", "", "id_user, id_course, name, email", [$id_user])->fetch(PDO::FETCH_ASSOC);
            Response::Message($user);
        }

        /**
         * Método responsável por retornar todos o ID e nome dos usuários
         * @return Array Array de usuário
         */
        public function GetUsers() : Array {
            $this->GetModel();
            return $this->userModel::Select("", "", "", "", "id_user, name")->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Método responsável por retornar o email, token e a expiração do token
         * @param Int $id_user
         * @return Array Array de dados do usuário
         */
        public function GetUserByToken(String $token) : Array {
            $this->GetModel();
            (Array) $data = $this->userModel::Select("", "token = ?", "", "", "name, token, token_expiration", [$token])->fetch(PDO::FETCH_ASSOC);
            if(!$data)
                Session::Redirect("projetos");
            else
                return $data;
        }

        public function Delete(Int $id_user) : void {
            $this->GetModel();
            (Array) $projects = count((new ProjectUserController)->GetProjectByUser($id_user));
            if($projects)
                Response::Message(USER_FK_ERROR);
            else
                $this->userModel::Delete("id_user = ?", [$id_user]) ? Response::Message(USER_DELETED) : Response::Message(GENERAL_ERROR);
        }

        public function List() : void {
            $this->GetModel();
            (Array) $users = $this->userModel::Select("u INNER JOIN courses c ON u.id_course = c.id_course")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user) {
                echo "<tr role='row'>
                    <td class='text-center'>
                        $user[id_user]
                    </td>
                    <td class='text-center'>
                        $user[course]
                    </td>
                    <td class='text-center'>
                        $user[name]
                    </td>
                    <td class='text-center'>
                        $user[email]
                    </td>
                    <td class='text-center'>
                        <button id='$user[id_user]' class='btn btn-edit-user'>
                            Editar
                        </button>
                        <button id='$user[id_user]' class='btn btn-delete-user'>
                            Apagar
                        </button>
                    </td>
                </tr>";
            }
        }

        /**
         * Método responsável por carregar a View de cadastro de usuário
         * @return void
         */
        public function FormRegister() : void {
            if(Session::IsAdmin()) {
                (Array) $data = [
                    "title" => "Cadastro de Usuário",
                    "css" => "register",
                    "btns" => $this->RenderButtons(3),
                    "courses" => (new CourseController)->GetAllCourses(),
                    "js" => "register"
                ];
                $this->View("Users/register", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por carregar a View de cadastro de usuário
         * @return void
         */
        public function MyProjects() : void {
            if(!Session::IsEmptySession()) {
                (Array) $projects = (new ProjectUserController)->GetProjectByUser((Int) $_SESSION["id_user"]);
                for($i = 0; $i < count($projects); $i++) {
                    $projects[$i]["media"] = (new MediaController)->GetAllMedias((Int) $projects[$i]["id_project"])[0];
                }
                (Array) $data = [
                    "title" => "Meus Projetos",
                    "css" => "my-projects",
                    "projects" => $projects,
                    "btns" => $this->RenderButtons(0),
                    "js" => "my-projects"
                ];
                $this->View("Users/my-projects", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por carregar a View de login
         * @return void
         */
        public function FormLogin() : void {
            if(Session::IsEmptySession()) {
                (Array) $data = [
                    "title" => "Login",
                    "css" => "login",
                    "js" => "login"
                ];
                $this->View("Users/login", $data);
            } else
                Session::Redirect("projetos");
        }

        public function Update(Array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            (Int) $id_user = Form::SanatizeField($form["id_user"], FILTER_SANITIZE_NUMBER_INT);
            (Int) $id_course = (Int) Form::SanatizeField($form["course"], FILTER_SANITIZE_NUMBER_INT);
            (String) $name = Form::SanatizeField($form["name"], FILTER_UNSAFE_RAW);
            (String) $email = Form::SanatizeField($form["email"], FILTER_SANITIZE_EMAIL);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::VerifyEmptyFields([$name, $email, $id_course]);
            Form::ValidateCourse($id_course);
            Form::ValidateEmail($email);

            // OBTÉM O MODELO E ATUALIZA A ÁREA
            $this->GetModel();
            $this->userModel::Update("id_user = $id_user", [
                "id_course" => $id_course,
                "name" => $name,
                "email" => $email
            ]) > 0 ? Response::Message(USER_UPDATED) : Response::Message(GENERAL_ERROR);
        }

        /**
         * Método responsável por retornar a quantidade de usuários de um determinado curso.
         * @param Int $id_course ID do curso
         * @return Int Quantidade de usuários
         */
        public function GetUserByCourse(Int $id_course) : Int {
            $this->GetModel();
            return $this->userModel::Select("u INNER JOIN courses c ON u.id_course = c.id_course", "c.id_course = ?", "", "", "c.id_course", [$id_course])->rowCount();
        }

        /**
         * Método responsável por carregar a View de alterar senha
         * @param String $token Token de recuperação de senha
         * @return void
         */
        public function FormChangePassword(String $token) : void {
            (Array) $user = (new UserController())->GetUserByToken($token);
            if($user["token_expiration"] > date("Y-m-d H:i:s")) {
                (Array) $data = [
                    "title" => "Alterar Senha",
                    "css" => "login",
                    "name" => $user["name"],
                    "js" => "change-password"
                ];
                $this->View("Users/change-password", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por carregar a View que
         * envia o email para recuperação de senha
         * @return void
         */
        public function FormRecoverPassword() : void {
            if(Session::IsEmptySession()) {
                (Array) $data = [
                    "title" => "Recuperar Senha",
                    "css" => "login",
                    "js" => "recover-password"
                ];
                $this->View("Users/recover-password", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por fazer o login do usuario
         * @param Array $form Dados do formulário
         * @return void
         */
        public function Login(Array $form) : void {
            // LIMPEZA DOS CAMPOS
            (String) $email = Form::SanatizeField($form["email"], FILTER_SANITIZE_EMAIL);
            (String) $password = Form::SanatizeField($form["password"], FILTER_UNSAFE_RAW);

            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$email, $password]);
            Form::ValidateEmail($email);

            // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            $this->GetModel();
            (Object) $stmtUser = $this->userModel::Select("INNER JOIN courses ON users.id_course=courses.id_course", "email = ?", "",
                                                 "", "id_user, courses.id_course, name, email, password, type, course", [$email]);

            // VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            if($stmtUser->rowCount()) {
                (Array) $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
                Form::VerifyPassword($password, $user["password"]);
                $_SESSION = [
                    "id_user" => $user["id_user"],
                    "id_course" => $user["id_course"],
                    "name" => $user["name"],
                    "email" => $user["email"],
                    "type" => $user["type"],
                    "course" => $user["course"]
                ];
                Response::Message(LOGGED);
            } else
                Response::Message(USER_NOT_FOUND);
        }

        /**
         * Método responsável por fazer o cadastro de um novo usuario.
         * @param Array $form Dados do formulário
         * @return void
         */
        public function Register(Array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            (String) $email = Form::SanatizeField($form["email"], FILTER_SANITIZE_EMAIL);
            (String) $name = Form::SanatizeField($form["name"], FILTER_UNSAFE_RAW);
            (String) $password = Form::SanatizeField($form["password"], FILTER_UNSAFE_RAW);
            (String) $type = Form::SanatizeField($form["type"], FILTER_UNSAFE_RAW);
            (Int) $course = (Int) Form::SanatizeField($form["course"], FILTER_UNSAFE_RAW);

            // VERIFICA SE HÁ CAMPOS VAZIOS, SE O EMAIL É VÁLIDO E O CURSO
            Form::VerifyEmptyFields([$email, $name, $password, $type, $course]);
            Form::ValidateEmail($email);
            Form::ValidateCourse($course);

            // VALIDAÇÃO DO TIPO DO USUÁRIO
            if($type == 0 || $type == 1) {
                $this->GetModel();
                (Int) $stmtUser = $this->userModel::Select("", "email = ?", "", "", "id_user", [$email])->rowCount();
                (String) $password = Form::EncryptPassword($password);
                if(!$stmtUser) {
                    $this->userModel::Insert([
                        "id_course" => $course,
                        "name" => $name,
                        "email" => $email,
                        "password" => $password,
                        "type" => $type
                    ]);
                    Response::Message(USER_REGISTERED);
                } else
                    Response::Message(EMAIL_ALREADY_EXISTS);
            } else
                Response::Message(INVALID_TYPE_USER);
        }

        /**
         * Método responsável por fazer a recuperação de senha
         * @param String $email Email do usuário
         * @return void
         */
        public function RecoverPassword(String $email) : void {
            // LIMPEZA DOS CAMPOS
            (String) $email = Form::SanatizeField($email, FILTER_SANITIZE_EMAIL);
 
            // VALIDAÇÃO DOS CAMPOS
            Form::ValidateEmail($email);

            // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            $this->GetModel();
            (Object) $stmtUser = $this->userModel::Select("", "email = ?", "", "", "id_user, email", [$email]);
            (Array) $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            // VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            if($stmtUser->rowCount()) {
                (Int) $idUser = $user["id_user"];
                (String) $emailUser = $user["email"];
                $this->userModel::Update("id_user = $idUser", [
                    "token" => bin2hex(random_bytes(78)),
                    "token_expiration" => date("Y-m-d H:i:s", strtotime("+1 hour"))
                ]);
                (String) $token = $this->userModel::Select("", "id_user = ?", "", "", "token, email", [$idUser])->fetch(PDO::FETCH_ASSOC)["token"];
                (Object) $objEmail = new Email($emailUser);
                (String) $bodyEmail =
                    "<h1>
                        Olá, você solicitou a recuperação de sua senha.
                    </h1>
                    <p>
                        Segue abaixo um link para altera sua senha:
                    </p>
                    <p>
                        O Link irá expirar em 1 hora.
                    </p>
                    <p>
                        <a href='".URL."alterar-senha?token=$token'>".URL."alterar-senha?token=$token</a>
                    </p>
                    <p style='color:red;'>
                        Não compartilhe esse link com ninguém!
                    </p>";
                $objEmail->SendEmail("Recuperação de Senha", $bodyEmail);
                Response::Message(CHANGE_PASSWORD_REQUEST_SEND);
            } else
                Response::Message(EMAIL_NOT_REGISTERED);
        }

        /**
         * Método responsável por fazer a alteração da senha
         * @param String $password Nova senha do usuário
         * @return void
         */
        public function ChangePassword(Array $form) : void {
            // LIMPEZA DOS CAMPOS
            (String) $token = Form::SanatizeField($form["token"], FILTER_UNSAFE_RAW);
            (String) $password = Form::SanatizeField($form["password"], FILTER_UNSAFE_RAW);
 
            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$token, $password]);
            
            // OBTENÇÃO DO MODEL E ALTERAÇÃO DE SENHA
            $this->GetModel();
            if($this->userModel::Select("", "token = ?", "", "", "id_user", [$token])->rowCount()) {
                // CRIPTOGRAFIA DA SENHA
                (String) $password = Form::EncryptPassword($password);
    
                // OBTENÇÃO DO MODEL E ALTERAÇÃO DE SENHA
                $this->userModel::Update("token = '$token'", [
                    "token" => null,
                    "token_expiration" => null,
                    "password" => $password
                ]);
                Response::Message(PASSWORD_CHANGED);
            }else
                Response::Message(INVALID_TOKEN);
        }
    }