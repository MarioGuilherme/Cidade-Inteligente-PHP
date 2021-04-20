<?php

    include("../../database/conexao.php");

    class Projeto{

        public $id_projeto;
        public $id_area;
        public $descricao_geral;
        public $descricao_detalhe;
        public $data;

        $PDO = Conexao::Conectar();

        public function novaProjeto(){

            $sql = $PDO->prepare("INSERT INTO projeto (id_area, descricao_geral, descricao_detalhe, data) VALUES (:id_area, :n, :d, :t, :p)");
            $sql->bindParam(":id_area", $this->id_area);
            $sql->bindParam(":dg", $this->descricao_geral);
            $sql->bindParam(":dd", $this->descricao_detalhe);
            $sql->bindParam(":d", $this->data);
            $sql->execute();

        }

        public function verProjeto(){

            $sql = $PDO->prepare("SELECT * FROM projeto WHERE id_projeto = :id_projeto");
            $sql->bindParam(":id_projeto", $this->id_projeto);
            $sql->execute();

        }

        public function atualizarProjeto(){

            $sql = $PDO->prepare("UPDATE projeto SET id_area = :id_area, descricao_geral = :dg, descricao_detalhe = dd:, data = :d WHERE id_projeto = :id_projeto");
            $sql->bindParam(":id_projeto", $this->id_projeto);
            $sql->bindParam(":id_area", $this->id_area);
            $sql->bindParam(":dg", $this->descricao_geral);
            $sql->bindParam(":dd", $this->descricao_detalhe);
            $sql->bindParam(":d", $this->data);
            $sql->execute();

        }

        public function removerProjeto(){

            $sql = $PDO->prepare("DELETE FROM projeto WHERE id_projeto = :id_projeto");
            $sql->bindParam(":id_projeto", $this->id_projeto);
            $sql->execute();

        }

    }