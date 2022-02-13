<?php

    declare(strict_types=1);

    namespace App\Core;

    use App\Utils\Session;

    /**
     * Classe encarregada de ser o intermédio entre a View e o Model.
     *
     * @author Mário Guilherme
     */
    class Controller {
        private array $buttons = [
           "<li class='nav-item active'>
                <a class='nav-link' href='meus-projetos'>
                    Meus Projetos
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
           "<li class='nav-item active'>
                <a class='nav-link' href='projetos'>
                    Todos os Projetos
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
                    Cadastrar Professor(a)/Aluno(a)
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='perfil'>
                    Meu Perfil
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='login'>
                    Login
                    <span class='sr-only'>(current)</span>
                </a>
            </li>",
            "<li class='nav-item active'>
                <a class='nav-link' href='services/logout'>
                    Sair
                    <span class='sr-only'>(current)</span>
                </a>
            </li>"
        ];

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
            require __DIR__ . "/../Views/Page/_Layout.php";
        }

        /**
         * Método responsável por renderizar os botões de navegação
         * @param int $indexBtn Índice do botão que será apagado (página atual)
         * @return string HTML dos botões de navegação
         */
        public function RenderButtons(int $indexBtn = null) : string {
            // SE O USUÁRIO NÃO ESTIVER LOGADO
            if(Session::IsEmptySession()) {
                unset($this->buttons[0]);
                unset($this->buttons[2]);
                unset($this->buttons[3]);
                unset($this->buttons[4]);
                unset($this->buttons[6]);
            } else {
                // SE O USUÁRIO ESTIVER LOGADO
                unset($this->buttons[5]);
                if(!Session::IsAdmin()) {
                    // SE O USUÁRIO NÃO FOR ADMINISTRADOR
                    unset($this->buttons[2]);
                    unset($this->buttons[3]);
                }
            }
            unset($this->buttons[$indexBtn]);
            return implode("", $this->buttons);
        }
    }