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
         * Método responsável por verificar se existe algum campo vazio num formulário.
         * @param Array $fields Campos a serem verificados
         * @return void
         */
        public static function VerifyEmptyFields(Array $form) : void {
            foreach ($form as $field) {
                (String) $field == "" ? Response::Message(EMPTY_FIELDS) : "";
            }
        }

        // FUTURISTICO
        /**
         * Método responsável por validar o ID de alguma entidade.
         * @param Int $id ID da entidade
         * @return void
         */
        public static function ValidateID(Array $form) : void {
            foreach ($form as $id) {
                !is_numeric($id) || $id < 1 ? Response::Message(INVALID_ID) : "";
            }
        }

        /**
         * Método responsável por criptografar a senha.
         * @param String $password Senha a ser criptografada
         * @return String Retorna a senha criptografada
         */
        public static function EncryptPassword(String $password) : String {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Método responsável por reorganizar o Array de arquivos.
         * @param Array $medias Superglobal com os dados dos arquivos
         * @return Array Array reorganizado com os dados dos arquivos
         */
        public static function RearrangeFiles(Array $medias) : Array {
            foreach ($medias as $key => $all) {
                foreach ($all as $i => $val) {
                    (Array) $new_array[$i][$key] = $val;    
                }    
            }
            return $new_array;
        }

        /**
         * Método responsável por verificar a senha para login.
         * @param String $password Senha a ser verificada
         * @param String $hash Hash da senha criptografada do banco de dados
         * @return void
         */
        public static function VerifyPassword(String $password, String $hash) : void {
            !password_verify($password, $hash) ? Response::Message(WRONG_PASSWORD) : "";
        }

        /**
         * Método responsável por validar o email
         * @param String $email Email a ser validado
         * @return void Retorna true se o email for válido
         */
        public static function ValidateEmail(String $email) : void {
            !filter_var($email, FILTER_VALIDATE_EMAIL) ? Response::Message(INVALID_EMAIL) : "";
        }

        /**
         * Método responsável por validar a área.
         * @param Int $course ID da área
         * @return void
         */
        public static function ValidateArea(Int $area) : void {
            !is_numeric($area) || $area < 1 ? Response::Message(INVALID_AREA) : "";
        }

        /**
         * Método responsável por validar o curso.
         * @param Int $course ID do curso
         * @return void
         */
        public static function ValidateCourse(Int $course) : void {
            !is_numeric($course) || $course < 1 ? Response::Message(INVALID_COURSE) : "";
        }

        /**
         * Método responsável por validar a data e hora.
         * @param String $date_time Data e hora a ser validada
         * @return void
         */
        public static function ValidateDateTime(String $date_time) : void {
            !preg_match("/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}[T][0-9]{2}[:][0-9]{2}$/", $date_time, $matches) ? Response::Message(INVALID_DATE_TIME) : "";
        }

        public static function ConvertToDate(String $date) : String {
            (Array) $date = explode("-", $date);
            (String) $year = substr($date[0], 0, 4);
            (String) $month = $date[1];
            (String) $day = $date[2];
            return "$year-$month-$day";
        }

        public static function ConvertToDateTime(String $date_time) : String {
            return date("Y-m-d H:i:s", strtotime($date_time));
        }

        /**
         * Método responsável por sanatizar um campo
         * @param String $field Campo a ser sanatizado
         * @param Int $filter Tipo de filtro a ser aplicado
         * @return String|Int Campo sanatizado
         */
        public static function SanatizeField(String|Int $field, Int $filter) : String|Int {
            return filter_var(htmlspecialchars(trim($field)), $filter);
        }
    }