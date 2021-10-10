<?php

    namespace App\Utils;

    class File{
        /**
         * Função que faz a validação da extensão de cada arquivo
         * @param array $medias
         * @return void
         */
        public static function VerifyExtensions($medias){
            $extensions = ["png","jpg","jpeg","mp4"];
            for ($i = 0; $i < count($medias); $i++) {
                $extension = strtolower(pathinfo($medias[$i]["name"], PATHINFO_EXTENSION));
                if(!in_array($extension, $extensions)){
                    echo json_encode(INVALID_EXTENSION);
                    exit;
                }
            }
        }

        /**
         * Função responsável por fazer o upload do arquivo
         * @param array $media
         */
        public static function UploadFile($media){
            $folder = "/../medias/";
            !file_exists("..$folder") ? mkdir("..$folder", 0755) : "";
            $extension = strtolower(pathinfo($media["name"], PATHINFO_EXTENSION));
            $newName = uniqid(time()) . "." . $extension;
            move_uploaded_file($media["tmp_name"], "..$folder$newName");
            return $newName;
        }

        /**
         * Função responsável por deletar um arquivo do servidor
         * @param string $path
         * @return void
         */
        public static function DeleteMedia($path){
            require(__DIR__ . "/../../medias/$path");
        }
    }