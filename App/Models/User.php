<?php

    declare(strict_types=1);

    namespace App\Models;

    /**
     * Modelo da entidade Usuário.
     * @author Mário Guilherme
     */
    class User {
        public int $id_user;
        public int $id_course;
        public string $name;
        public string $email;
        public string $password;
        public int $isAdmin;
        public string $token;
        public string $token_expiration;
    }