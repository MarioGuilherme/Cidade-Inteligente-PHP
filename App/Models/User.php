<?php

    declare(strict_types=1);

    namespace App\Models;

    use App\Database\Database;
    use PDOStatement;

    /**
     * Classe herdada do Model responsável por fazer as abstrações de dados do Usuário
     * 
     * @author Mário Guilherme
     */
    class User {
        /**
         * Método responsável por o SELECT na tabela de Usários
         * @param string $join
         * @param string $where
         * @param string $order
         * @param string $limit
         * @param string $fields
         * @param string $params
         * @return PDOStatement
         */
        public static function Select(string $join = "", string $where = "", string $order = "", string $limit = "", string $fields = "*", array $params = []) : PDOStatement {
            return (new Database("users"))->Select($join, $where, $order, $limit, $fields, $params);
        }

        /**
         * Método responsável por o INSERT na tabela de Usários
         * @param array $params Valores a serem inseridos (Array associativo ["field" => $value])
         * @return int ID do usuário cadastrado
         */
        public static function Insert(array $params) : int {
            return (new Database("users"))->Insert($params);
        }

        /**
         * Método responsável por o UPDATE na tabela de Usários
         * @param string $where Condição para atualização
         * @param array $values Valores a serem atualizados (Array associativo ["field" => $value])
         * @return bool
         */
        public static function Update(string $where, array $values) : bool {
            return (new Database("users"))->Update($where, $values);
        }
    }