<?php

    namespace App\Utils;

    abstract class Utils{

        /**
         * Função que verifica o tipo de usuário na sessão
         * @return array
         */
        public static function VerifyUser(){
            if(!$_SESSION["type"] == "Professor(a)"){
                return INVALID_PERMISSION;
            }
        }

        /**
         * Função que verifica se há campos vazios
         * @param array $form
         * @return void
         */
        public static function VerifyInputs($form){
            foreach($form as $key){
                if($key == ""){
                    echo json_encode(EMPTY_FIELDS);
                    exit;
                }
            }
        }

        /**
         * Função que faz a sanaização dos formulário
         * @param array $form
         * @return array
         */
        public static function SanitizerInputs($form){
            foreach($form as $key => $value){
                $form[$key] = trim(htmlspecialchars($value));
            }
            return $form;
        }

        /**
         * Função que faz o carregamento das respostas
         * @return void
         */
        public static function LoadResponses(){
            require __DIR__ . "/Responses.php";
        }

        /**
         * Função que inicia a sessão
         * @return void
         */
        public static function StartSession(){
            session_start();
        }

        /**
         * Função que destroy a sessão e redireciona para a raíz
         * @return void
         */
        public static function DestroySession(){
            self::StartSession();
            session_destroy();
            header("Location: /");
        }
    }