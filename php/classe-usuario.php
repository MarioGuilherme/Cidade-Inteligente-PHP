<?php

    class Usuario{

        private $pdo;

        public function __construct($dbname, $host, $user, $senha){

            try{

                $this->pdo = new PDO("mysql:dbname=$dbname;host=$host", "$user", "$senha");

            } catch(PDOException $erro){
                echo("Erro com Banco de Dados: {$erro->getMessage()}");
            } catch(Exception $erro){
                echo("Erro Genérico: {$erro->getMessage()}");
            }
        }

        public function buscarDados(){

            $cmd = $this->pdo->query("SELECT * FROM usuario ORDER BY nome");
            $resposta = array();
            $resposta = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $resposta;

        }
    }
?>