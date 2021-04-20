<?php

    define('HOST', 'localhost');
    define('BANCO', 'cidade-inteligente');
    define('USER', 'root');
    define('SENHA', 'root');
    define('COLAÇÃO', array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));

    class Core{
        public function __construct(){

            public static function Conectar(){
                self::$PDO = new PDO("mysql:host=".HOST."; dbname=".BANCO, USER, SENHA, COLAÇÃO);
            }
        }
    }