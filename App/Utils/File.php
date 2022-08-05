<?php

    declare(strict_types=1);

    namespace App\Utils;

    /**
     * Classe responsável por fazer o controle das mídias no servidor.
     * @author Mário Guilherme
     */
    class File {
        /**
         * Extensões permitidas no servidor.
         * @var array
         */
        private static array $extensionsAllowed = [
            "png",
            "jpg",
            "jpeg",
            "mp4"
        ];

        /**
         * Diretório onde serão armazenados as mídias.
         * @var string
         */
        public static string $directory = __DIR__ . "/../../medias/";

        /**
         * Método responsável por criar o arquivo no servidor e retornar o nome do arquivo gerado.
         * @param string $base64 Base64 da mídia
         * @param string $type Tipo da mídia
         * @return string Nome do arquivo
         */
        public static function createFile(string $base64, string $type) : string {
            if (!file_exists(self::$directory)) mkdir(self::$directory);
            (string) $fileName = uniqid((string) time()) . "." . self::getExtension($type);
            (string) $path = self::$directory . $fileName;
            file_put_contents($path, base64_decode($base64));
            return $fileName;
        }

        /**
         * Método responsável por atualizar o conteúdo binário de um mídia sem alterar seu nome.
         * @param string $fileName Nome do arquivo
         * @param string $base64 Base64 novo que irá sobrescrever o conteúdo antigo
         * @return void
         */
        public static function updateFileContent(string $fileName, string $base64) : void {
            (string) $path = self::$directory . $fileName;
            file_put_contents($path, base64_decode($base64));
        }

        /**
         * Método responsável por validar a extensão e o tamanho do arquivo.
         * @param array $file Dados do arquivo
         * @return void
         */
        public static function isValidFile(array $file) : void {
            if (!in_array(self::getExtension($file["type"]), self::$extensionsAllowed)) // VALIDA A EXTENSÃO DO ARQUIVO
                Response::returnResponse(Response::INVALID_EXTENSION, 400, "error");
            if (self::getSize($file["base64"]) > 2621440) // VALIDA O TAMANHO DO ARQUIVO
                Response::returnResponse(Response::FILE_TOO_BIG, 400, "error");
        }

        /**
         * Método responsável por retornar o tamanho do arquivo em bytes.
         * @param string $base64 Base64 do arquivo
         * @return float Tamanho do arquivo em bytes
         */
        public static function getSize(string $base64) : float {
            return (float) (strlen($base64) * 3 / 4);
        }

        /**
         * Método responsável por obter a extensão do arquivo.
         * @param string $type Tipo do arquivo
         * @return string Extensão do arquivo
         */
        public static function getExtension(string $type) : string {
            return (string) explode("/", $type)[1];
        }

        /**
         * Método responsável por deletar um arquivo das pastas de mídias.
         * @param string $fileName Nome do arquivo
         * @return void
         */
        public static function deleteFile(string $fileName) : void {
            unlink(self::$directory . $fileName);
        }
    }