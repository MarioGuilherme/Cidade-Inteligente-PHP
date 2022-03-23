<?php

    declare(strict_types=1);

    namespace App\Database;

    use PDO;
    use PDOStatement;
    use PDOException;

    class Database {
        /**
         * Driver do banco de dados
         * @var String
         */
        private static String $driver;

        /**
         * Host do banco de dados
         * @var String
         */
        private static String $host;

        /**
         * Nome do banco de dados
         * @var String
         */
        private static String $database;

        /**
         * Usuário do banco de dados
         * @var String
         */
        private static String $user;

        /**
         * Senha do banco de dados
         * @var String
         */
        private static String $password;

        /**
         * Colação de caracteres do banco de dados
         * @var String
         */
        private static String $charset;

        /**
         * Opções da conexão com o banco de dados
         * @var String
         */
        protected static Array $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        /**
         * Nome da tabela a ser manipulada
         * @var String
         */
        private String $table;

        /**
         * Instancia de conexão com o banco de dados
         * @var PDO
         */
        private PDO $PDO;

        /**
         * Método responsável por configurar a classe.
         * @param String $driver Driver do banco de dados
         * @param String $host Host do banco de dados
         * @param String $database Nome do banco de dados
         * @param String $user Usuário do banco de dados
         * @param String $password Senha do banco de dados
         * @param String $charset Colação do banco de dados
         * @return void
         */
        public static function Config(String $driver, String $host, String $database, String $user, String $password, String $charset) : void {
            self::$driver = $driver;
            self::$host = $host;
            self::$database = $database;
            self::$user = $user;
            self::$password = $password;
            self::$charset = $charset;
        }

        /**
         * Define a tabela e instancia e conexão
         * @param String $table
         * @return void
         */
        public function __construct(String $table = null) {
            $this->table = $table;
            $this->SetConnection();
        }

        /**
         * Método responsável por criar uma conexão com o banco de dados.
         * @return void
         */
        private function SetConnection() : void {
            try {
                $this->PDO = new PDO(self::$driver.":host=".self::$host.";dbname=".self::$database.";charset=".self::$charset, self::$user, self::$password);
                $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("ERROR: {$e->getMessage()}");
            }
        }

        /**
         * Método responsável por executar SQL juntamente com parâmetros no banco de dados.
         * @param String $sql SQL a ser executada
         * @param Array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement Objeto PDOStatement
         */
        public function Execute(String $sql, Array $params = []) : PDOStatement {
            try {
                (Object) $stmt = $this->PDO->prepare($sql);
                $stmt->execute($params);
                return $stmt;
            } catch(PDOException $e) {
                die("ERROR: {$e->getMessage()}");
            }
        }

        /**
         * Método responsável por realizar seleções no banco de dados.
         * @param String $join Join com outras tabelas
         * @param String $where Condição para o SELECT
         * @param String $order Ordenação dos resultados
         * @param String $limit Limite de resultados
         * @param String $fields Campos da tabela
         * @param Array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement Objeto PDOStatement
         */
        public function Select(String $join = "", String $where = "", String $order = "", String $limit = "", String $fields = "*", Array $params = []) : PDOStatement {
            (String) $where = strlen($where) ? "WHERE ".$where : "";
            (String) $order = strlen($order) ? "ORDER BY ".$order : "";
            (String) $sql = "SELECT $fields FROM {$this->table} $join $where $order";
            return $this->Execute($sql, $params);
        }

        /**
         * Método responsável por realizar inserções no dados no banco.
         * @param Array $values Valores a serem inseridos (Array associativo ["field" => $value])
         * @return Int ID inserido
         */
        public function Insert(Array $values) : Int {
            (Array) $fields = array_keys($values);
            (Array) $binds  = array_pad([], count($fields), "?");
            (String) $sql = "INSERT INTO {$this->table} (".implode(", " , $fields).") VALUES (".implode(", ", $binds).")";
            $this->Execute($sql, array_values($values));
            return (Int) $this->PDO->lastInsertId();
        }

        /**
         * Método responsável por realizar atualizações no banco de dados.
         * @param String $where Condição para atualização
         * @param Array $values Valores a serem atualizados (Array associativo ["field" => $value])
         * @return Bool Retorna true se a atualização for bem sucedida
         */
        public function Update(String $where, Array $values) : Bool {
            (Array) $fields = array_keys($values);
            (String) $sql = "UPDATE {$this->table} SET " . implode(" = ?, ", $fields) . " = ? WHERE $where LIMIT 1";
            $this->Execute($sql, array_values($values));
            return true;
        }

        /**
         * Método responsável por realizar exclusões no dados do banco.
         * @param String $where Condição para exclusão
         * @param Array $params Parâmetros da SQL (Array [$value])
         * @return Bool Retorna true se a exclusão for bem sucedida
         */
        public function Delete(String $where, Array $params = []) : Bool {
            (String) $sql = "DELETE FROM {$this->table} WHERE $where";
            $this->Execute($sql, $params);
            return true;
        }
    }