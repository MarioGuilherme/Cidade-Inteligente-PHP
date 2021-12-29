<?php

    declare(strict_types=1);

    namespace App\Utils;

    use App\Utils\Response;

    /**
     * Classe responsável por tratar dados de um formulário
     *
     * @author Mário Guilherme
     */
    class Form {
        /**
         * Método responsável por verificar se existe algum campo vazio num formulário
         * @param array $fields Campos a serem verificados
         * @return void
         */
        public static function VerifyEmptyFields(array $form) : void {
            foreach($form as $field) {
                $field == "" ? Response::Message(EMPTY_FIELDS) : "";
            }
        }

        /**
         * Método responsável por criptografar a senha
         * @param string $password Senha a ser criptografada
         * @return string Retorna a senha criptografada
         */
        public static function EncryptPassword(string $password) : string {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Método responsável por validar o email
         * @param string $email Email a ser validado
         * @return void Retorna true se o email for válido
         */
        public static function ValidateEmail(string $email) : void {
            !filter_var($email, FILTER_VALIDATE_EMAIL) ? Response::Message(INVALID_EMAIL) : "";
        }

        /**
         * Método responsável por sanatizar um campo
         * @param string $field Campo a ser sanatizado
         * @param int $filter Tipo de filtro a ser aplicado
         * @return string Retorna o campo sanatizado
         */
        public static function SanatizeField(string $field, int $filter) : string {
            return filter_var(htmlspecialchars(trim($field)), $filter);
        }
    }