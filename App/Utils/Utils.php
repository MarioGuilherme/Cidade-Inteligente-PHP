<?php

    namespace App\Utils;

    abstract class Utils{

        /**
         * Método responsável por verificar o tipo de usuário da sessão
         * @return array
         */
        public static function VerifyUser(){
            if($_SESSION["type"] != "Professor(a)"){
                self::ReturnResponse(INVALID_PERMISSION);
            }
        }

        /**
         * Método responsável por verificar se há campos vazios em um array e em seguida retornar uma mensagem de erro
         * @param array $form
         * @return void
         */
        public static function VerifyInputs($form){
            foreach($form as $key){
                if($key == ""){
                    self::ReturnResponse(EMPTY_FIELDS);
                }
            }
        }

        /**
         * Método responsável por fazer a sanatização de um campo
         * @param string $field
         * @return string
         */
        public static function SanitizeInput($field){
            return trim(htmlspecialchars($field));
        }

        /**
         * Método responsável por carregar as respostas
         * @return void
         */
        public static function LoadResponses(){
            require __DIR__ . "/Responses.php";
        }

        /**
         * Método responsável retornar uma respostas
         * @param array $response
         * @return void
         */
        public static function ReturnResponse($response){
            echo json_encode($response);
            exit;
        }

        /**
         * Método responsável por iniciar a sessão
         * @return void
         */
        public static function StartSession(){
            session_start();
        }

        /**
         * Método responsável por finiliar a sessão e redireciona para a raíz do projeto
         * @return void
         */
        public static function DestroySession(){
            self::StartSession();
            session_destroy();
            header("Location: /");
        }
    }