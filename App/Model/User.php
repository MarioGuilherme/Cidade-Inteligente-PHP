<?php

    namespace App\Model;
    use App\Server\Connection;
    use PDO;

    class User extends Connection{
        public function Insert($id_course, $name, $email, $password, $type, $level){
            $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute($email);
            if($stmt->rowCount() > 0){
                return EMAIL_ALREADY_EXISTS;
            }else{
                $sql = "INSERT INTO usuarios (id_curso, nome, email, senha, tipo, nivel) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    $id_course,
                    $name,
                    $email,
                    $password,
                    $type,
                    $level
                ]);
                return $stmt->rowCount() > 0 ? REGISTERED : GENERAL_ERROR;
            }
        }

        public function Select($email, $password, $timestamp){
            $sql = "SELECT id_usuario, c.id_curso, nome, email, senha, tipo, nivel, curso FROM usuarios u INNER JOIN cursos c ON u.id_curso=c.id_curso WHERE email = ?";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([$email]);
            if($stmt->rowCount()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $row["senha"])){
                    $_SESSION["id_usuario"] = $row["id_usuario"];
                    $_SESSION["id_curso"] = $row["id_curso"];
                    $_SESSION["curso"] = $row["curso"];
                    $_SESSION["nome"] = $row["nome"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["tipo"] = $row["tipo"];
                    $_SESSION["nivel"] = $row["nivel"];  
                    $_SESSION["timestamp"] = $timestamp == "on" ? time() + 14400 : 1;
                    return LOGGED;
                }else{
                    return INVALID_PASSWORD;
                }
            }else{
                return NOT_REGISTERED;
            }
        }
    }