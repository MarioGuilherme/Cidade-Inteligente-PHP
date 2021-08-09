<?php

    // Resposta genérica quando há erro no servidor
        const GENERAL_ERROR = ["msg"=>"Erro no servidor, por favor, entre em contato", "icon"=>"error"];
        const INVALID_PERMISSION = ["msg"=>"Você não tem permissão, apenas Professores!", "icon"=>"error"];

    // Respostas no Login
        // Success
        const LOGGED = ["msg"=>"Login efetuado, redirecionando...", "icon"=>"success"];
        const USER_REGISTERED = ["msg"=>"Usuário cadastrado!", "icon"=>"success"];

        // Error
        const INVALID_PASSWORD = ["msg"=>"Senha incorreta", "icon"=>"error"];
        const NOT_REGISTERED = ["msg"=>"Usuário não cadastrado", "icon"=>"error"];

    // Resposta no cadastro
        // Error
        const EMAIL_ALREADY_EXISTS = ["msg"=>"Email já cadastrado!", "icon"=>"error"];

    // Resposta genérica em formulários
        // Error
        const INVALID_EMAIL = ["msg"=>"Email inválido!", "icon"=>"error"];
        const EMPTY_FIELDS = ["msg"=>"Preencha o(s) campo(s) vazio(s)","icon"=>"error"];

    const ERRO_CONEXAO = ["msg"=>"Erro interno no servidor!","icon"=>"error"];
    const SUCCESSO_CADASTRO = ["msg"=>"Cadastrado! Efetuando login","icon"=>"success"];
    const INVALID_EXTENSION = ["msg"=>"Extensão inválida!","icon"=>"error"];
    const PROJECT_CREATED = ["msg"=>"Projeto Criado com êxito!","icon"=>"success"];
    const LARGER_SIZE = ["msg"=>"Tamanho do arquivo excede o limite!","icon"=>"error"];
    const LARGER_SERVER_SIZE = ["msg"=>"Tamanho do arquivo excede o limite do servidor!","icon"=>"error"];
    const MEDIA_DELETED = ["msg"=>"Mídia Deletada!","icon"=>"success"];
    const NOTHING_FOUND = "<h2>Nenhum projeto criado!</h2>";