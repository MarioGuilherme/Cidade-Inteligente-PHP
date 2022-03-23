<?php

    declare(strict_types=1);

    namespace App\Utils;

    /**
     * Classe responsável por fazer o controle dos uploads de arquivos
     *
     * @author Mário Guilherme
     */
    class File {
        /**
         * Extensões permitidas
         * @var Array
         */
        public static Array $extensionsAllowed = [
            "png",
            "jpg",
            "jpeg",
            "mp4"
        ];

        /**
         * Diretório onde serão armazenados os arquivos
         * @var String
         */
        public static String $directory = __DIR__ . "/../../medias/";

        /**
         * Nome do arquivo
         * @var String
         */
        public static String $name;

        /**
         * Diretório temporário do arquivo
         * @var String
         */
        public static String $tmpName;

        /**
         * Extensão do arquivo
         * @var String
         */
        public static String $extension;   

        /**
         * Código de erro durante o upload do arquivo
         * @var Int
         */
        public static Int $error;

        /**
         * Tamanho do arquivo
         * @var Int
         */
        public static Int $size;

        /**
         * Método responsável por setar os atributos da classe.
         * @param Array $file Dados do arquivo
         * @return void
         */
        public static function SetFile(Array $file) : void {
            self::$name = $file["name"];
            self::$tmpName = $file["tmp_name"];
            self::$extension = self::GetExtension($file["name"]);
            self::$error = $file["error"];
            self::$size = $file["size"];
        }

        /**
         * Método responsável por retornar a extensão do arquivo.
         * @param String $name Nome do arquivo
         * @return String Extensão do arquivo
         */
        private static function GetExtension(String $name) : String {
            return strtolower(pathinfo($name, PATHINFO_EXTENSION));
        }

        /**
         * Método responsável por fazer as validações do arquivo como a existência de arquivo anexado, extensão, tamanho e erros de upload.
         * @return void
         */
        public static function VerifyFile() : void {
            if(self::$name == "")
                Response::Message(FILE_NOT_SEND);
            if(self::$error != UPLOAD_ERR_OK)
                Response::Message(ERROR_UPLOAD);
            if(self::$size > 2.5 * (1024 * 1024))
                Response::Message(FILE_TOO_BIG);
        }

        /**
         * Método responsável por renomear o arquivo com um padrão de nome.
         * @return void
         */
        private static function RenameFile() : void {
            self::$name = uniqid((String) time()) . "." . self::$extension;
        }

        /**
         * Método responsável por mover o arquivo já verificado e renomeado para a pasta de destino.
         * @return String Nome do arquivo
         */
        public static function MoveFile() : String {
            self::VerifyFile();
            self::RenameFile();
            if(!file_exists(self::$directory))
                mkdir(self::$directory, 0777, true);
            if(in_array(self::$extension, self::$extensionsAllowed))
                if(move_uploaded_file(self::$tmpName, self::$directory.self::$name))
                    return self::$name;
                else
                    Response::Message(ERROR_UPLOAD);
        }

        /**
         * Método responsável por deletar o arquivo da pasta de destino.
         * @param String $file Nome do arquivo
         * @return void
         */
        public static function DeleteFile(String $file) : void {
            unlink(self::$directory . $file);
        }
    }