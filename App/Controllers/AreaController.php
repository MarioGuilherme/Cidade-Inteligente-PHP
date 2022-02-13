<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Area;

    /**
     * Classe herdada de Controller responsável por controlar as ações da Área.
     *
     * @author Mário Guilherme
     */
    class AreaController extends Controller {
        private Area $areaModel;

        /**
         *  Método responsável de instanciar o modelo de Área.
         * @return void
         */
        private function GetModel() {
            $this->areaModel = new Area();
        }
    }