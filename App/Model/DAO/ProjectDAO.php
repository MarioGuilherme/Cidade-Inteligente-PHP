<?php

    namespace App\Model\DAO;
    use App\Database\Connection;
    use App\Model\Classes\Media;
    use App\Utils\Utils;
    use App\Utils\File;

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
            Utils::LoadResponses();
        }

        /**
         * Função que retorna todos os projetos com suas mídias associadas
         * @return array
         */
        public function Select(){
            $sql = "SELECT p.id_project, a.area AS area, c.course,
                    title, p.description, date FROM projects p
                    INNER JOIN areas a ON p.id_area = a.id_area
                    INNER JOIN courses c ON p.id_course = c.id_course";
            $stmt = $this->PDO->query($sql);
            $stmt->execute();
            $datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $datas = $this->AssocMedias($datas);
            return $datas;
        }

        /**
         * Função que faz a busca e a associação das mídias ao id do projeto
         * @param array $datas
         * @return array
         */
        public function AssocMedias($datas){
            foreach ($datas as $key => $value) {
                $sql = "SELECT id_media, type, path FROM medias WHERE id_project = ?";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([$value["id_project"]]);
                $medias = $stmt->fetchAll();
                for ($i=0; $i < count($medias); $i++) {
                    $datas[$key]["medias"][$i]["id_media"] .= $medias[$i]["id_media"];
                    $datas[$key]["medias"][$i]["type"] .= $medias[$i]["type"];
                    $datas[$key]["medias"][$i]["path"] .= $medias[$i]["path"];
                }
            }
            return $datas;
        }

        /**
         * Função que faz a criação de um projeto, em seguida cria 
         * de mídias e na tabela n:n
         * @param Projeto $project
         * @param array $medias
         * @return array $medias
         * @return array $project
         */
        public function Create($project, $medias){
            $sql = "INSERT INTO projects (id_area, id_course, title, description, date) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([
                $project->getId_area(),
                $project->getId_course(),
                $project->getTitle(),
                $project->getDescription(),
                $project->getDate()
            ]);
            $id_project = $this->PDO->lastInsertId();
            if($stmt->rowCount()){
                File::VerifyExtensions($medias);
                for ($i = 0; $i < count($medias); $i++) {
                    $media = new Media();
                    $media->setId_project($id_project);
                    $media->setName($medias[$i]["media_name"]);
                    $media->setType($medias[$i]["type"]);
                    $media->setDescription($medias[$i]["description"]);
                    $media->setPath(File::UploadFile([
                        "name" => $medias[$i]["name"],
                        "tmp_name" => $medias[$i]["tmp_name"]
                    ]));
                    (new MediaDAO())->Create($media);
                }
                return PROJECT_CREATED;
            }else{
                return GENERAL_ERROR;
            }
        }
    }