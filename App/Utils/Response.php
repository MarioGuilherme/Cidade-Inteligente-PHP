<?php

    declare(strict_types=1);

    namespace App\Utils;

    /**
     * Classe responsável por controlar todas as possíveis respostas do servidor e tratá-las em determinadas situações.
     * @author Mário Guilherme
     */
    class Response {
        // Servidor
        const GENERAL_ERROR = "Erro no servidor, por favor, entre em contato.";
        const METHOD_NOT_ALLOWED = "Método não permitido.";

        // Formulário
        const EMPTYS_FIELDS = "Por favor, preencha todos os campos.";
        const INVALID_EMAIL = "Email inválido!";
        const INVALID_TYPE_USER = "Tipo de usuário inválido!";
        const EMAIL_ALREADY_EXISTS = "Email já cadastrado!";

        // Projetos
        const EMPTY_USERS_OR_MEDIA = "Por favor, selecione pelo menos um usuário e um arquivo para o projeto.";
        const PROJECT_DELETED = "Projeto deletado com sucesso!";
        const PROJECT_UPDATED = "Projeto atualizado com sucesso!";
        const INVALID_PROJECT = "ID do projeto inválido. Reinicie a página e tente novamente.";

        // Mídias
        const INVALID_EXTENSION = "Extensão inválida, apenas jpg, jpeg, png e mp4 são permitidas.";
        const FILE_TOO_BIG = "O tamanho da mídia excede 2.5MB!";

        // Áreas
        const AREA_REGISTERED = "Área cadastrada com sucesso.";
        const AREA_DELETED = "Área deletada com sucesso.";
        const AREA_UPDATED = "Área atualizada com sucesso.";
        const AREA_FK_ERROR = "Este tipo de área está sendo usado em um ou mais projetos.";
        const INVALID_AREA = "ID da área inválida. Reinicie a página e tente novamente.";

        // Cursos
        const COURSE_REGISTERED = "Curso cadastrado com sucesso.";
        const COURSE_DELETED = "Curso deletado com sucesso.";
        const COURSE_UPDATED = "Curso atualizado com sucesso.";
        const COURSE_FK_ERROR = "Este curso está relacionado a um ou mais usuário ou projeto.";
        const INVALID_COURSE = "ID do curso inválido. Reinicie a página e tente novamente.";

        // Usuários
        const USER_NOT_FOUND = "Usuário não cadastrado";
        const USER_REGISTERED = "Usuário cadastrado com sucesso.";
        const USER_DELETED = "Usuário deletado com sucesso.";
        const USER_UPDATED = "Usuário atualizado com sucesso.";
        const USER_FK_ERROR = "Este usuário está relacionado a um ou mais projeto.";
        const INVALID_USER = "ID do usuário inválido. Reinicie a página e tente novamente.";

        // Login/Recuperação de senha
        const WRONG_PASSWORD = "Senha incorreta";
        const LOGGED = "Login efetuado, redirecionando...";
        const EMAIL_NOT_FOUND = "Email não encontrado";
        const CHANGE_PASSWORD_REQUEST_SEND = "Foi enviado um link de recuperação de senha neste email!";
        const INVALID_TOKEN = "Token inválido!";
        const PASSWORD_CHANGED = "Senha alterada com sucesso!";

        // Sessão
        const INVALID_PERMISSION = "Você não têm permissão. Área restrita.";
        const USER_NOT_LOGGED = "Realize o seu login.";
        const USER_LOGGED_DOES_NOT_EXIST = "Sua sessão contêm um usuário inexistente, recarregue a página.";
        const USER_ALREADY_LOGGED = "Você já está logado.";

        /**
         * Método responsável retornar uma resposta e encerrar o script.
         * @param string|array $message Mensagem ou dados a ser retornado
         * @param string $icon Ícone do SweetAlert
         * @param int $httpCode Código de status HTTP
         * @return void
         */
        public static function returnResponse(string|array $message, int $httpCode = 200, string $icon = null) : void {
            http_response_code($httpCode);

            if (is_array($message))
                die(json_encode($message));

            if ($icon != null)
                die(json_encode(["message" => $message, "icon" => $icon]));
        }
    }