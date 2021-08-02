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
        const PASSWORD = "root";

        public function __construct() {
            try{
               $this->PDO = new PDO(self::DRIVER.":host=".self::HOST.";dbname=".self::DATABASE.";charset=utf8", self::USER, self::PASSWORD);
            }catch(PDOException $e){
                echo("Error connecting: {$e->getMessage()}");
            }
        }
    }