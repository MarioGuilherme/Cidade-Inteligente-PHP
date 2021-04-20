<?php

    include("../../database/conexao.php");

    class Area{

        public $id;
        public $descricao;

        public function novaArea(){

            $sql = $PDO->prepare("INSERT INTO area (descricao) VALUES (:d)");
            $sql->bindParam(":d", $this->descricao);
            $sql->execute();

        }

        public function verArea(){

            $sql = $PDO->prepare("SELECT * FROM area WHERE id_area = :id");
            $sql->bindParam(":id", $this->$id);
            $sql->execute();

        }

        public function atualizarArea(){

            $sql = $PDO->prepare("UPDATE area SET descricao = :d WHERE id_area = :id");
            $sql->bindParam(":id", $this->id);
            $sql->bindParam(":d", $this->descricao);
            $sql->execute();

        }

        public function removerArea(){

            $sql = $PDO->prepare("DELETE FROM area WHERE id_area = :id");
            $sql->bindParam(":id", $this->id);
            $sql->execute();

        }

    }