<?php

    declare(strict_types=1);

    namespace App\Core;

    /**
     * Classe encarregada de ser o Intermédio entre o Model e a View.
     * @author Mário Guilherme
     */
    class Controller {
        /**
         * Método responsável por carregar uma View com um objeto Page com as informações da página.
         * @param string $view Caminho da View
         * @param object $page Objeto Page com as informações da página
         * @return void
         */
        protected function view(string $view, object $page = null) : void {
            require __DIR__ . "/../Views/Shared/_Layout.php";
            exit;
        }
    }