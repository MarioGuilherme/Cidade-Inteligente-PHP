<?php

    declare(strict_types=1);

    namespace App\Models;

    use App\Database\Database;
    use PDOStatement;

    /**
     * Classe de Modelo responsável por fazer as abstrações de dados do Projeto.
     * 
     * @author Mário Guilherme
     */
    class Project {
        /**
         * Método responsável por realizar seleções na tabela de Projetos.
         * @param String $join Join com outras tabelas
         * @param String $where Condição para o SELECT
         * @param String $order Ordenação dos resultados
         * @param String $limit Limite de resultados
         * @param String $fields Campos da tabela
         * @param Array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement
         */
        public static function Select(String $join = "", String $where = "", String $order = "", String $limit = "", String $fields = "*", Array $params = []) : PDOStatement {
            return (new Database("projects"))->Select($join, $where, $order, $limit, $fields, $params);
        }

        /**
         * Método responsável por realizar inserções na tabela de Projetos.
         * @param Array $values Valores a serem inseridos (Array associativo ["field" => $value])
         * @return Int ID do projeto cadastrado
         */
        public static function Insert(Array $params) : Int {
            return (new Database("projects"))->Insert($params);
        }

        /**
         * Método responsável por realizar atualizações na tabela de Projetos.
         * @param String $where Condição para atualização
         * @param Array $values Valores a serem atualizados (Array associativo ["field" => $value])
         * @return Bool Retorna true se a atualização for bem sucedida
         */
        public static function Update(String $where, Array $values) : Bool {
            return (new Database("projects"))->Update($where, $values);
        }

        /**
         * Método responsável por realizar exclusões na tabela de Projetos.
         * @param String $where Condição para exclusão
         * @param Array $params Parâmetros da SQL (Array [$value])
         * @return Bool Retorna true se a exclusão for bem sucedida
         */
        public static function Delete(String $where, Array $params) : Bool {
            return (new Database("projects"))->Delete($where, $params);
        }
    }