<?php

    include('../banco/conexao.php');

    try{

        $sql = $pdo->prepare("DELETE FROM usuario WHERE codUsuario = :id");

        $sql->bindValue(":id", 3);

        $sql->execute();

    }catch(PDOException $erro){
        echo("Erro no banco de dados: {$erro->getMessage()}");
    }catch(Exception $erro){
        echo("Erro genérico: {$erro->getMessage()}");
    }