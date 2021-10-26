<?php

    namespace App\Controller;
    use App\Model\DAO\UserDAO;
    use App\Model\Classes\User;
    use App\Utils\Utils;

    class UserController{
        /**
         * Objeto de acesso ao banco de dados
         * @var UserDAO
         */
        private $MODEL;

        /**
         * Construtor da classe que inicializa criando o objeto de acesso
         * ao banco de dados, carrega as respostas e inicia a sessão
         * @return void
         */
        public function __construct(){
            $this->MODEL = new UserDAO();
            Utils::StartSession();
            Utils::LoadResponses();
        }

        /**
         * Função responsável por sanatizar o email e senha, obter os
         * dados do usuário, validar senha e autenticar o mesmo
         * @param array $form
         * @return void
         */
        public function Login($form){
            Utils::VerifyInputs($form);
            $email = substr(Utils::SanitizeInput($form["email"]), 0, 100);
            $password = substr(Utils::SanitizeInput($form["password"]), 0, 60);
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $user = new User();
                $user->setEmail($email);
                $user->setPassword($password);
                $datas = $this->MODEL->SelectOne($user);
                if(!empty($datas)){
                    if(password_verify($user->getPassword(), $datas["password"])){
                        $_SESSION = [
                            "id_user" => $datas["id_user"],
                            "id_course" => $datas["id_course"],
                            "name" => $datas["name"],
                            "email" => $datas["email"],
                            "type" => $datas["type"],
                            "course" => $datas["course"]
                        ];
                        Utils::ReturnResponse(LOGGED);
                    }else
                        Utils::ReturnResponse(WRONG_PASSWORD);
                }else
                    Utils::ReturnResponse(USER_NOT_FOUND);
            }else
                Utils::ReturnResponse(INVALID_EMAIL);
        }

        /**
         * Função responsável por sanatizar todos os campos para fazer os setters
         * do objeto de usuário par aser enviado à camada Model para sua Inserção
         * @param array $form
         * @return void
         */
        public function Register($form){
            Utils::VerifyUser();
            Utils::VerifyInputs($form);
            $name = substr(Utils::SanitizeInput($form["name"]), 0, 100);
            $email = substr(Utils::SanitizeInput($form["email"]), 0, 60);
            $password = password_hash(Utils::SanitizeInput($form["password"]), PASSWORD_DEFAULT);
            $type = substr(Utils::SanitizeInput($form["type"]), 0, 12);
            $course = substr(Utils::SanitizeInput($form["course"]), 0, 1);
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                if(is_numeric($course) && $course > 1 && $course <= 7){
                    $user = new User();
                    $user->setName($name);
                    $user->setEmail($email);
                    $user->setPassword($password);
                    $user->setType($type);
                    $user->setId_course($course);
                    $this->MODEL->Create($user);
                }else
                    Utils::ReturnResponse(INVALID_COURSE);
            }else
                Utils::ReturnResponse(INVALID_EMAIL);
        }
    }