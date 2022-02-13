<?php

    declare(strict_types=1);

    namespace App\Models;

    use App\Database\Database;
    use PDOStatement;

    /**
     * Classe de Modelo responsável por fazer as abstrações de dados da Mídia.
     * 
     * @author Mário Guilherme
     */
    class Media {
        /**
         * Método responsável por realizar seleções na tabela de Mídias.
         * @param string $join Join com outras tabelas
         * @param string $where Condição para o SELECT
         * @param string $order Ordenação dos resultados
         * @param string $limit Limite de resultados
         * @param string $fields Campos da tabela
         * @param array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement
         */
        public static function Select(string $join = "", string $where = "", string $order = "", string $limit = "", string $fields = "*", array $params = []) : PDOStatement {
            return (new Database("medias"))->Select($join, $where, $order, $limit, $fields, $params);
        }

        /**
         * Método responsável por realizar inserções na tabela de Mídias.
         * @param array $values Valores a serem inseridos (Array associativo ["field" => $value])
         * @return int ID da mídia cadastrado
         */
        public static function Insert(array $params) : int {
            return (new Database("medias"))->Insert($params);
        }

        /**
         * Método responsável por realizar atualizações na tabela de Mídias.
         * @param string $where Condição para atualização
         * @param array $values Valores a serem atualizados (Array associativo ["field" => $value])
         * @return bool Retorna true se a atualização for bem sucedida
         */
        public static function Update(string $where, array $values) : bool {
            return (new Database("medias"))->Update($where, $values);
        }

        /**
         * Método responsável por realizar exclusões na tabela de Mídias.
         * @param string $where Condição para exclusão
         * @param array $params Parâmetros da SQL (Array [$value])
         * @return bool Retorna true se a exclusão for bem sucedida
         */
        public static function Delete(string $where, array $params) : bool {
            return (new Database("medias"))->Delete($where, $params);
        }
    }