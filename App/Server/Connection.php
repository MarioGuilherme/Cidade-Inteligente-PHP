<?php

    namespace App\Server;
    include("Responses.php");
    use PDO;
    use PDOException;

    class Connection{
        const DRIVER = "mysql";
        const HOST = "localhost";
        const DATABASE = "cidade-inteligente";
        const USER = "root";
        const PASSWORD = "";

        public function __construct() {
            try{
               $this->PDO = new PDO(self::DRIVER.":host=".self::HOST.";dbname=".self::DATABASE.";charset=utf8", self::USER, self::PASSWORD);
            }catch(PDOException $e){
                echo("Error connecting: {$e->getMessage()}");
            }
        }

        public function VerifyUser(){
            if($_SESSION["tipo"] == "Professor(a)" || $_SESSION["tipo"] == "Adm"){
                return 1;
            }else{
                return INVALID_PERMISSION;
            }
        }

        public function VerifyFiles($medias){
            for ($i=0; $i < count($medias["name"]); $i++) {
                switch ($medias["error"][$i]) {
                    case 0:
                        for($u = 0; $u < count($medias["name"]); $u++){
                            if($medias["size"][$u] > 2500000){
                                $response = LARGER_SIZE;
                            }else{
                                $response = 1;
                            }
                            return $response;
                        }
                        break;
                    
                    case 1:
                        return LARGER_SERVER_SIZE;
                        break;
                }
            }
        }
        public function UploadFile($media){
            $extensions = [
                "png",
                "jpg",
                "jpeg",
                "mp4"
            ];
            $folder = "medias/";
            !file_exists("../$folder") ? mkdir("../$folder", 0755) : "";
            $tempName = $media["tmp_name"];
            $fileName = $media["name"];
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if(in_array($extension, $extensions)){
                $newName = uniqid(time()) . "." . $extension;
                move_uploaded_file($tempName, "../$folder$newName");
                return [$newName, $extension];
            }else{
                return INVALID_EXTENSION;
            }
        }
    }