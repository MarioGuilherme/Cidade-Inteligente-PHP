<?php

    namespace App\Controller;
    use App\Utils\Utils;

    class Page{
        /**
         * Botões que serão exibidos na página
         * @var array
         */
        public $buttons = [
            "<li class='nav-item active'>
                <a class='nav-link' href='projetos'>
                    Ver Projetos
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='criar-projeto'>
                    Criar Projeto
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

        /**
         * Construtor da classe que inicializa a estrutura da página e escreve os campos dinâmicos
         * @param string $title
         * @param string $css
         * @param int $indexBtn
         * @param object $object
         * @param string $action
         * @return void
         */
        public function __construct($title, $css, $indexBtn, $page){
            Utils::StartSession();
            empty($_SESSION) ? header("Location: /") : "";
            date_default_timezone_set("America/Sao_Paulo");
            Utils::LoadResponses();
            $buttons = $this->RenderButtons($indexBtn);
            require __DIR__ . "/../View/header.php";
            require __DIR__ . "/../View/$page.php";
            require __DIR__ . "/../View/footer.php";
        }

        /**
         * Função que remove o botão da página atual e renderiza os demais de acordo com o nível de acesso
         * @param int $indexBtn
         * @return string
         */
        public function RenderButtons($indexBtn){
            unset($this->buttons[$indexBtn]);
            if($_SESSION["type"] != "Professor(a)"){
                unset($this->buttons[1]);
                unset($this->buttons[2]);
            }
            return implode("", $this->buttons);
        }
    }