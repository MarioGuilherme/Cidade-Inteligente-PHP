<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\User;
    use App\Utils\Form;
    use App\Utils\Response;
    use App\Utils\Email;
    use App\Utils\Session;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Usuário
     *
     * @author Mário Guilherme
     */
    class UserController extends Controller {
        private User $userModel;

        /**
         * Método responsável de carregar a configuração do
         * banco de dados e instanciar o modelo de usuario
         * @return void
         */
        private function GetModel() : void {
            require __DIR__ . "/../Database/Connection.php";
            $this->userModel = new User();
        }

        /**
         * Método responsável por retornar o email, token e a expiração do token
         * @param int $id_user
         * @return array Array de dados do usuário
         */
        public function GetUserByToken(string $token) : array {
            $this->GetModel();
            $data = $this->userModel->Select("", "token = ?", "", "", "name, token, token_expiration", [$token])->fetch(PDO::FETCH_ASSOC);
            if(!$data)
                Session::Redirect("projetos");
            else
                return $data;
        }

        /**
         * Método responsável por carregar a View de cadastro de usuário
         * @return void
         */
        public function FormRegister() : void {
            if(Session::VerifyAdm()) {
                $data = [
                    "title" => "Cadastro de Usuário",
                    "css" => "register",
                    "btns" => $this->RenderButtons(3),
                    "js" => "register"
                ];
                $this->View("Users/register", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por carregar a View de login
         * @return void
         */
        public function FormLogin() : void {
            if(!Session::VerifySession()) {
                $data = [
                    "title" => "Login",
                    "css" => "login",
                    "js" => "login"
                ];
                $this->View("Users/login", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por carregar a View de alterar senha
         * @param string $token Token de recuperação de senha
         * @return void
         */
        public function FormChangePassword(string $token) : void {
            $user = (new UserController())->GetUserByToken($token);
            if($user["token_expiration"] > date("Y-m-d H:i:s")) {
                $data = [
                    "title" => "Alterar Senha",
                    "css" => "change-password",
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
            if(!Session::VerifySession()) {
                $data = [
                    "title" => "Recuperar Senha",
                    "css" => "recover-password",
                    "js" => "recover-password"
                ];
                $this->View("Users/recover-password", $data);
            } else
                Session::Redirect("projetos");
        }

        /**
         * Método responsável por fazer o login do usuario
         * @param array $form Dados do formulário
         * @return void
         */
        public function Login(array $form) : void {
            // LIMPEZA DOS CAMPOS
            $email = Form::SanatizeField($form["email"], FILTER_SANITIZE_EMAIL);
            $password = Form::SanatizeField($form["password"], FILTER_SANITIZE_STRING);

            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$email, $password]);
            Form::ValidateEmail($email);

            // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            $this->GetModel();
            $stmtUser = $this->userModel->Select("INNER JOIN courses ON users.id_course=courses.id_course", "email = ?", "",
                                                 "", "id_user, courses.id_course, name, email, password, type, course", [$email]);

            // VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            if($stmtUser->rowCount()) {
                $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $user["password"])) {
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
                    Response::Message(WRONG_PASSWORD);
            } else
                Response::Message(USER_NOT_FOUND);
        }

        /**
         * Método responsável por fazer o cadastro de um usuario
         * @param array $form Dados do formulário
         * @return void
         */
        public function Register(array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::VerifyAdm() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            $email = Form::SanatizeField($form["email"], FILTER_SANITIZE_EMAIL);
            $name = Form::SanatizeField($form["name"], FILTER_SANITIZE_STRING);
            $password = Form::SanatizeField($form["password"], FILTER_SANITIZE_STRING);
            $type = Form::SanatizeField($form["type"], FILTER_SANITIZE_STRING);
            $course = (int) Form::SanatizeField($form["course"], FILTER_SANITIZE_NUMBER_INT);
 
            // VALIDAÇÃO DOS CAMPOS
            if($type == "Aluno(a)" || $type == "Professor(a)") {
                if(filter_var($course, FILTER_VALIDATE_INT) && $course > 0 && $course <= 7) {
                    Form::VerifyEmptyFields([$email, $name, $password]);
                    Form::ValidateEmail($email);
                    $password = Form::EncryptPassword($password);

                    // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO (PARA EVITAR DUPLICIDADE)
                    $this->GetModel();
                    $stmtUser = $this->userModel->Select("", "email = ?", "", "", "id_user", [$email])->rowCount();
                    if(!$stmtUser) {
                        $this->userModel->Insert([
                            "email" => $email,
                            "name" => $name,
                            "password" => $password,
                            "type" => $type,
                            "id_course" => $course
                        ]);
                        Response::Message(USER_REGISTERED);
                    } else
                        Response::Message(EMAIL_ALREADY_EXISTS);
                } else
                    Response::Message(INVALID_COURSE);
            } else
                Response::Message(INVALID_TYPE_USER);
        }

        /**
         * Método responsável por fazer a recuperação de senha
         * @param string $email Email do usuário
         * @return void
         */
        public function RecoverPassword(string $email) : void {
            // LIMPEZA DOS CAMPOS
            $email = Form::SanatizeField($email, FILTER_SANITIZE_EMAIL);
 
            // VALIDAÇÃO DOS CAMPOS
            Form::ValidateEmail($email);

            // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            $this->GetModel();
            $stmtUser = $this->userModel->Select("", "email = ?", "", "", "id_user, email", [$email]);
            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            // VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            if($stmtUser->rowCount()) {
                $idUser = $user["id_user"];
                $emailUser = $user["email"];
                $this->userModel->Update("id_user = $idUser", [
                    "token" => bin2hex(random_bytes(78)),
                    "token_expiration" => date("Y-m-d H:i:s", strtotime("+1 hour"))
                ]);
                $token = $this->userModel->Select("", "id_user = ?", "", "", "token, email", [$idUser])->fetch(PDO::FETCH_ASSOC)["token"];
                $objEmail = new Email($emailUser);
                $bodyEmail =
                "<h1>
                    Olá, você solicitou a recuperação de sua senha.
                </h1>
                <p>
                    Segue abaixo um link para altera sua senha:
                </p>
                <p>
                    <a href='".getenv("URL")."alterar-senha?token=$token'>".getenv("URL")."alterar-senha?token=$token</a>
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
         * @param string $password Nova senha do usuário
         * @return void
         */
        public function ChangePassword(array $form) : void {
            // LIMPEZA DOS CAMPOS
            $token = Form::SanatizeField($form["token"], FILTER_SANITIZE_STRING);
            $password = Form::SanatizeField($form["password"], FILTER_SANITIZE_STRING);
 
            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$token, $password]);
            
            // OBTENÇÃO DO MODEL E ALTERAÇÃO DE SENHA
            $this->GetModel();
            if($this->userModel->Select("", "token = ?", "", "", "id_user", [$token])->rowCount()) {
                // CRIPTOGRAFIA DA SENHA
                $password = Form::EncryptPassword($password);
    
                // OBTENÇÃO DO MODEL E ALTERAÇÃO DE SENHA
                $this->userModel->Update("token = '$token'", [
                    "token" => null,
                    "token_expiration" => null,
                    "password" => $password
                ]);
                Response::Message(PASSWORD_CHANGED);
            }else
                Response::Message(INVALID_TOKEN);
        }
    }