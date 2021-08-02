<?php

    // Resposta genérica quando há erro no servidor
        const GENERAL_ERROR = ["msg"=>"Erro no servidor, por favor, entre em contato", "icon"=>"error"];

    // Respostas no Login
        // Success
        const LOGGED = ["msg"=>"Login efetuado, redirecionando...", "icon"=>"success"];
        const REGISTERED = ["msg"=>"Cadastro efetuado, redirecionando...", "icon"=>"success"];

        // Error
        const INVALID_PASSWORD = ["msg"=>"Senha incorreta", "icon"=>"error"];
        const NOT_REGISTERED = ["msg"=>"Usuário não cadastrado", "icon"=>"error"];

    // Resposta no cadastro
        // Error
        const EMAIL_ALREADY_EXISTS = ["msg"=>"Email já está sendo usado", "icon"=>"error"];

    // Resposta genérica em formulários
        // Error
        const INVALID_EMAIL = ["msg"=>"Email inválido!", "icon"=>"error"];
        const EMPTY_FIELDS = ["msg"=>"Preencha o(s) campo(s) vazio(s)","icon"=>"error"];

    const ERRO_CONEXAO = ["msg"=>"Erro interno no servidor!","icon"=>"error"];
    const SUCCESSO_CADASTRO = ["msg"=>"Cadastrado! Efetuando login","icon"=>"success"];