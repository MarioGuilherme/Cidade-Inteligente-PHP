<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Course;
    use App\Utils\{
        Form,
        Response,
        Session
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações do Curso.
     * @author Mário Guilherme
     */
    class CourseController extends Controller {
        private Course $courseModel;

        /**
         * Método responsável de instanciar o modelo de Curso.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->courseModel)) $this->courseModel = new Course;
        }

        /**
         * Método responsável por carregar a tela de Cursos.
         * @return void
         */
        public function index() : void {
            Session::checkAuthWithRedirect(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            (array) $page = [ // Variável com as informações da página
                "title" => "Cursos",
                "currentNavItem" => "cursos",
                "courses" => $this->getAllCourses(),
                "pathForm" => "Courses",
                "css" => [
                    "font",
                    "global",
                    "genericNavbar",
                    "dataTable"
                ],
                "js" => [
                    "navbar",
                    "courses"
                ]
            ];
            $this->view("Courses/main", $page);
        }

        /**
         * Método responsável por retornar todos os Cursos.
         * @param bool $isForAPI Informa se os cursos deve ser retornadas para uma chamada de API encerrando o script
         * @return array Array com todos os cursos
         */
        public function getAllCourses(bool $isForAPI = false) : array {
            $this->getModel();
            (array) $courses = $this->courseModel::select()->fetchAll(PDO::FETCH_ASSOC);

            if ($isForAPI) // Se true, ele encerra o script com o json (usado para chamada da api)
                Response::returnResponse($courses);

            return $courses;
        }

        /**
         * Método responsável por retornar os dados de um Curso a partir de seu ID.
         * @param int $id_course ID do Curso
         * @return void
         */
        public function getCourseByID(int $id_course) : void {
            $this->getModel();
            (array) $course = $this->courseModel::select(where: "id_course = ?", params: [$id_course])->fetch(PDO::FETCH_ASSOC);
            Response::returnResponse($course);
        }

        /**
         * Método responsável por verificar se um Curso existe pelo ID.
         * @param int $id_course ID do Curso
         * @return bool True se existir, false se não existir
         */
        public function courseExists(int $id_course) : bool {
            $this->getModel();
            return !!$this->courseModel::select(where: "id_course = ?", fields: "id_course", params: [$id_course])->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Método responsável por cadastrar um Curso.
         * @param array $form Dados do formulário
         * @return void
         */
        public function create(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $course = Form::sanatizeString($form["course"]);

            // VERIFICAÇÃO DE CAMPOS VAZIOS
            Form::isEmptyFields([$course]);

            // OBTÉM O MODELO E CADASTRA UM NOVO CURSO
            $this->getModel();
            (int) $idRegistered = $this->courseModel::insert(["course" => $course]);

            $idRegistered > 0
                ? Response::returnResponse(Response::COURSE_REGISTERED, 201, "success")
                : Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por atualizar um Curso.
         * @param array $form Dados do formulário
         * @return void
         */
        public function update(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $id_course = Form::sanatizeInt($form["id_course"]);
            (string) $course = Form::sanatizeString($form["course"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DO CURSO
            Form::isEmptyFields([$id_course, $course]);

            // OBTÉM O MODELO E VERIFICA SE O ID DO CURSO É VÁLIDO
            if (!$this->courseExists((int) $id_course))
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            // ATUALIZA O CURSO E RETORNA A RESPOSTA
            (bool) $isUpdated = $this->courseModel::update("id_course = $id_course", ["course" => $course]);

            $isUpdated ?
                Response::returnResponse(Response::COURSE_UPDATED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por excluir um Curso.
         * @param string $id_course ID do Curso
         * @return void
         */
        public function delete(string $id_course) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $id_course = Form::sanatizeInt($id_course);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DO CURSO
            Form::isEmptyFields([$id_course]);

            // OBTÉM O MODELO E VERIFICA SE ESTE CURSO EXISTE E SE ESTÁ RELACIONADA A ALGUM PROJETO E USUÁRIO
            if (!$this->courseExists((int) $id_course))
                Response::returnResponse(Response::INVALID_COURSE, 400, "error");

            (bool) $hasProjectsLinked = (new ProjectController)->courseHasProjectsLinked((int) $id_course);
            (bool) $hasUsersLinked = (new UserController)->courseHasUsersLinked((int) $id_course);

            if ($hasProjectsLinked || $hasUsersLinked)
                Response::returnResponse(Response::COURSE_FK_ERROR, 403, "error");

            // DELETA O CURSO E RETORNA A RESPOSTA
            (bool) $isDeleted = $this->courseModel::delete("id_course = ?", [$id_course]);

            $isDeleted ?
                Response::returnResponse(Response::COURSE_DELETED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }
    }