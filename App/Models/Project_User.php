<?php

    declare(strict_types=1);

    namespace App\Models;

    use App\Database\Database;
    use PDOStatement;

    /**
     * Classe herdada do Model responsável por fazer as abstrações de dados do Projeto e Usuário (N:N)
     * 
     * @author Mário Guilherme
     */
    class Project_User {
        /**
         * Método responsável por o SELECT na tabela de Projetos com Usuários (N:N)
         * @param string $join
         * @param string $where
         * @param string $order
         * @param string $limit
         * @param string $fields
         * @param array $params
         * @return PDOStatement
         */
        public static function Select(string $join = "", string $where = "", string $order = "", string $limit = "", string $fields = "*", array $params = []) : PDOStatement {
            return (new Database("projects_users"))->Select($join, $where, $order, $limit, $fields, $params);
        }

        /**
         * Método responsável por o INSERT na tabela de Projetos e Usuários (N:N)
         * @param array $params Valores a serem inseridos (Array associativo ["field" => $value])
         * @return int ID do registro inserido
         */
        public static function Insert(array $params) : int {
            return (new Database("projects_users"))->Insert($params);
        }
    }