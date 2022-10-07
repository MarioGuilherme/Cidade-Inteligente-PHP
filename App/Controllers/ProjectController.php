<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\{
        Controller,
        Page
    };
    use App\Controllers\{
        MediaController,
        UserController
    };
    use App\Database\Database;
    use App\Models\{
        Project,
        User
    };
    use App\Utils\{
        File,
        Form,
        Response,
        Session
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações do Projeto
     * @author Mário Guilherme
     */
    class ProjectController extends Controller {
        /**
         * Modelo de Curso.
         * @var Project
         */
        private Project $projectModel;

        /**
         * Modelo de Usuário.
         * @var Project_User
         */
        private User $userModel;

        /**
         * Classe do banco de dados com acesso à tabela dos cursos.
         */
        private Database $projectDAO;

        /**
         * Método responsável de instanciar o modelo de Curso e o objeto Database para abstração de dados da tabela dos cursos.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->projectModel)) $this->projectModel = new Project;
            if (!isset($this->userModel)) $this->userModel = new User;
            if (!isset($this->projectDAO)) $this->projectDAO = new Database("projects");
        }

        /**
         * Método responsável por carregar a página principal, listando todos os projetos e suas mídias.
         * @param int $currentPage Número da página atual
         * @return void
         */
        public function index(int $currentPage) : void {
            $this->getModel();
            $totalProjects = $this->projectDAO->select(fields: "COUNT(*)")->fetchColumn();

            if ($currentPage <= 0)
                $currentPage = 1;

            // Lógica para aplicar 8 projetos por página
            (float) $totalPages = ceil($totalProjects / 8);
            if ($currentPage > $totalPages) // Se for acessado uma página que não existir na lista, redireciona para a última página
                $currentPage = (int) $totalPages == 0 ? 1 : $totalPages;

            (array) $projects = $this->projectDAO->select(
                fields: "id_project, title, description",
                limit: ($currentPage * 8 - 8) . ", 8"
            )->fetchAll(PDO::FETCH_CLASS, $this->projectModel::class);

            (object) $mediaController = new MediaController;
            foreach ($projects as $key => $project)
                $projects[$key]->medias = $mediaController->getMediasByProjectToCard($project->id_project);

            $page = new Page(
                "Projetos", // Título da página
                URL, // Nome do item da navbar a ser desativado
                [
                    "projects" => $projects,
                    "totalPages" => $totalPages,
                    "currentPage" => $currentPage
                ], // Dados para a tela
                [ "indexNavbar", "projects" ], // Arquivos CSS
                [ "projects" ], // Arquivos JS
                "Areas", // Caminho para o formulário de cadastro no modal
            );
            $this->view("Projects/main", $page);
        }

        /**
         * Método responsável de carregar a tela de visualização de um projeto.
         * @param int $id_project ID do projeto
         * @return void
         */
        public function viewProject(int $id_project) : void {
            $this->getModel();
            (object) $project = $this->projectDAO->select(
                join: "p INNER JOIN areas a ON p.id_area = a.id_area INNER JOIN courses c ON p.id_course = c.id_course",
                where: "p.id_project = ?",
                fields: "id_project, title, a.area, c.course, description, startDate, endDate",
                params: [$id_project]
            )->fetchObject($this->projectModel::class);

            if (empty($project)) {
                $page = new Page(
                    "404 - Projeto não encontrado", // Título da página
                    "", // Nome do item da navbar a ser desativado
                    [], // Dados para a tela
                    [ "genericNavbar" ], // Arquivos CSS
                    [], // Arquivos JS
                );
                $this->view("Projects/notFound", $page);
            }

            $project->users = (new ProjectUserController)->getAllUsersByProject($project->id_project);
            $project->medias = (new MediaController)->getMediasByProjectToDetails($project->id_project);
            $page = new Page(
                "Projeto - $project->id_project", // Título da página
                "", // Nome do item da navbar a ser desativado
                [ "project" => $project ], // Dados para a tela
                [ "genericNavbar" ], // Arquivos CSS
                [ "qrcode.min", "viewProject" ], // Arquivos JS
            );
            $this->view("Projects/view", $page);
        }

        /**
         * Método responsável por carregar o formulário para criar um projeto.
         * @return void
         */
        public function formProject() : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança
            $page = new Page(
                "Criar Projeto", // Título da página
                "criar-projeto", // Nome do item da navbar a ser desativado
                [
                    "users" => (new UserController)->getAllUsers(false),
                    "areas" => (new AreaController)->getAllAreas(false),
                    "courses" => (new CourseController)->getAllCourses(false)
                ], // Dados para a tela
                [ "genericNavbar", "form", "createProject" ], // Arquivos CSS
                [ "createProject", "qrcode.min" ], // Arquivos JS
            );
            $this->view("Projects/form", $page);
        }

        /**
         * Método responsável por carregar a View do formulário para editar um projeto de acordo com seu id.
         * @param int $id_project ID do projeto
         * @return void
         */
        public function viewEditProject(int $id_project) : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança

            $this->getModel();
            (array) $project = $this->projectDAO->select(
                join: "p INNER JOIN areas a ON p.id_area = a.id_area INNER JOIN courses c ON p.id_course = c.id_course",
                where: "p.id_project = ?",
                fields: "p.id_project, title, a.id_area, c.id_course, description, startDate, endDate",
                params: [$id_project]
            )->fetchObject($this->projectModel::class);

            if (empty($project)) {
                $page = new Page(
                    "Projeto não encontrado", // Título da página
                    "", // Nome do item da navbar a ser desativado
                    [], // Dados para a tela
                    [ "genericNavbar" ], // Arquivos CSS
                    [], // Arquivos JS
                );
                $this->view("Projects/notFound", $page);
            }

            if (!$this->userIsRelatedWithProject((int) $id_project)) {// Verifica se o usuário editor está incluido no projeto
                $page = new Page(
                    "Acesso restrito", // Título da página
                    "", // Nome do item da navbar a ser desativado
                    [], // Dados para a tela
                    [ "genericNavbar" ], // Arquivos CSS
                    [], // Arquivos JS
                );
                $this->view("Projects/Forbidden", $page);
            }

            (array) $allUsers = (new UserController)->getAllUsers();
            (array) $usersOfProject = (new ProjectUserController)->getAllUsersByProject($project->id_project);
            $project->medias = (new MediaController)->getMediasByProjectToDetails($project->id_project);

            for ($i = 0; $i < count($allUsers); $i++) {
                $allUsers[$i]->involved = false;
                for ($j = 0; $j < count($usersOfProject); $j++)
                    if ($allUsers[$i]->id_user == $usersOfProject[$j]->id_user)
                        $allUsers[$i]->involved = true;
            }

            $page = new Page(
                "Editar Projeto - $project->id_project", // Título da página
                "", // Nome do item da navbar a ser desativado
                [
                    "project" => $project,
                    "areas" => (new AreaController)->getAllAreas(),
                    "courses" => (new CourseController)->getAllCourses(),
                    "allUsers" => $allUsers
                ], // Dados para a tela
                [ "genericNavbar", "form", "editProject" ], // Arquivos CSS
                [ "editProject" ], // Arquivos JS
            );
            $this->view("Projects/edit", $page);
        }

        /**
         * Método responsável por verificar se um Projeto existe pelo ID.
         * @param int $id_project ID do Curso.
         * @return bool True se existir, false se não existir.
         */
        public function projectExists(int $id_project) : bool {
            $this->getModel();
            return !!$this->projectDAO->select(where: "id_project = ?", fields: "id_project", params: [$id_project])->rowCount() > 0;
        }

        /**
         * Método responsável por verificar se existem projetos relacionado ao ID do Curso.
         * @param int $id_course ID do Curso.
         * @return bool True se existir, false se não.
         */
        public function courseHasProjectsLinked(int $id_course) : bool {
            $this->getModel();
            return $this->projectDAO->select(where: "id_course = ?", fields: "id_project", params: [$id_course])->rowCount() > 0;
        }

        /**
         * Método responsável por verificar se existem projetos relacionado ao ID da Área.
         * @param int $id_area ID da área
         * @return bool True se existir, false se não.
         */
        public function areaHasProjectsLinked(int $id_area) : bool {
            $this->getModel();
            return $this->projectDAO->select(where: "id_area = ?", fields: "id_project", params: [$id_area])->rowCount() > 0;
        }

        /**
         * Método responsável por verificar se o usuário logado está relacionado um determinado projeto.
         * @param int $id_project ID da área
         * @return bool True se estiver, false se não.
         */
        public function userIsRelatedWithProject(int $id_project) : bool {
            $this->getModel();
            return (new ProjectUserController)->projectUserDAO->select(
                fields: "id_project",
                where: "id_user = ? AND id_project = ?",
                params: [$_SESSION["id_user"], $id_project]
            )->rowCount() > 0;
        }

        /**
         * Método responsável por cadastrar um projeto.
         * @param array $form Dados do formulário
         * @return void
         */
        public function create(array $form) : void {
            Session::checkAuthWithJson(); // Verificação completa de segurança

            // LIMPEZA DOS DADOS DO PROJETO
            (string) $title = Form::sanatizeString($form["title"]);
            (string) $startDate = Form::convertToDate($form["startDate"]);
            (string) $endDate = Form::convertToDate($form["endDate"]);
            (string) $description = Form::sanatizeString($form["description"]);
            (string) $id_area = Form::sanatizeInt($form["id_area"]);
            (string) $id_course = Form::sanatizeInt($form["id_course"]);
            (array) $users = [];
            (array) $medias = [];

            foreach ($form["users"] as $id_user) // LIMPA OS IDS DOS USUÁRIOS
                $users[] = Form::sanatizeInt($id_user);

            foreach ($form["medias"] as $media) // LIMPA OS DADOS DAS MÍDIAS
                $medias[] = [
                    "name" => Form::sanatizeString($media["name"]),
                    "description" => Form::sanatizeString($media["description"]),
                    "type" => Form::sanatizeString($media["type"]),
                    "size" => File::getSize($media["base64"]),
                    "base64" => $media["base64"]
                ];

            Form::isEmptyFields([$title, $startDate, $endDate, $description, $id_area, $id_course]); // VERIFICA SE HÁ CAMPOS VAZIOS

            if (count($users) == 0 || count($medias) == 0) // VERIFICA SE HÁ USUÁRIOS OU MÍDIAS
                Response::returnResponse(Response::EMPTY_USERS_OR_MEDIA, 400, "error");

            foreach ($medias as $media) // VERIFICA SE O ARQUIVO É VÁLIDO
                File::isValidFile($media);

            foreach ($medias as $media) // VERIFICA SE OS DADOS PREENCHIDOS PARA AS MÍDIAS NÃO ESTÃO VAZIOS
                Form::isEmptyFields([$media["name"], $media["type"], $media["description"], (string) $media["size"], $media["base64"]]);

            if (!(new CourseController)->courseExists((int) $id_course)) // VERIFICA O ID DO CURSO
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            if (!(new AreaController)->areaExists((int) $id_area)) // VERIFICA O ID DA ÁREA
                Response::returnResponse(Response::INVALID_AREA, 400, "error");

            $this->getModel(); // INSTANCIA O MODELO DE PROJETO E PROJETO_USUARIO E FAZ A INSERÇÃO NA TEBELA DE PROJETOS
            (int) $idProjectRegistered = $this->projectDAO->insert([
                "id_area" => $id_area,
                "id_course" => $id_course,
                "title" => $title,
                "description" => $description,
                "startDate" => $startDate,
                "endDate" => $endDate
            ]);

            if ($idProjectRegistered == 0) // VERIFICA SE O PROJETO FOI CADASTRADO
                Response::returnResponse(Response::GENERAL_ERROR, 400, "error");

            (object) $projectUserController = new ProjectUserController;
            (object) $mediaController = new MediaController;
            foreach ($users as $id_user) // INSERE E RELACIONA OS USUÁRIOS COM O PROJETO CADASTRADO
                $projectUserController->projectUserDAO->insert([
                    "id_project" => $idProjectRegistered,
                    "id_user" => $id_user
                ]);

            foreach ($medias as $media) // CRIA A MÍDIA NO SERVIDOR E A CADASTRA NO BANCO
                $mediaController->create($media, $idProjectRegistered);

            Response::returnResponse(URL . "ver-projeto?id=$idProjectRegistered", 200, "success");
        }

        /**
         * Método responsável por atualizar um projeto.
         * @param array $data Dados do projeto.
         */
        public function update(array $form) : void {
            Session::checkAuthWithJson(); // Verificação completa de segurança

            // LIMPEZA DOS DADOS DO PROJETO
            (string) $id_project = Form::sanatizeString($form["id_project"]);
            (string) $title = Form::sanatizeString($form["title"]);
            (string) $startDate = Form::convertToDate($form["startDate"]);
            (string) $endDate = Form::convertToDate($form["endDate"]);
            (string) $description = Form::sanatizeString($form["description"]);
            (string) $id_area = Form::sanatizeInt($form["id_area"]);
            (string) $id_course = Form::sanatizeInt($form["id_course"]);
            (array) $users = [];
            (array) $medias = [];
            (array) $mediasToDelete = [];

            foreach ($form["users"] as $id_user) // LIMPA OS IDS DOS USUÁRIOS
                $users[] = Form::sanatizeInt($id_user);

            foreach ($form["mediasToDelete"] as $id_media) // LIMPA OS IDS DAS MÍDIAS A SEREM DELETADAS
                $mediasToDelete[] = Form::sanatizeInt($id_media);

            foreach ($form["medias"] as $media)
                $medias[] = [
                    "id_media" => array_key_exists("id_media", $media) ? Form::sanatizeInt($media["id_media"]) : "0",
                    "name" => Form::sanatizeString($media["name"]),
                    "description" => Form::sanatizeString($media["description"]),
                    "type" => Form::sanatizeString($media["type"]),
                    "size" => (strlen($media["base64"]) <= 28) ? $media["size"] : File::getSize($media["base64"]),
                    "base64" => $media["base64"],
                ];

            Form::isEmptyFields([$title, $startDate, $endDate, $description, $id_area, $id_course]); // VERIFICA SE HÁ CAMPOS VAZIOS

            if (count($users) == 0 || count($medias) == 0) // VERIFICA SE HÁ USUÁRIOS OU MÍDIAS
                Response::returnResponse(Response::EMPTY_USERS_OR_MEDIA, 400, "error");

            foreach ($medias as $media) // VERIFICA SE APENAS ARQUIVOS NOVOS É VÁLIDO
                if (strlen($media["base64"]) > 28)
                    File::isValidFile($media);

            foreach ($medias as $media) // VERIFICA SE OS DADOS PREENCHIDOS PARA AS MÍDIAS NÃO ESTÃO VAZIOS
                Form::isEmptyFields([$media["name"], $media["type"], $media["description"], $media["type"], $media["base64"]]);

            if (!$this->userIsRelatedWithProject((int) $id_project)) // Verifica se o usuário editor está incluido no projeto
                Response::returnResponse(Response::USER_NOT_RELATED, 403, "error");

            if (!$this->projectExists((int) $id_project)) // VERIFICA O ID DO PROJETO
                Response::returnResponse(Response::INVALID_PROJECT, 400, "error");

            if (!(new CourseController)->courseExists((int) $id_course)) // VERIFICA O ID DO CURSO
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            if (!(new AreaController)->areaExists((int) $id_area)) // VERIFICA O ID DA ÁREA
                Response::returnResponse(Response::INVALID_AREA, 400, "error");

            // FAZ A ATUALIZAÇÃO NA TEBELA DE PROJETOS
            (bool) $isUpdatedProject = $this->projectDAO->update("id_project = $id_project", [
                "id_area" => $id_area,
                "id_course" => $id_course,
                "title" => $title,
                "description" => $description,
                "startDate" => $startDate,
                "endDate" => $endDate
            ]);

            if ($isUpdatedProject == 0) // VERIFICA SE O PROJETO FOI ATUALIZADO
                Response::returnResponse(Response::GENERAL_ERROR, 400, "error");

            (object) $projectUserController = new ProjectUserController;
            (object) $mediaController = new MediaController;

            $projectUserController->projectUserDAO->delete("id_project = ?", [$id_project]);
            foreach ($users as $id_user)
                $projectUserController->projectUserDAO->insert([
                    "id_project" => $id_project,
                    "id_user" => $id_user
                ]);

            (object) $mediaController = new MediaController;
            foreach ($medias as $media) {
                if ($media["id_media"] != "0") { // A MÍDIA EXIST NO SERVIDOR
                    if (strlen($media["base64"]) <= 28)
                        $mediaController->updateWithoutBase64($media); // ATUALIZA APENAS O NOME E A DESCRIÇÃO
                    else
                        $mediaController->updateFullMedia($media); // ATUALIZA TODOS OS DADOS DA MÍDIA
                } else
                    $mediaController->create($media, (int) $id_project);
            }

            foreach ($mediasToDelete as $id_media) // DELETA AS MÍDIAS
                $mediaController->delete((int) $id_media);

            Response::returnResponse(Response::PROJECT_UPDATED, 200, "success");
        }

        /**
         * Método responsável por deletar um projeto e todas as suas mídias e relaçionamentos com usuários.
         * @param string $id_project ID do projeto
         * @return void
         */
        public function delete(string $id_project) : void {
            Session::checkAuthWithJson(); // Verificação completa de segurança

            // VERIFICA SE PROJETO EXISTE
            if (!$this->projectExists((int) $id_project))
                Response::returnResponse(Response::INVALID_PROJECT, 400, "error");

            if (!$this->userIsRelatedWithProject((int) $id_project)) // Verifica se o usuário editor está incluido no projeto
                Response::returnResponse(Response::USER_NOT_RELATED, 403, "error");

            (array) $medias = (new MediaController)->getMediasByProjectToCard((int) $id_project);    

            // DELETA O PROJETO
            $this->getModel();
            (bool) $isDeleted = $this->projectDAO->delete("id_project = ?", [$id_project]);

            if ($isDeleted) {
                foreach ($medias as $media)
                    File::deleteFile($media->fileName);

                Response::returnResponse(Response::PROJECT_DELETED, 200, "success");
            }

            Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }
    }