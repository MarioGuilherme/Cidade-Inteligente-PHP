<?php

    include('../src/banco/conexao.php');

    $post = $_POST;

    try{

        $cmd = $pdo->prepare("INSERT INTO area (descricao) VALUES (:d)");

        $cmd->bindParam(":n", $post['descricao']);

        $cmd->execute();

    }catch(PDOException $erro){
        echo("Erro no banco de dados: {$erro->getMessage()}");
    }catch(Exception $erro){
        echo("Erro genérico: {$erro->getMessage()}");
    }