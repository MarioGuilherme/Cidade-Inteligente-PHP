<?php

    // ARQUIVO PARA SUPORTE NO DESENVOLVIMENTO
    // PARA MANIPULAR O SISTEMA DE SESSÕES
    session_start();
    $_SESSION = [
        "id_user" => 1,
        "name" => "Mário Guilherme",
        "email" => "marioguifatec2021@gmail.com",
      // "type" => "Aluno(a)",
        "type" => "Professor(a)",
        "course" => "Análise e Desenvolvimento de Sistemas"
    ];
    echo json_encode($_SESSION);