<?php

    namespace App\Database;

    class Connection{
        /**
         * Driver do Banco de Dados
         * @var string
         */
        const DRIVER = "mysql";

        /**
         * Host do Banco de Dados
         * @var string
         */
        const HOST = "localhost";

        /**
         * Nome do Banco de Dados
         * @var string
         */
        const DATABASE = "cidade_inteligente";

        /**
         * Usuário do Banco de Dados
         * @var string
         */
        const USER = "root";

        /**
         * Senha do Banco de Dados
         * @var string
         */
        const PASSWORD = "";

        /**
         * Charset dos caracteres usado no servidor em contato com o Banco de Dados
         * @var string
         */
        const CHARSET = "utf8";

        /**
         * Função que faz a coneção com o banco de dados
         * @return PDO
         */
        public static function Connect() {
            try{
               return new \PDO(self::DRIVER.":host=".self::HOST.";dbname=".self::DATABASE.";charset=".self::CHARSET, self::USER, self::PASSWORD);
            }catch(\PDOException $e){
                echo("Error connecting: {$e->getMessage()}");
            }
        }
    }