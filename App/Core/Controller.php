<?php

    declare(strict_types=1);

    namespace App\Core;

    /**
     * Classe encarregada de ser o Intermédio entre o Model e a View.
     * @author Mário Guilherme
     */
    class Controller {
        /**
         * Método responsável por retornar o objeto Model de uma determinada entidade.
         * @param string $model Caminho do Model
         * @return object Objeto Model
         */
        public function model(string $model) : object {
            (object) $model = "App\Models\\$model";
            return new $model;
        }

        /**
         * Método responsável por carregar uma View e passar as configurações da página para esta View.
         * @param string $view Caminho da View
         * @param array $page Dados passados para a View
         * @return void
         */
        public function view(string $view, array $page = []) : void {
            require __DIR__ . "/../Views/Shared/_Layout.php";
        }
    }