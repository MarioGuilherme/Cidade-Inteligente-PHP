<?php

    namespace App\Model\Classes;

    class Project{
        private $id_project;
        private $id_area;
        private $id_course;
        private $title;
        private $description;
        private $date;

        public function getId_project(){
            return $this->id_project;
        }
        public function getId_area(){
            return $this->id_area;
        }
        public function getId_course(){
            return $this->id_course;
        }
        public function getTitle(){
            return $this->title;
        }
        public function getDescription(){
            return $this->description;
        }
        public function getDate(){
            return $this->date;
        }
        public function setId_project($id_project){
            $this->id_project = $id_project;
        }
        public function setId_area($id_area){
            $this->id_area = $id_area;
        }
        public function setId_course($id_course){
            $this->id_course = $id_course;
        }
        public function setTitle($title){
            $this->title = $title;
        }
        public function setDescription($description){
            $this->description = $description;
        }
        public function setDate($date){
            $this->date = $date;
        }
    }