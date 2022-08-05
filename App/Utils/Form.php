<?php

    declare(strict_types=1);

    namespace App\Utils;

    use App\Utils\Response;

    /**
     * Classe responsável por fazer validações e limpezas de dados de entradas.
     * @author Mário Guilherme
     */
    class Form {
        /**
         * Método responsável por verificar se há campos vazios num array.
         * @param array $fields Campos a serem verificados
         * @return void
         */
        public static function isEmptyFields(array $fields) : void {
            foreach ($fields as $value)
                if (trim($value) == "")
                    Response::returnResponse(Response::EMPTYS_FIELDS, 400, "error");
        }

        /**
         * Método responsável por sanatizar um dado do tipo texto.
         * @param string $data Texto a ser sanatizado
         * @param int $filter Tipo de filtro a ser aplicado
         * @return string Texto sanatizado
         */
        public static function sanatizeString(string $data, int $filter = FILTER_UNSAFE_RAW) : string {
            return filter_var(htmlspecialchars(trim($data)), $filter);
        }

        /**
         * Método responsável por sanatizar um dado do tipo inteiro.
         * @param string $data Campo a ser sanatizado
         * @return string Valor sanatizado e convertido
         */
        public static function sanatizeInt(string $data) : string {
            return preg_replace("/[^0-9]/", "", $data);
        }

        /**
         * Método responsável por criptografar a senha.
         * @param string $password Senha a ser criptografada
         * @return string Senha criptografada
         */
        public static function encryptPassword(string $password) : string {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Método responsável por validar a senha durante o login.
         * @param string $password Senha a ser verificada
         * @param string $hash Senha criptografada
         * @return void
         */
        public static function verifyPassword(string $password, string $hash) : void {
            !password_verify($password, $hash) ? Response::returnResponse(Response::WRONG_PASSWORD, 400, "error") : "";
        }

        /**
         * Método responsável por validar um email.
         * @param string $email Email a ser validado
         * @return void
         */
        public static function validateEmail(string $email) : void {
            !filter_var($email, FILTER_VALIDATE_EMAIL) ? Response::returnResponse(Response::INVALID_EMAIL, 400, "error") : "";
        }

        /**
         * Método responsável por converter um dado do tipo Date no formato do formulário para o formato do banco de dados.
         * @param string $date Data a ser convertida
         * @return string Data convertida
         */
        public static function convertToDate(string $date) : string {
            (array) $date = explode("-", $date);
            (string) $year = substr($date[0], 0, 4);
            (string) $month = $date[1];
            (string) $day = $date[2];
            return "$year-$month-$day";
        }
    }