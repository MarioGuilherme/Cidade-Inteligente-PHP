<?php

    declare(strict_types=1);

    namespace App\Database;

    use PDO;
    use PDOStatement;
    use PDOException;

    class Database {
        /**
         * Driver do banco de dados
         * @var string
         */
        private static string $driver;

        /**
         * Host do banco de dados
         * @var string
         */
        private static string $host;

        /**
         * Nome do banco de dados
         * @var string
         */
        private static string $database;

        /**
         * Usuário do banco de dados
         * @var string
         */
        private static string $user;

        /**
         * Senha do banco de dados
         * @var string
         */
        private static string $password;

        /**
         * Colação de caracteres do banco de dados
         * @var string
         */
        private static string $charset;

        /**
         * Opções da conexão com o banco de dados
         * @var string
         */
        protected static array $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        /**
         * Nome da tabela a ser manipulada
         * @var string
         */
        private string $table;

        /**
         * Instancia de conexão com o banco de dados
         * @var PDO
         */
        private PDO $PDO;

        /**
         * Método responsável por configurar a classe.
         * @param string $driver Driver do banco de dados
         * @param string $host Host do banco de dados
         * @param string $database Nome do banco de dados
         * @param string $user Usuário do banco de dados
         * @param string $password Senha do banco de dados
         * @param string $charset Colação do banco de dados
         * @return void
         */
        public static function Config(string $driver, string $host, string $database, string $user, string $password, string $charset) : void {
            self::$driver = $driver;
            self::$host = $host;
            self::$database = $database;
            self::$user = $user;
            self::$password = $password;
            self::$charset = $charset;
        }

        /**
         * Define a tabela e instancia e conexão
         * @param string $table
         * @return void
         */
        public function __construct(string $table = null) {
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
         * @param string $sql SQL a ser executada
         * @param array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement Objeto PDOStatement
         */
        public function Execute(string $sql, array $params = []) : PDOStatement {
            try {
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute($params);
                return $stmt;
            } catch(PDOException $e) {
                die("ERROR: {$e->getMessage()}");
            }
        }

        /**
         * Método responsável por realizar seleções no banco de dados.
         * @param string $join Join com outras tabelas
         * @param string $where Condição para o SELECT
         * @param string $order Ordenação dos resultados
         * @param string $limit Limite da SQL
         * @param string $fields Campos da tabela
         * @param array $params Parâmetros da SQL (Array [$value])
         * @return PDOStatement Objeto PDOStatement
         */
        public function Select(string $join = "", string $where = "", string $order = "", string $limit = "", string $fields = "*", array $params = []) : PDOStatement {
            $where = strlen($where) ? "WHERE ".$where : "";
            $order = strlen($order) ? "ORDER BY ".$order : "";
            $sql = "SELECT $fields FROM {$this->table} $join $where $order";
            return $this->Execute($sql, $params);
        }

        /**
         * Método responsável por realizar inserções no dados no banco.
         * @param array $values Valores a serem inseridos (Array associativo ["field" => $value])
         * @return int ID inserido
         */
        public function Insert(array $values) : int {
            $fields = array_keys($values);
            $binds  = array_pad([], count($fields), "?");
            $sql = "INSERT INTO {$this->table} (".implode(", " , $fields).") VALUES (".implode(", ", $binds).")";
            $this->Execute($sql, array_values($values));
            return (int) $this->PDO->lastInsertId();
        }

        /**
         * Método responsável por realizar atualizações no banco de dados.
         * @param string $where Condição para atualização
         * @param array $values Valores a serem atualizados (Array associativo ["field" => $value])
         * @return bool Retorna true se a atualização for bem sucedida
         */
        public function Update(string $where, array $values) : bool {
            $fields = array_keys($values);
            $sql = "UPDATE {$this->table} SET " . implode(" = ?, ", $fields) . " = ? WHERE $where LIMIT 1";
            $this->Execute($sql, array_values($values));
            return true;
        }

        /**
         * Método responsável por realizar exclusões no dados do banco.
         * @param string $where Condição para exclusão
         * @param array $params Parâmetros da SQL (Array [$value])
         * @return bool Retorna true se a exclusão for bem sucedida
         */
        public function Delete(string $where, array $params = []) : bool {
            $sql = "DELETE FROM {$this->table} WHERE $where LIMIT 1";
            $this->Execute($sql, $params);
            return true;
        }
    }