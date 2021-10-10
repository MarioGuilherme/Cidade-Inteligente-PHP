<?php

    namespace App\Controller;
    use App\Model\DAO\ProjectDAO;
    use App\Model\Classes\Project;
    use App\Utils\Utils;

    class ProjectController{
        /**
         * Objeto de acesso ao banco de dados
         * @var ProjectDAO
         */
        private $MODEL;

        /**
         * Construtor da classe que inicializa criando o objeto de acesso ao banco de dados
         * @return void
         */
        public function __construct(){
            $this->MODEL = new ProjectDAO();
        }

        /**
         * Função que inclui a página dinâmica com os projetos na página inicial
         * @return void
         */
        public function Index(){
            $projects = $this->MODEL->Select();
            require __DIR__ . "/../View/projects.php";
        }

        /**
         * Função que inclui o formulário de projeto
         * @return void
         */
        public function LoadForm(){
            require __DIR__ . "/../View/form-project.html";
        }

        /**
         * Função que cria o objeto de projeto, monta o array das mídias com
         * seus dados e faz acesso ao modelo para criar um projeto
         * @param array $datas
         * @param array $medias
         * @return array
         */
        public function Create($datas, $medias){
            Utils::VerifyInputs($datas);
            Utils::VerifyInputs($medias["name"]);
            $datas = Utils::SanitizerInputs($datas);
            $project = new Project();
            $project->setId_area($datas["id_area"]);
            $project->setId_course($datas["id_course"]);
            $project->setTitle($datas["title"]);
            $project->setDescription($datas["description_project"]);
            $project->setDate($datas["date"]);
            for ($i = 0; $i < count($medias["name"]); $i++) {
                $files[$i]["media_name"] = $datas["media_name_$i"];
                $files[$i]["description"] = $datas["media_description_$i"];
                $files[$i]["name"] = $medias["name"][$i];
                $files[$i]["tmp_name"] = $medias["tmp_name"][$i];
                $files[$i]["type"] = $medias["type"][$i];
            }
            return $this->MODEL->Create($project, $files);
        }
    }