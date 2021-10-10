<?php

    namespace App\Model\DAO;
    use App\Database\Connection;
    use App\Utils\Utils;

    class UserDAO{
        /**
         * Objeto PDO
         * @var PDO
         */
        private $PDO;

        /**
         * Construtor que inicializa o objeto PDO e carrega as respostas
         * @return void
         */
        public function __construct(){
            $this->PDO = Connection::Connect();
            Utils::LoadResponses();
        }

        /**
         * Função que faz seleção de um usuário para o login e inicia a sessão
         * @param User $user
         * @return array
         */
        public function SelectOne($user){
            try{
                $sql = "SELECT id_user, c.id_course, name, email, password, type, course FROM users u
                        INNER JOIN courses c ON u.id_course=c.id_course WHERE email = ?";
                $stmt = $this->PDO->prepare($sql);
                if($stmt->execute([$user->getEmail()])){
                    if($stmt->rowCount()){
                        $datas = $stmt->fetch(\PDO::FETCH_ASSOC);
                        if(password_verify($user->getPassword(), $datas["password"])){
                            Utils::StartSession();
                            $_SESSION["id_user"] = $datas["id_user"];
                            $_SESSION["id_course"] = $datas["id_course"];
                            $_SESSION["course"] = $datas["course"];
                            $_SESSION["name"] = $datas["name"];
                            $_SESSION["email"] = $datas["email"];
                            $_SESSION["type"] = $datas["type"];
                            return true;
                        }else{
                            return WRONG_PASSWORD;
                        }
                    }else{
                        return USER_NOT_FOUND;
                    }
                }else{
                    return GENERAL_ERROR;
                }
            }catch(\PDOException $e){
                echo "Erro: {$e->getMessage()}";
            }
        }

        /**
         * Função que faz registro de um usuário
         * @param User $user
         * @return array
         */
        public function Create($user){
            try{
                $sql = "SELECT id_user FROM users WHERE email = ?";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([$user->getEmail()]);
                if($stmt->rowCount()){
                    return EMAIL_ALREADY_EXISTS;
                }else{
                    $sql = "INSERT INTO users (id_course, name, email, password, type) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->execute([
                        $user->getId_course(),
                        $user->getName(),
                        $user->getEmail(),
                        $user->getPassword(),
                        $user->getType()
                    ]);
                    return $stmt->rowCount() ? USER_REGISTERED : GENERAL_ERROR;
                }
            }catch(\PDOException $e){
                echo "Erro: {$e->getMessage()}";
            }
        }
    }