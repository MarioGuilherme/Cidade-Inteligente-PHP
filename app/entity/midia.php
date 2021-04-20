<?php

    include("../../database/conexao.php");

    class Midia{

        public $id_midia;
        public $id_projeto;
        public $nome;
        public $tipo;
        public $path;
        public $descricao;

        public function novaMidia(){

            $sql = $PDO->prepare("INSERT INTO midia (id_projeto, nome, tipo, path, descricao) VALUES (:id_midia, :n, :t, :p, :d)");
            $sql->bindParam(":id_midia", $this->id_midia);
            $sql->bindParam(":n", $this->nome);
            $sql->bindParam(":t", $this->tipo);
            $sql->bindParam(":p", $this->path);
            $sql->bindParam(":d", $this->descricao);
            $sql->execute();

        }

        public function verMidia(){

            $sql = $PDO->prepare("SELECT * FROM midia WHERE id_midia = :id_midia");
            $sql->bindParam(":id_midia", $this->id_midia);
            $sql->execute();

        }

        public function atualizarMidia(){

            $sql = $PDO->prepare("UPDATE midia SET id_projeto = :id_projeto, nome = :n, tipo = :t, path = :p, descricao = d: WHERE id_midia = :id_midia");
            $sql->bindParam(":id_projeto", $this->id_projeto);
            $sql->bindParam(":id_midia", $this->id_midia);
            $sql->bindParam(":n", $this->nome);
            $sql->bindParam(":t", $this->tipo);
            $sql->bindParam(":p", $this->path);
            $sql->bindParam(":d", $this->descricao);
            $sql->execute();

        }

        public function removerMidia(){

            $sql = $PDO->prepare("DELETE FROM midia WHERE id_midia = :id_midia");
            $sql->bindParam(":id_midia", $this->id_midia);
            $sql->execute();

        }

    }