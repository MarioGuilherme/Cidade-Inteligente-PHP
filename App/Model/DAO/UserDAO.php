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
        }

        /**
         * Função que retorna um usuário do banco de dados através de seu email
         * @param User $user
         * @return array
         */
        public function SelectOne($user){
            try{
                $sql = "SELECT id_user, c.id_course, name, email, password, type, course FROM users u
                        INNER JOIN courses c ON u.id_course=c.id_course WHERE email = ?";
                $stmt = $this->PDO->prepare($sql);
                if($stmt->execute([$user->getEmail()])){
                    return $stmt->fetch(\PDO::FETCH_ASSOC);
                }else{
                    Utils::ReturnResponse(GENERAL_ERROR);
                }
            }catch(\PDOException $e){
                echo "Erro: {$e->getMessage()}";
            }
        }

        /**
         * Função que faz registro de um usuário se não houver email igual
         * @param User $user
         * @return array
         */
        public function Create($user){
            try{
                if(empty($this->SelectOne($user))){
                    $sql = "INSERT INTO users (id_course, name, email, password, type) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->execute([
                        $user->getId_course(),
                        $user->getName(),
                        $user->getEmail(),
                        $user->getPassword(),
                        $user->getType()
                    ]);
                    $stmt->rowCount() ? Utils::ReturnResponse(USER_REGISTERED) : Utils::ReturnResponse(GENERAL_ERROR);
                }else
                    Utils::ReturnResponse(EMAIL_ALREADY_EXISTS);
            }catch(\PDOException $e){
                echo "Erro: {$e->getMessage()}";
            }
        }
    }