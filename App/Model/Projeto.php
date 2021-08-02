<?php

    namespace App\Model;
    use App\Server\Connection;

    class Projeto extends Connection{
        public function Select(){
            $sql = "SELECT * FROM projetos";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                return $stmt->fetchAll();
            }else{
                return GENERAL_ERROR;
            }
        }
    }