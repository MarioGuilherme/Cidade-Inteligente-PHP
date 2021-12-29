<?php

    declare(strict_types=1);

    namespace App\Utils;

    /**
     * Classe responsável por fazer a gestão da sessões
     *
     * @author Mário Guilherme
     */
    class Session {
        /**
         * Método responsável por inicializar a sessão
         * @param string $url URL a ser redirecionada
         * @return void
         */
        public static function Redirect(string $url) : void {
            header("Location: $url");
        }

        /**
         * Método responsável por inicializar a sessão
         * @return void
         */
        public static function StartSession() : void {
            session_status() == PHP_SESSION_NONE ? session_start() : "";
        }

        /**
         * Método responsável por destruir a sessão
         * @return void
         */
        public static function DestroySession() : void {
            if(session_status() == PHP_SESSION_NONE) {
                self::StartSession();
                session_destroy();
            }else
                session_destroy();
            self::Redirect("../../projetos");
        }

        /**
         * Método responsável por verificar se existe uma sessão
         * @return bool Retorna true se existir uma sessão e false se não existir
         */
        public static function VerifySession() : bool {
            self::StartSession();
            return empty($_SESSION) ? false : true;
        }

        /**
         * Método responsável por verificar se há algum
         * usuário logado e se ele é um professor
         * @return bool Retorna true se o usuário for um professor e false se não for
         */
        public static function VerifyAdm() : bool {
            if(!self::VerifySession())
                return true;
            else {
                if($_SESSION["type"] == "Professor(a)") {
                    return true;
                }
            }
            return false;
        }
    }