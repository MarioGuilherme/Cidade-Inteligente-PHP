<?php

    // ARQUIVO PARA SUPORTE NO DESENVOLVIMENTO
    // PARA MANIPULAR O SISTEMA DE SESSÕES
    session_start();
    $_SESSION = [
        "id_user" => 32,
        "id_course" => 1,
        "name" => "Lucas",
        "email" => "lucas@gmail.com",
     // "type" => "Aluno(a)",
        "type" => "Professor(a)",
        "course" => "Análise e Desenvolvimento de Sistemas"
    ];
    echo json_encode($_SESSION);