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
         * Método responsável de instanciar o modelo de Projeto e de Projeto_Usuário.
         * @return void
         */
        private function GetModel() {
            $this->projectModel = new Project();
            $this->projectUserModel = new Project_User();
        }

        /**
         * Método responsável por retornar quantos projetos existem de uma determinada área.
         * @param int $id_area ID da área
         * @return int Quantidade de projetos
         */
        public function GetProjectByArea(int $id_area) : int {
            $this->GetModel();
            return $this->projectModel::Select("p INNER JOIN areas a ON p.id_area = a.id_area", "a.id_area = ?", "", "", "a.id_area", [$id_area])->rowCount();
        }

        /**
         * Método responsável por retornar quantos projetos existem de um determinad curso.
         * @param int $id_course ID do curso
         * @return int Quantidade de projetos
         */
        public function GetProjectByCourse(int $id_course) : int {
            $this->GetModel();
            return $this->projectModel::Select("p INNER JOIN courses c ON p.id_course = c.id_course", "c.id_course = ?", "", "", "c.id_course", [$id_course])->rowCount();
        }

        /**
         * Método responsável por carregar a página principal,
         * listando todos os projetos e suas mídias
         * @return void
         */
        public function NewProject(array $form, array $medias) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            $id_area = (int) Form::SanatizeField($form["area"], FILTER_SANITIZE_NUMBER_INT);
            $id_course = (int) Form::SanatizeField($form["course"], FILTER_SANITIZE_NUMBER_INT);
            $title = Form::SanatizeField($form["title"], FILTER_SANITIZE_STRING);
            $date = Form::SanatizeField($form["date"], FILTER_SANITIZE_STRING);
            $description = Form::SanatizeField($form["description"], FILTER_SANITIZE_STRING);
            !isset($form["users"]) ? Response::Message(EMPTY_FIELDS, "users") : $users = $form["users"];

            // VALIDAÇÃO DOS CAMPOS
            Form::VerifyEmptyFields([$id_area, $id_course, $title, $date, $description]);
            Form::ValidateArea($id_area);
            Form::ValidateCourse($id_course);

            // OBTENÇÃO DO MODEL
            $this->GetModel();
            $id_project = $this->projectModel::Insert([
                "id_area" => $id_area,
                "id_course" => $id_course,
                "title" => $title,
                "date" => $date,
                "description" => $description
            ]);
            if($id_project > 0) {
                for($i = 0; $i < count($medias["name"]); $i++) {
                    $type = explode("/", $medias["type"][$i])[0];
                    if($type != "image" && $type != "video") {
                        unset($medias["name"][$i]);
                        unset($medias["type"][$i]);
                        unset($medias["size"][$i]);
                        unset($medias["tmp_name"][$i]);
                        unset($medias["error"][$i]);
                    }
                }
                $medias["name"] = array_values($medias["name"]);
                $medias["type"] = array_values($medias["type"]);
                $medias["size"] = array_values($medias["size"]);
                $medias["tmp_name"] = array_values($medias["tmp_name"]);
                $medias["error"] = array_values($medias["error"]);
                for($i = 0; $i < count($medias["name"]); $i++) {
                    $media = [
                        "id_project" => $id_project,
                        "name" => $medias["name"][$i],
                        "type" => $medias["type"][$i],
                        "size" => $medias["size"][$i],
                        "name_file" => $form["name_media"][$i],
                        "tmp_name" => $medias["tmp_name"][$i],
                        "error" => $medias["error"][$i],
                        "description" => $form["description_media"][$i]
                    ];
                    (new MediaController())->NewMedia($media);
                }
                foreach($users as $user) {
                    $this->projectUserModel::Insert([
                        "id_project" => $id_project,
                        "id_user" => $user
                    ]);
                }
                Response::Message(PROJECT_REGISTERED);
            } else
                Response::Message(GENERAL_ERROR);
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
                $projects[$key]["medias"] = (new MediaController)->GetMedias((int) $projects[$key]["id_project"]);
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
            $this->GetModel();
            $project = $this->projectModel::Select("INNER JOIN areas ON projects.id_area = areas.id_area
                                                    INNER JOIN courses ON projects.id_course = courses.id_course",
                                                    "projects.id_project = ?", "", "",
                                                    "projects.id_project, areas.area AS area, courses.course, title, projects.description, date",
                                                    [$id_project])->fetch(PDO::FETCH_ASSOC);
            if(empty($project)) {
                $data = [
                    "title" => "Projeto não encontrado",
                    "css" => "project-not-found",
                    "btns" => $this->RenderButtons(),
                    "js" => "project-not-found",
                ];
                $this->View("Projects/notFound", $data);
            } else {
                $project["users"] = (new ProjectUserController())->GetUsersByProject((int) $project["id_project"]);
                $project["medias"] = (new MediaController())->GetMedias((int) $project["id_project"]);
                $data = [
                    "title" => "Projeto - $project[title]",
                    "css" => "view-project",
                    "btns" => $this->RenderButtons(),
                    "project" => $project,
                    "js" => "view-project"
                ];
                $this->View("Projects/view", $data);
            }
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