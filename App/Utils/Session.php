<?php

    declare(strict_types=1);

    namespace App\Utils;

    use App\Controllers\UserController;

    /**
     * Classe responsável por fazer a gestão da sessões.
     * @author Mário Guilherme
     */
    class Session {
        /**
         * Método responsável por inicializar a sessão.
         * @return void
         */
        public static function startSession() : void {
            session_start();
        }

        /**
         * Método responsável por limpar/destruir a sessão.
         * @return void
         */
        public static function destroySession() : void {
            session_destroy();
            header("Location: " . ENVIRONMENT->URL);
        }

        /**
         * Método responsável por verificar se o usuário está logado.
         * @return bool True se estiver logado e false se não estiver
         */
        public static function isLogged() : bool {
            return !empty($_SESSION);
        }

        /**
         * Método responsável por verificar se o usuário é Administrador.
         * @return bool True se o usuário for um Administrador e false se não for
         */
        public static function isAdmin() : bool {
            return $_SESSION["isAdmin"] == 1;
        }

        /**
         * Método responsável por verificar se o usuário que está na sessão existe no banco de dados.
         * @return bool True se o usuário existir e false se não
         */
        public static function userLoggedExist() : bool {
            return (new UserController)->userExists((int) $_SESSION["id_user"]);
        }

        /**
         * Método responsável por fazer todas as etapas de verificação da autenticidade do usuário.
         * Caso uma das validações falhe, ocorre um retorno em json do problema e encerra o script.
         * @return void
         */
        public static function checkAuthWithJson() : void {
            if (!Session::isLogged()) // Middleware: verifica se o usuário está logado.
                Response::returnResponse(Response::USER_NOT_LOGGED, 401, "warning");

            if (!Session::userLoggedExist()) {// Middleware: verifica se o usuário na sessão existe no banco de dados.
                self::destroySession();
                Response::returnResponse(Response::USER_LOGGED_DOES_NOT_EXIST, 401, "warning");
            }

            if (!Session::isAdmin()) // Middleware: verifica se o usuário é um Administrador.
                Response::returnResponse(Response::INVALID_PERMISSION, 403, "warning");
        }

        /**
         * Método responsável por fazer todas as etapas de verificação da autenticidade do usuário. 
         * Caso uma das validações falhe, ele realiza redirecionamentos para a página específica.
         * @return void
         */
        public static function checkAuthWithRedirect() : void {
            // Se o usúario não estiver logado ou não for administrador, redireciona para a raiz.
            if (!Session::isLogged() || !Session::isAdmin()) {
                header("Location: /");
                exit;
            }

            // Se o usuário da sessão não existe no banco, ele realiZa o logout imediatamente.
            if (!Session::userLoggedExist()) {
                header("Location: services/logout");
                exit;
            }
        }
    }