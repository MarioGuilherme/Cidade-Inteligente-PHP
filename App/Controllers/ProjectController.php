<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Controllers\{
        MediaController,
        UserController
    };
    use App\Models\{
        Project,
        Project_User
    };
    use App\Utils\{
        Form,
        Response,
        Session
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações do Projeto
     *
     * @author Mário Guilherme
     */
    class ProjectController extends Controller {
        private Project $projectModel;
        private Project_User $projectUserModel;

        /**
         *  Método responsável de instanciar o modelo de Projeto e de Projeto_Usuário.
         * @return void
         */
        private function GetModel() {
            $this->projectModel = new Project();
            $this->projectUserModel = new Project_User();
        }

        /**
         * Método responsável por carregar a página principal,
         * listando todos os projetos e suas mídias
         * @return void
         */
        public function NewProject(array $form, array $medias) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            echo("<pre>");
            var_dump($form);
            var_dump($medias);
            echo("</pre>");
            exit;
            // LIMPEZA DOS CAMPOS
            $id_area = (int) Form::SanatizeField($form["area"], FILTER_SANITIZE_NUMBER_INT);
            $id_course = (int) Form::SanatizeField($form["course"], FILTER_SANITIZE_NUMBER_INT);
            $title = Form::SanatizeField($form["title"], FILTER_SANITIZE_STRING);
            $date = Form::SanatizeField($form["date"], FILTER_SANITIZE_STRING);
            $description = Form::SanatizeField($form["description"], FILTER_SANITIZE_STRING);

            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$id_area, $id_course, $title, $date, $description]);

            if(filter_var($id_area, FILTER_VALIDATE_INT) && $id_area > 0 && $id_area <= 3) {
                if(filter_var($id_course, FILTER_VALIDATE_INT) && $id_course > 0 && $id_course <= 7) {
                    // OBTENÇÃO DO MODEL
                    $this->GetModel();
                    $id_project = $this->projectModel->Insert([
                        "id_area" => $id_area,
                        "id_course" => $id_course,
                        "title" => $title,
                        "date" => $date,
                        "description" => $description
                    ]);
                    if($id_project > 0) {
                        for($i = 0; $i < count($medias["name"]); $i++) {
                            $media = [
                                "id_project" => $id_project,
                                "name" => $form["medias"][$i]["name"],
                                "type" => $medias["type"][$i],
                                "size" => $medias["size"][$i],
                                "name_file" => $medias["name"][$i],
                                "tmp_name" => $medias["tmp_name"][$i],
                                "error" => $medias["error"][$i],
                                "description" => $form["medias"][$i]["description"]
                            ];
                            (new MediaController())->NewMedia($media);
                        }
                        foreach($form["users"] as $user) {
                            $this->projectUserModel->Insert([
                                "id_project" => $id_project,
                                "id_user" => $user
                            ]);
                        }
                         Response::Message(PROJECT_REGISTERED);
                    } else {
                        Response::Message(GENERAL_ERROR);
                    }
                } else
                    Response::Message(INVALID_COURSE);
            } else
                Response::Message(INVALID_AREA);
        }

        /**
         * Método responsável por carregar a página principal,
         * listando todos os projetos e suas mídias
         * @return void
         */
        public function Index() : void {
            $this->GetModel();
            $projects = $this->projectModel::Select()->fetchAll(PDO::FETCH_ASSOC);
            foreach ($projects as $key => $project) {
                $projects[$key]["medias"] = (new MediaController())->GetMedias((int) $projects[$key]["id_project"]);
            }
            $data = [
                "title" => "Projetos",
                "css" => "projects",
                "btns" => $this->RenderButtons(1),
                "projects" => $projects,
                "js" => "projects"
            ];
            $this->View("Projects/index", $data);
        }

        /**
         * Método responsável de trazer os dados de um projeto de acordo com seu id
         * @param int $id_project ID do projeto
         * @return void
         */
        public function ViewProject(int $id_project) : void {
            $project = $this->projectModel->Select("INNER JOIN areas ON projects.id_area = areas.id_area
                                                    INNER JOIN courses ON projects.id_course = courses.id_course",
                                                    "projects.id_project = ?", "", "",
                                                    "projects.id_project, areas.area AS area, courses.course, title, projects.description, date",
                                                    [$id_project])->fetch(PDO::FETCH_ASSOC);
            $project["users"] = (new ProjectUserController())->GetUsersByProject((int) $project["id_project"]);
            $project["medias"] = (new MediaController())->GetMedias((int) $project["id_project"]);
            $data = [
                "title" => "Projeto - $project[title]",
                "css" => "view-project",
                "btns" => $this->RenderButtons(),
                "project" => $project,
                "js" => "view-project"
            ];
            $this->View("Projects/view-project", $data);
        }

        /**
         * Método responsável por carregar a View do formulário para criar um projeto
         * @return void
         */
        public function FormProject() : void {
            if(Session::IsAdmin()) {
                $data = [
                    "title" => "Cadastro de Projeto",
                    "css" => "new-project",
                    "btns" => $this->RenderButtons(2),
                    "users" => (new UserController())->GetUsers(),
                    "js" => "new-project"
                ];
                $this->View("Projects/form", $data);
            } else
                Session::Redirect("projetos");
        }
    }