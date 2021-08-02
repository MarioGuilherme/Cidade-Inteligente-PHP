<?php

    namespace App\Controller;
    use App\Model\User;

    class UserController{

        public function __construct(){
            $this->model = new User;
        }

        public function Login($email, $password, $timestamp = null){
            if($email == "" || $password == ""){
                return EMPTY_FIELDS;
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return INVALID_EMAIL;
                }else{
                    $email = trim(substr(htmlspecialchars($email), 0, 55));
                    return $this->model->Select($email, $password, $timestamp);
                }
            }
        }

        public function Logout(){
            session_destroy();
            header("Location: /");
        }

    }