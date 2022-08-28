<?php

    declare(strict_types=1);

    namespace App\Models;

    /**
     * Modelo da entidade Projeto.
     * @author Mário Guilherme
     */
    class Project {
        public int $id_project;
        public string $area;
        public string $course;
        public string $title;
        public string $description;
        public array $users;
        public array $medias;
        public string $registeredDate;
        public string $startDate;
        public string $endDate;
    }