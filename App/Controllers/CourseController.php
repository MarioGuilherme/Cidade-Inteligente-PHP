<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\Course;
    use App\Utils\{
        Form,
        Response,
        Session
    };
    use PDO;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Curso.
     *
     * @author Mário Guilherme
     */
    class CourseController extends Controller {
        private Course $courseModel;

        /**
         * Método responsável de instanciar o modelo de Curso.
         * @return void
         */
        private function GetModel() {
            $this->courseModel = new Course();
        }

        public function ViewByID(Int $id_course) : void {
            $this->GetModel();
            (Array) $course = $this->courseModel::Select("", "id_course = ?", "", "", "*", [$id_course])->fetch(PDO::FETCH_ASSOC);
            Response::Message($course);
        }

        public function Delete(Int $id_course) : void {
            $this->GetModel();
            (Int) $projects = (new ProjectController)->GetProjectByCourse($id_course);
            (Int) $users = (new UserController)->GetUserByCourse($id_course);
            if($projects > 0 || $users > 0)
                Response::Message(COURSE_FK_ERROR);
            else
                $this->courseModel::Delete("id_course = ?", [$id_course]) ? Response::Message(COURSE_DELETED) : Response::Message(GENERAL_ERROR);
        }

        public function New(Array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            (String) $course = Form::SanatizeField($form["course"], FILTER_UNSAFE_RAW);

            // VERIFICA SE HÁ CAMPOS VAZIOS
            Form::VerifyEmptyFields([$course]);

            // OBTÉM O MODELO E CADASTRA UMA NOVA ÁREA
            $this->GetModel();
            $this->courseModel::Insert([
                "course" => $course
            ]) > 0 ? Response::Message(COURSE_REGISTERED) : Response::Message(GENERAL_ERROR);
        }

        public function Update(Array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            (Int) $id_course = Form::SanatizeField($form["id_course"], FILTER_SANITIZE_NUMBER_INT);
            (String) $course = Form::SanatizeField($form["course"], FILTER_UNSAFE_RAW);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::VerifyEmptyFields([$course]);
            Form::ValidateCourse($id_course);

            // OBTÉM O MODELO E ATUALIZA A ÁREA
            $this->GetModel();
            $this->courseModel::Update("id_course = $id_course", [
                "course" => $course
            ]) > 0 ? Response::Message(COURSE_UPDATED) : Response::Message(GENERAL_ERROR);
        }

        public function List() : void {
            $this->GetModel();
            (Array) $courses = $this->courseModel::Select()->fetchAll(PDO::FETCH_ASSOC);
            foreach ($courses as $course) {
                echo "<tr role='row'>
                        <td class='text-center'>
                            $course[id_course]
                        </td>
                        <td class='text-center'>
                            $course[course]
                        </td>
                        <td class='text-center'>
                            <button id='$course[id_course]' class='btn btn-warning btn-edit-course'>
                                Editar
                            </button>
                            <button id='$course[id_course]' class='btn btn-danger btn-delete-course'>
                                Apagar
                            </button>
                        </td>
                    </tr>";
            }
        }

        public function Index() : void {
            $this->GetModel();
            (Array) $data = [
                "title" => "Cursos",
                "css" => "courses",
                "btns" => $this->RenderButtons(),
                "js" => "courses"
            ];
            $this->View("Courses/index", $data);
        }

        public function GetAllCourses() {
            $this->GetModel();
            return $this->courseModel::Select()->fetchAll(PDO::FETCH_ASSOC);
        }
    }