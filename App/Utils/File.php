<?php

    declare(strict_types=1);

    namespace App\Utils;

    use App\Utils\Response;

    class File{
        /**
         * Método responsável por fazer a validação da extensão de cada arquivo
         * @param array $medias
         * @return void
         */
        public static function VerifyExtensions(string $name) : void {
            $extensions = ["png","jpg","jpeg","mp4"];
            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if(!in_array($extension, $extensions))
                Response::Message(INVALID_EXTENSION);
        }

        /**
         * Método responsável por fazer o upload do arquivo
         * @param array $media Dados da mídia
         * @return string Nome do arquivo
         */
        public static function UploadFile(array $media) : string {
            $folder = "src/medias";
            !file_exists(__DIR__ . "/../../$folder") ? mkdir(__DIR__ . "/../../$folder", 0755) : "";
            $extension = strtolower(pathinfo($media["name_file"], PATHINFO_EXTENSION));
            self::VerifyExtensions($media["name_file"]);
            $newName = uniqid((string) time()) . ".$extension";
            move_uploaded_file($media["tmp_name"], __DIR__ . "/../../$folder/$newName");
            return $newName;
        }

        /**
         * Método responsável por deletar um arquivo do servidor
         * @param string $path Caminho do arquivo
         * @return void
         */
        public static function DeleteMedia(string $path) : void {
            $path = __DIR__ . "/../../src/medias/$path";
            unset($path);
        }
    }