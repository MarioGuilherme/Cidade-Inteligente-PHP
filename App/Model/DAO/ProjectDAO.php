<?php

    namespace App\Model\DAO;
    use App\Database\Connection;

    class ProjectDAO{
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
         * Função que retorna todos os projetos com suas mídias associadas
         * @return array
         */
        public function SelectAll(){
            try{
                $sql = "SELECT p.id_project, a.area AS area, c.course,
                        title, p.description, date FROM projects p
                        INNER JOIN areas a ON p.id_area = a.id_area
                        INNER JOIN courses c ON p.id_course = c.id_course";
                $stmt = $this->PDO->query($sql);
                $stmt->execute();
                $datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $datas = $this->AssocMediasToProjects($datas);
                return $datas;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }

        /**
         * Função que retorna todos um projeto de acordo com seu id
         * @return array
         */
        public function SelectOne($project){
            try{
                $sql = "SELECT p.id_project, a.area AS area, c.course,
                        title, p.description, date FROM projects p
                        INNER JOIN areas a ON p.id_area = a.id_area
                        INNER JOIN courses c ON p.id_course = c.id_course
                        WHERE p.id_project = ?";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([$project->getId_project()]);
                $datas = $stmt->fetch(\PDO::FETCH_ASSOC);
                $datas = $this->AssocMediasToOneProject($datas);
                return $datas;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }

        /**
         * Função que faz a busca e a associação das mídias aos id's dos projetos
         * @param array $datas
         * @return array
         */
        public function AssocMediasToOneProject($datas){
            try{
                $sql = "SELECT id_media, type, path FROM medias WHERE id_project = ?";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([$datas["id_project"]]);
                $medias = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                for ($i = 0; $i < count($medias); $i++) {
                    $datas["medias"][$i] = $medias[$i];
                }
                return $datas;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }

        /**
         * Função que faz a busca e a associação das mídias aos id's dos projetos
         * @param array $datas
         * @return array
         */
        public function AssocMediasToProjects($datas){
            try{
                foreach ($datas as $key => $value) {
                    $sql = "SELECT id_media, type, path FROM medias WHERE id_project = ?";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->execute([$value["id_project"]]);
                    $medias = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($medias); $i++) {
                        $datas[$key]["medias"][$i] = $medias[$i];
                    }
                }
                return $datas;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }
    }