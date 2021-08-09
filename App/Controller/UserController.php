<?php

    namespace App\Controller;
    use App\Model\User;

    class UserController{

        public function __construct(){
            $this->model = new User;
        }

        public function Register($id_course, $name, $email, $password, $type, $level){
            if($this->model->VerifyUser() === 1){
                if($id_course == "" || $name == "" || $email == "" || $password == "" || $type == "" || $level == ""){
                    return EMPTY_FIELDS;
                }else{
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        return INVALID_EMAIL;
                    }else{
                        if($id_course > 0 && $id_course < 7 && is_numeric($id_course)){
                            $name = trim(substr(htmlspecialchars($name), 0, 100));
                            $email = trim(substr(htmlspecialchars($email), 0, 55));
                            $password = trim(substr(htmlspecialchars($password), 0, 255));
                            $type = trim(substr(htmlspecialchars($type), 0, 12));
                            $level = trim(substr(htmlspecialchars($email), 0, 40));
                            return $this->model->Insert($id_course, $name, $email, $password, $type, $level);
                        }
                    }
                }
            }else{
                return $this->model->VerifyUser();
            }
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