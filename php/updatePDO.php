<?php

    include('../banco/conexao.php');

    try{

        $sql = $pdo->prepare("UPDATE usuario SET nome = :n, email = :e, senha = :s, tipo_User = :tU, nivel = :nv WHERE codUsuario = :id");

        $sql->bindValue(":n", "Ana");
        $sql->bindValue(":e", "ana@gmail.com");
        $sql->bindValue(":s", "456");
        $sql->bindValue(":tU", "Aluna");
        $sql->bindValue(":nv", "Mestrado");
        $sql->bindValue(":id", 2);
        $sql->execute();

    }catch(PDOException $erro){
        echo("Erro no banco de dados: {$erro->getMessage()}");
    }catch(Exception $erro){
        echo("Erro genérico: {$erro->getMessage()}");
    }