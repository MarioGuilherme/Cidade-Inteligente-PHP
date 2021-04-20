<?php

    include('../src/banco/conexao.php');

    $post = $_POST;

    try{

        $cmd = $pdo->prepare("INSERT INTO usuario (nome, email, senha, tipo, nivel) VALUES (:n, :e, :s, :t, :nv)");

        $cmd->bindParam(":n", $post['nome']);
        $cmd->bindParam(":e", $post['email']);
        $cmd->bindParam(":s", $post['senha']);
        $cmd->bindParam(":t", $post['tipo']);
        $cmd->bindParam(":nv", $post['nivel']);

        $cmd->execute();

    }catch(PDOException $erro){
        echo("Erro no banco de dados: {$erro->getMessage()}");
    }catch(Exception $erro){
        echo("Erro genérico: {$erro->getMessage()}");
    }