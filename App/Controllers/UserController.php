<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Controllers\ProjectUserController;
    use App\Models\{
        User,
        Project
    };
    use App\Utils\{
        Form,
        Response,
        Email,
        Session
    };

    use App\Core\{
        Page
    };
    use App\Database\Database;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Usuário.
     * @author Mário Guilherme
     */
    class UserController extends Controller {
        /**
         * Modelo de Área.
         * @var User
         */
        private User $model;

        /**
         * Classe do banco de dados com acesso à tabela dos usuários.
         */
        private Database $userDAO;

        /**
         * Método responsável de instanciar o Modelo de Usuário e o objeto Database para abstração de dados da tabela dos usuários.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->model)) $this->model = new User;
            if (!isset($this->userDAO)) $this->userDAO = new Database("users");
        }

        /**
         * Método responsável por carregar a tela de Usuários.
         * @return void
         */
        public function index() : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança
            $page = new Page(
                "Usuários", // Título da página
                "usuarios", // Nome do item da navbar a ser desativado
                [
                    "users" => $this->getAllUsers(),
                    "courses" => (new CourseController)->getAllCourses()
                ], // Dados para a tela
                [ "genericNavbar", "dataTable" ], // Arquivos CSS
                [ "navbar", "users" ], // Arquivos JS
                "Users", // Caminho para o formulário de cadastro no modal
            );
            $this->view("Users/main", $page);
        }

        /**
         * Método responsável por carregar o formulário de login.
         * @return void
         */
        public function formLogin() : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, redireciona para a página principal
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    header("Location: /");
                else
                    header("Location: services/logout");

            $page = new Page(
                "Login", // Título da página
                "", // Nome do item da navbar a ser desativado
                [], // Dados para a tela
                [ "auth" ], // Arquivos CSS
                [ "login" ], // Arquivos JS
            );
            $this->view("Users/login", $page);
        }

        /**
         * Método responsável por carregar o formulário para enviar o email de recuperação de senha.
         * @return void
         */
        public function formSendEmail() : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, redireciona para a página principal
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    header("Location: /");
                else
                    header("Location: services/logout");

            $page = new Page(
                "Enviar email de recuperação de senha", // Título da página
                "", // Nome do item da navbar a ser desativado
                [], // Dados para a tela
                [ "auth" ], // Arquivos CSS
                [ "sendEmailRecover" ], // Arquivos JS
            );
            $this->view("Users/sendEmailRecover", $page);
        }

        /**
         * Método responsável por carregar o formulário de alteração de senha.
         * @param string $token Token de recuperação de senha
         * @return void
         */
        public function formChangePassword(string $token) : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, redireciona para a página principal
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    header("Location: /");
                else
                    header("Location: services/logout");

            $this->getModel();
            (object) $user = $this->userDAO->select(where: "token = ?", fields: "name, token, token_expiration", params: [$token])->fetchObject($this->model::class);

            if (!$user)
                header("Location: projetos");

            if ($user->token_expiration < date("Y-m-d H:i:s"))
                header("Location: /");


            $page = new Page(
                "Alterar Senha", // Título da página
                "", // Nome do item da navbar a ser desativado
                [ "name" => $user->name, "token" => $user->token ], // Dados para a tela
                [ "auth" ], // Arquivos CSS
                [ "changePassword" ], // Arquivos JS
            );
            $this->view("Users/changePassword", $page);
        }

        /**
         * Método responsável por carregar a tela com os projetos relacionados ao Usuário logado.
         * @param int $currentPage Número da página atual
         * @return void
         */
        public function myProjects(int $currentPage) : void {
            if (!Session::isLogged() || !Session::userLoggedExist(array_key_exists("id_user", $_SESSION) ? (int) $_SESSION["id_user"] : 0))
                header("Location: /"); // Se o usuário estiver não estiver logado ou se nem existir no banco de dados, redireciona para a página inicial

            $projectUserController = new ProjectUserController;
            $totalProjects = $projectUserController->projectUserDAO->select(
                fields: "COUNT(*)",
                where: "id_user = ?",
                params: [$_SESSION["id_user"]]
            )->fetchColumn();

            if ($currentPage <= 0)
                $currentPage = 1;

            // Lógica para aplicar 6 projetos por página
            (float) $totalPages = ceil($totalProjects / 6);
            if ($currentPage > $totalPages) // Se for acessado uma página que não existir na lista, redireciona para a última página
                $currentPage = (int) $totalPages == 0 ? 1 : $totalPages;

            (array) $projects = $projectUserController->projectUserDAO->select(
                join: "pu INNER JOIN projects p ON pu.id_project = p.id_project",
                where: "pu.id_user = ?",
                fields: "p.id_project, title, description",
                params: [$_SESSION["id_user"]],
                limit: $currentPage * 6 - 6 . ", 6"
            )->fetchAll(PDO::FETCH_CLASS, Project::class);

            (object) $mediaController = new MediaController;
            for ($i = 0; $i < count($projects); $i++) // PARA CADA PROJETO DO USUÁRIO, PEGA A PRIMEIRA MÍDIA DO PROJETO
                $projects[$i]->media = $mediaController->getMediasByProjectToCard($projects[$i]->id_project)[0];

            $page = new Page(
                "Meus Projetos", // Título da página
                "meus-projetos", // Nome do item da navbar a ser desativado
                [
                    "projects" => $projects,
                    "totalPages" => $totalPages,
                    "currentPage" => $currentPage
                ], // Dados para a tela
                [ "genericNavbar", "myProjects" ], // Arquivos CSS
                [ "navbar", "myProjects" ] // Arquivos JS
            );
            $this->view("Users/myProjects", $page);
        }

        /**
         * Método responsável por retornar todos os Usuários.
         * @param bool $isForAPI Informa se os usuários deve ser retornados para uma chamada de API encerrando o script
         * @return array Array com todos os usuários
         */
        public function getAllUsers(bool $isForAPI = false) : array {
            $this->getModel();
            (array) $users = $this->userDAO->select(
                join: "u INNER JOIN courses c ON u.id_course = c.id_course",
                fields: "id_user, name, email, course, isAdmin"
            )->fetchAll(PDO::FETCH_CLASS, $this->model::class);

            if ($isForAPI) // Se true, ele encerra o script com o json (usado para chamada da api)
                Response::returnResponse($users);

            return $users;
        }

        /**
         * Método responsável por retornar os dados de um Usuário a partir de seu ID.
         * @param int $id_user ID do Usuário
         * @return void
         */
        public function getUserByID(int $id_user) : void {
            $this->getModel();
            (object) $user = $this->userDAO->select(where: "id_user = ?", fields: "id_user, id_course, name, email, isAdmin", params: [$id_user])->fetchObject($this->model::class);
            Response::returnResponse($user);
        }

        /**
         * Método responsável por verificar se um Usuário existe pelo ID.
         * @param int $id_user ID do usuário
         * @return bool True se o usuário existir e false se não
         */
        public function userExists(int $id_user) : bool {
            $this->getModel();
            return $this->userDAO->select(where: "id_user = ?", fields: "id_user", params: [$id_user])->rowCount() == 1;
        }

        /**
         * Método responsável por verificar se existem Usuários relacionado ao ID do Curso.
         * @param int $id_course ID do Curso
         * @return bool True se existir usuários, false se não existir
         */
        public function courseHasUsersLinked(int $id_course) : bool {
            $this->getModel();
            return $this->userDAO->select(where: "id_course = ?", fields: "id_user", params: [$id_course])->rowCount() > 0;
        }

        /**
         * Método responsável por fazer o login do Usuário.
         * @param array $form Dados do formulário
         * @return void
         */
        public function login(array $form) : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, retorna aviso de que ele já está logado e encerra a função
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    Response::returnResponse(Response::USER_ALREADY_LOGGED, 401, "warning");
                else
                    Response::returnResponse(Response::USER_LOGGED_DOES_NOT_EXIST, 401, "warning");

            // LIMPEZA DOS CAMPOS
            (string) $email = Form::sanatizeString($form["email"], FILTER_SANITIZE_EMAIL);
            (string) $password = Form::sanatizeString($form["password"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O EMAIL
            Form::isEmptyFields([$email, $password]);
            Form::validateEmail($email);

            // OBTENÇÃO DO MODEL E OBTÊM OS DADOS DO USUÁRIO
            $this->getModel();
            (object) $stmtUser = $this->userDAO->select(where: "email = ?", fields: "id_user, password, isAdmin", params: [$email]);

            if ($stmtUser->rowCount() == 0)
                Response::returnResponse(Response::USER_NOT_FOUND, 400, "error");

            (array) $user = $stmtUser->fetchObject($this->model::class);

            // VERIFICAÇÃO DE SENHA
            Form::verifyPassword($password, $user->password);
            $_SESSION = [
                "id_user" => $user->id_user,
                "isAdmin" => $user->isAdmin
            ];
            Response::returnResponse(Response::LOGGED, 200, "success");
        }

        /**
         * Método responsável por enviar um email com token para recuperação de senha.
         * @param string $email Email do Usuário
         * @return void
         */
        public function sendEmailRecover(string $email) : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, retorna aviso de que ele já está logado e encerra a função
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    Response::returnResponse(Response::USER_ALREADY_LOGGED, 401, "warning");
                else
                    Response::returnResponse(Response::USER_LOGGED_DOES_NOT_EXIST, 401, "warning");

            // LIMPEZA DOS CAMPOS
            (string) $email = Form::sanatizeString($email, FILTER_SANITIZE_EMAIL);

            // VALIDAÇÃO DO EMAIL
            Form::validateEmail($email);

            // OBTENÇÃO DO MODEL E VERIFICAÇÃO DA EXISTÊNCIA DO EMAIL
            $this->getModel();
            (object) $stmtUser = $this->userDAO->select(where: "email = ?", fields: "id_user, email", params: [$email]);

            // VERIFICAÇÃO DA EXISTÊNCIA DO USUÁRIO
            if ($stmtUser->rowCount() == 0)
                Response::returnResponse(Response::EMAIL_NOT_FOUND, 400, "error");

            // OBTÊM O ID DO USUÁRIO E O SEU EMAIL E GERA O TOKEN COM DURAÇÃO DE 1 HORA
            (object) $user = $stmtUser->fetchObject($this->model::class);
            (int) $idUser = $user->id_user;
            (string) $emailUser = $user->email;
            $this->userDAO->update("id_user = $idUser", [
                "token" => bin2hex(random_bytes(78)),
                "token_expiration" => date("Y-m-d H:i:s", strtotime("+1 hour"))
            ]);

            // ENVIA O EMAIL COM O TOKEN
            (string) $token = $this->userDAO->select(where: "id_user = ?", fields: "token, email", params: [$idUser])->fetchObject($this->model::class)->token;
            (object) $objEmail = new Email($emailUser);
            (string) $bodyEmail = file_get_contents(__DIR__ . "/../Views/Users/bodyEmail.php");
            $bodyEmail = str_replace(["{{ URL }}", "{{ TOKEN }}"], [URL, $token], $bodyEmail);
            $objEmail->sendEmail("Recuperação de Senha", $bodyEmail);
            Response::returnResponse(Response::CHANGE_PASSWORD_REQUEST_SEND, 200, "success");
        }

        /**
         * Método responsável por fazer a alteração da senha do Usuário.
         * @param array $form Dados do formulário
         * @return void
         */
        public function changePassword(array $form) : void {
            if (Session::isLogged()) // Se o usuário estiver logado e existir no banco, retorna aviso de que ele já está logado e encerra a função
                if (Session::userLoggedExist((int) $_SESSION["id_user"]))
                    Response::returnResponse(Response::USER_ALREADY_LOGGED, 401, "warning");
                else
                    Response::returnResponse(Response::USER_LOGGED_DOES_NOT_EXIST, 401, "warning");

            // LIMPEZA DOS CAMPOS
            (string) $token = Form::sanatizeString($form["token"]);
            (string) $password = Form::sanatizeString($form["password"]);

            // VALIDAÇÃO DOS CAMPOS
            Form::isEmptyFields([$password]);

            // OBTENÇÃO DO MODEL E CONSULTA A EXISTÊNCIA DESSE TOKEN
            $this->getModel();
            (object) $stmtUser = $this->userDAO->select(where: "token = ?", fields: "id_user, token_expiration", params: [$token]);

            // VERIFICAÇÃO DO TOKEN
            if ($stmtUser->rowCount() == 0)
                Response::returnResponse(Response::INVALID_TOKEN, 400, "error");

            // VERIFICA A DATA DE EXPIRAÇÃO DO TOKEN
            (array) $user = $stmtUser->fetchObject($this->model::class);
            if ($user->token_expiration < date("Y-m-d H:i:s"))
                header("Location: /");

            // CRIPTOGRAFA A SENHA
            $password = Form::encryptPassword($password);

            // ALTERAÇÃO DE SENHA E RETORNO AO USUÁRIO
            (bool) $isUpdated = $this->userDAO->update("token = '$token'", [
                "token" => null,
                "token_expiration" => null,
                "password" => $password
            ]);

            $isUpdated ?
                Response::returnResponse(Response::PASSWORD_CHANGED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por cadastrar um Usuário.
         * @param array $form Dados do formulário.
         * @return void
         */
        public function create(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $name = Form::sanatizeString($form["name"]);
            (string) $email = Form::sanatizeString($form["email"], FILTER_SANITIZE_EMAIL);
            (string) $password = Form::sanatizeString($form["password"]);
            (string) $isAdmin = Form::sanatizeInt($form["isAdmin"]);
            (string) $id_course = Form::sanatizeInt($form["id_course"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O EMAIL
            Form::isEmptyFields([$name, $email, $password, $isAdmin, $id_course]);
            Form::validateEmail($email);

            // VALIDAÇÃO DO TIPO DO USUÁRIO
            if ($isAdmin != 0 && $isAdmin != 1)
                Response::returnResponse(Response::INVALID_TYPE_USER, 400, "error");

            // OBTÉM O MODELO DE USUÁRIO E VERIFICA SE O EMAIL JÁ EXISTE
            $this->getModel();
            (int) $stmtUser = $this->userDAO->select(where: "email = ?", fields: "id_user", params: [$email])->rowCount();

            if ($stmtUser == 1)
                Response::returnResponse(Response::EMAIL_ALREADY_EXISTS, 400, "error");

            // VERIFICA O ID DO CURSO
            if (!(new CourseController)->courseExists((int) $id_course))
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            // REGISTRA O USUÁRIO
            (bool) $isRegistered = $this->userDAO->insert([
                "id_course" => $id_course,
                "name" => $name,
                "email" => $email,
                "password" => Form::encryptPassword($password),
                "isAdmin" => $isAdmin
            ]);

            // RETORNA A RESPOSTA
            $isRegistered ?
                Response::returnResponse(Response::USER_REGISTERED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por atualizar um Usuário.
         * @param array $form Dados do formulário
         * @return void
         */
        public function update(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $id_user = Form::sanatizeInt($form["id_user"]);
            (string) $id_course = Form::sanatizeInt($form["id_course"]);
            (string) $name = Form::sanatizeString($form["name"]);
            (string) $email = Form::sanatizeString($form["email"], FILTER_SANITIZE_EMAIL);
            (string) $isAdmin = Form::sanatizeInt((string) $form["isAdmin"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O EMAIL
            Form::isEmptyFields([$id_user, $id_course, $name, $email, $isAdmin]);
            Form::validateEmail($email);

            // VALIDA O ID DO USUÁRIO E DO CURSO
            if (!$this->userExists((int) $id_user))
                Response::returnResponse(Response::INVALID_USER, 400, "error");

            if (!(new CourseController)->courseExists((int) $id_course))
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            // ATUALIZA O USUÁRIO E RETORNA A RESPOSTA
            (bool) $isUpdated = $this->userDAO->update("id_user = $id_user", [
                "id_course" => $id_course,
                "name" => $name,
                "email" => $email,
                "isAdmin" => $isAdmin
            ]);

            $isUpdated ?
                Response::returnResponse(Response::USER_UPDATED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por excluir um Usuário.
         * @param string $id_user ID dp Usuário
         * @return void
         */
        public function delete(string $id_user) : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança

            // LIMPEZA DOS CAMPOS
            $id_user = Form::sanatizeInt($id_user);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DO USUÁRIO
            Form::isEmptyFields([$id_user]);

            // VERIFICA SE USUÁRIO EXISTE E SE ESTÁ RELACIONADA A ALGUM PROJETO
            if (!$this->userExists((int) $id_user))
                Response::returnResponse(Response::INVALID_USER, 400, "error");

            (bool) $hasProjectsLinked = (new ProjectUserController)->userHasProjectsLinked((int) $id_user);

            if ($hasProjectsLinked)
                Response::returnResponse(Response::USER_FK_ERROR, 403, "error");

            // DELETA O USUÁRIO E RETORNA A RESPOSTA
            (bool) $isDeleted = $this->userDAO->delete("id_user = ?", [$id_user]);

            $isDeleted ?
                Response::returnResponse(Response::USER_DELETED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }
    }