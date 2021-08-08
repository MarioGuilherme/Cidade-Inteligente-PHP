<?php

    namespace App\Controller;

    class Page{
        public $structure;
        public $content;
        public $form;
        public $buttons = [
            "<li class='nav-item active'>
                <a class='nav-link' href='criar-projeto'>
                    Cadastrar Projeto
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='criar-usuario'>
                    Cadastrar Professor(a)/Aluno
                    <span class='sr-only'>(current)</span>
                </a>
            </li>"
        ];

        // Carrega o esqueleto da tela principal e renderiza os componentes dinâmicos (css, titulo, botões e conteúdo)
        public function __construct($title, $fileName){
            $this->buttons["rendered"] = $_SESSION["tipo"] == "Professor(a)" ? $this->buttons[0] . $this->buttons[1] : "";
            $this->content = file_get_contents(__DIR__ . "../../View/$fileName.html");
            $this->structure = file_get_contents(__DIR__ . "../../View/structure.html");
            $this->structure = str_replace([
                "{{ title }}",
                "{{ css }}",
                "{{ buttons }}",
                "{{ content }}"
            ], [
                $title,
                $fileName,
                $this->buttons["rendered"],
                $this->content
            ],$this->structure);
        }
    }