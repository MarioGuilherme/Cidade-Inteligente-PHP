<?php

    include('../banco/conexao.php');

    try{

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE codUsuario = :id");

        $sql->bindValue(":id", 1);
        $sql->execute();
        $retorno = $sql->fetch(PDO::FETCH_ASSOC);

        foreach($retorno as $chave => $valor){
            echo("{$chave}: $valor <br>");
        }

    }catch(PDOException $erro){
        echo("Erro no banco de dados: {$erro->getMessage()}");
    }catch(Exception $erro){
        echo("Erro genérico: {$erro->getMessage()}");
    }