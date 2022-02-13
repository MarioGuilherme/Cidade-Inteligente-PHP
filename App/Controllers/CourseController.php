<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Course;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Curso.
     *
     * @author Mário Guilherme
     */
    class CourseController extends Controller {
        private Course $courseModel;

        /**
         *  Método responsável de instanciar o modelo de Curso.
         * @return void
         */
        private function GetModel() {
            $this->courseModel = new Course();
        }
    }