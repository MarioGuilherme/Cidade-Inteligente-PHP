<?php

    declare(strict_types=1);

    namespace App\Core;

    use App\Utils\Session;
    use App\Utils\Response;

    /**
     * Classe encarregada de ser o intermédio entre a View e o Model
     *
     * @author Mário Guilherme
     */
    class Controller {
        private array $buttons = [
            "<li class='nav-item active'>
                <a class='nav-link' href='login'>
                    Login
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
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
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='src/services/logout'>
                    Sair
                    <span class='sr-only'>(current)</span>
                </a>
            </li>"
        ];

        /**
         * Método responsável por iniciar a classe,
         * carregar as respostas e iniciar a sessão
         * @return void
         */
        public function __construct() {
            date_default_timezone_set("America/Sao_Paulo");
            Session::StartSession();
            if(!defined("GENERAL_ERROR"))
                Response::LoadResponses();
        }

        /**
         * Método responsável por retornar o objeto Model
         * @param string $model Caminho do Model
         * @return object Objeto Model
         */
        public function Model(string $model) : object {
            $model = "App\Models\\$model";
            return new $model;
        }

        /**
         * Método responsável por retornar o View e passar os dados
         * @param string $view Caminho do View
         * @param array $data Dados que serão passados para o View
         * @return void
         */
        public function View(string $view, array $data = []) : void {
            require __DIR__ . "/../Views/Components/structure.php";
        }

        /**
         * Método responsável por renderizar os botões de navegação
         * @param int $indexBtn Índice do botão que será apagado (página atual)
         * @return string
         */
        public function RenderButtons(int $indexBtn = null) : string {
            if(Session::VerifySession()) {
                unset($this->buttons[0]);
            } else {
                unset($this->buttons[2]);
                unset($this->buttons[3]);
            }
            if(!Session::VerifyAdm()) {
                unset($this->buttons[2]);
                unset($this->buttons[3]);
            }
            unset($this->buttons[$indexBtn]);
            return implode("", $this->buttons);
        }
    }