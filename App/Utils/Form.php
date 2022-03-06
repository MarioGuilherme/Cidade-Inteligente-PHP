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
         * @param array $fields Campos a serem verificados
         * @return void
         */
        public static function VerifyEmptyFields(array $form) : void {
            foreach($form as $field) {
                $field == "" ? Response::Message(EMPTY_FIELDS) : "";
            }
        }

        // FUTURISTICO
        /**
         * Método responsável por validar o ID de alguma entidade.
         * @param int $id ID da entidade
         * @return void
         */
        public static function ValidateID(array $form) : void {
            foreach($form as $id) {
                !is_numeric($id) || $id < 1 ? Response::Message(INVALID_ID) : "";
            }
        }

        /**
         * Método responsável por criptografar a senha.
         * @param string $password Senha a ser criptografada
         * @return string Retorna a senha criptografada
         */
        public static function EncryptPassword(string $password) : string {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Método responsável por reorganizar o array de arquivos.
         * @param array $medias Superglobal com os dados dos arquivos
         * @return array Array reorganizado com os dados dos arquivos
         */
        public static function RearrangeFiles(array $medias) : array {
            foreach($medias as $key => $all) {
                foreach($all as $i => $val) {
                    $new_array[$i][$key] = $val;    
                }    
            }
            return $new_array;
        }

        /**
         * Método responsável por verificar a senha para login.
         * @param string $password Senha a ser verificada
         * @param string $hash Hash da senha criptografada do banco de dados
         * @return void
         */
        public static function VerifyPassword(string $password, string $hash) : void {
            !password_verify($password, $hash) ? Response::Message(WRONG_PASSWORD) : "";
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
         * Método responsável por validar a área.
         * @param int $course ID da área
         * @return void
         */
        public static function ValidateArea(int $area) : void {
            !is_numeric($area) || $area < 1 ? Response::Message(INVALID_AREA) : "";
        }

        /**
         * Método responsável por validar o curso.
         * @param int $course ID do curso
         * @return void
         */
        public static function ValidateCourse(int $course) : void {
            !is_numeric($course) || $course < 1 ? Response::Message(INVALID_COURSE) : "";
        }

        /**
         * Método responsável por validar a data e hora.
         * @param string $date_time Data e hora a ser validada
         * @return void
         */
        public static function ValidateDateTime(string $date_time) : void {
            !preg_match("/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}[T][0-9]{2}[:][0-9]{2}$/", $date_time, $matches) ? Response::Message(INVALID_DATE_TIME) : "";
        }

        public static function ConvertToDate(string $date) : string {
            $date = explode("-", $date);
            $year = substr($date[0], 0, 4);
            $month = $date[1];
            $day = $date[2];
            return "$year-$month-$day";
        }

        public static function ConvertToDateTime(string $date_time) : string {
            return date("Y-m-d H:i:s", strtotime($date_time));
        }

        /**
         * Método responsável por sanatizar um campo
         * @param string $field Campo a ser sanatizado
         * @param int $filter Tipo de filtro a ser aplicado
         * @return string Retorna o campo sanatizado
         */
        public static function SanatizeField(string|int $field, int $filter) : string|int {
            return filter_var(htmlspecialchars(trim($field)), $filter);
        }
    }