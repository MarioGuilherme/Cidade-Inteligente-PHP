<?php

    declare(strict_types=1);

    namespace App\Models;

    /**
     * Modelo da entidade Mídia.
     * @author Mário Guilherme
     */
    class Media {
        public int $id_media;
        public int $id_project;
        public string $name;
        public string $type;
        public int $size;
        public string $fileName;
        public string $description;
    }