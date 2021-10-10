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
         * Construtor da classe que inicializa criando o objeto de acesso ao banco de dados
         * @return void
         */
        public function __construct(){
            $this->MODEL = new UserDAO();
        }

        /**
         * Função responsável por validar os dados e criar o objeto de usuário,
         * passando para a camada de modelo para fazer o login
         * @param array $form
         * @return array
         */
        public function Login($form){
            Utils::VerifyInputs($form);
            if(filter_var($form["email"], FILTER_VALIDATE_EMAIL)){
                $form = Utils::SanitizerInputs($form);
                $user = new User();
                $user->setEmail($form["email"]);
                $user->setPassword($form["password"]);
                $dao = $this->MODEL->SelectOne($user);
                return $dao ? LOGGED : $dao;
            }else{
                return INVALID_EMAIL;
            }
        }

        /**
         * Função responsável por fazer a validação dos dados e criar o objeto de usuário
         * e em seguida enviar à camada de modelo
         * @param array $form
         * @return array
         */
        public function Register($form){
            Utils::VerifyUser();
            Utils::VerifyInputs($form);
            if(filter_var($form["email"], FILTER_VALIDATE_EMAIL)){
                if($form["id_course"] > 0 && $form["id_course"] < 7 && is_numeric($form["id_course"])){
                    $form = Utils::SanitizerInputs($form);
                    $user = new User();
                    $user->setId_course($form["id_course"]);
                    $user->setName($form["name"]);
                    $user->setEmail($form["email"]);
                    $user->setPassword(password_hash($form["password"], PASSWORD_DEFAULT));
                    $user->setType($form["type"]);
                    return $this->MODEL->Create($user);
                }
            }else{
                return INVALID_EMAIL;
            }
        }

        /**
         * Função que inclui o formulário de usuário na página
         * @return void
         */
        public function LoadForm(){
            require __DIR__ . "/../View/form-user.html";
        }
    }