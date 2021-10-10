<?php

    namespace App\Model\Classes;

    class User{
        private $id_user;
        private $id_course;
        private $name;
        private $email;
        private $password;
        private $type;

        public function getId_user(){
            return $this->id_user;
        }
        public function getId_course(){
            return $this->id_course;
        }
        public function getName(){
            return $this->name;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getType(){
            return $this->type;
        }
        public function setId_user($id_user){
            $this->id_user = $id_user;
        }
        public function setId_course($id_course){
            $this->id_course = $id_course;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setPassword($password){
            $this->password = $password;
        }
        public function setType($type){
            $this->type = $type;
        }
    }