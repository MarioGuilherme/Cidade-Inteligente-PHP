<?php

    define('HOST', 'localhost');
    define('BANCO', 'cidade-inteligente');
    define('USER', 'root');
    define('SENHA', 'root');

    define('ERRO_CONEXAO', ['msg' => 'Erro interno no servidor!', 'icone' => 'error']);
    define('NAO_CADASTRADO', ['msg' => 'Perfil não cadastrado', 'icone' => 'error']);
    define('SENHA_INCORRETA', ['msg' => 'Senha incorreta', 'icone' => 'error']);
    define('CAMPOS_VAZIOS', ['msg' => 'Preencha os campos vazios', 'icone' => 'error']);
    define('SUCCESSO_LOGIN', ['msg' => 'Efetuando login', 'icone' => 'success']);

    $conexao = mysqli_connect(HOST, USER, SENHA, BANCO);