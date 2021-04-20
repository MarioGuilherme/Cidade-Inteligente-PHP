<?php

    include("../../database/conexao.php");

    class Usuario{

        public $id_usuario;
        public $nome;
        public $email;
        public $senha;
        public $tipo;
        public $nivel;

        public function novoUsuario(){

            $sql = $PDO->prepare("INSERT INTO usuario (nome, email, senha, tipo, nivel) VALUES (:n, :e, :s, :t, :nv)");
            $sql->bindValeu(":n", '$nome');
            $sql->bindValeu(":e", '$email');
            $sql->bindValeu(":s", '$senha');
            $sql->bindValeu(":t", '$tipo');
            $sql->bindValeu(":nv", '$nivel');
            $sql->execute();

        }

        public function verUsuario(){

            $sql = $PDO->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
            $sql->bindParam(":id_usuario", $this->id_usuario);
            $sql->execute();

        }

        public function atualizarUsuario(){

            $sql = $PDO->prepare("UPDATE usuario SET nome = :nome, email = :e, senha = :s, tipo = :t, nivel = :nv WHERE id_usuario = :id_usuario");
            $sql->bindParam(":id_usuario", $this->id_usuario);
            $sql->bindParam(":n", $this->nome);
            $sql->bindParam(":e", $this->email);
            $sql->bindParam(":s", $this->senha);
            $sql->bindParam(":t", $this->tipo);
            $sql->bindParam(":nv", $this->nivel);
            $sql->execute();

        }

        public function removerUsuario(){

            $sql = $PDO->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
            $sql->bindParam(":id_usuario", $this->id_usuario);
            $sql->execute();

        }

    }