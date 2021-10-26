<?php

    namespace App\Controller;
    use App\Controller\Page;
    use App\Model\DAO\ProjectDAO;
    use App\Model\Classes\Project;
    use App\Utils\Utils;

    class ProjectController extends Page {
        /**
         * Objeto de acesso ao banco de dados
         * @var ProjectDAO
         */
        private $MODEL;

        /**
         * Construtor da classe que inicializa criando o objeto de acesso
         * ao banco de dados, carrega as respostas e inicia a sessão
         * @return void
         */
        public function __construct(){
            $this->MODEL = new ProjectDAO();
            Utils::StartSession();
            Utils::LoadResponses();
        }

        /**
         * Método responsável por iniciar a página listando todos os projetos
         * @return void
         */
        public function ViewProject($id_project){
            $project = new Project();
            $project->setId_project($id_project);
            $data = $this->MODEL->SelectOne($project);
            $title = "Projeto: $data[title]";
            $css = "view-project";
            $buttons = $this->RenderButtons(0);
            require __DIR__ . "/../View/header.php";
            require __DIR__ . "/../View/view-project.php";
            require __DIR__ . "/../View/footer.php";
        }

        /**
         * Método responsável por iniciar a página listando todos os projetos
         * @return void
         */
        public function Index(){
            $title = "Projetos";
            $css = "projects";
            $buttons = $this->RenderButtons(0);
            $projects = $this->MODEL->SelectAll();
            require __DIR__ . "/../View/header.php";
            require __DIR__ . "/../View/projects.php";
            require __DIR__ . "/../View/footer.php";
        }
    }