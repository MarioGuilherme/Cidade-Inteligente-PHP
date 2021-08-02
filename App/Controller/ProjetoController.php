<?php

    namespace App\Controller;
    use App\Model\Projeto;

    class ProjetoController{

        public function __construct(){
            $this->model = new Projeto;
        }

        public function List(){
            return $this->model->Select();
        }
    }