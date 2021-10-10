<?php

    namespace App\Model\Classes;

    class Media{
        private $id_media;
        private $id_project;
        private $name;
        private $type;
        private $path;
        private $description;

        public function getId_media(){
            return $this->id_media;
        }
        public function getId_project(){
            return $this->id_project;
        }
        public function getName(){
            return $this->name;
        }
        public function getType(){
            return $this->type;
        }
        public function getPath(){
            return $this->path;
        }
        public function getDescription(){
            return $this->description;
        }
        public function setId_media($id_media){
            $this->id_media = $id_media;
        }
        public function setId_project($id_project){
            $this->id_project = $id_project;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function setType($type){
            $this->type = $type;
        }
        public function setPath($path){
            $this->path = $path;
        }
        public function setDescription($description){
            $this->description = $description;
        }
    }