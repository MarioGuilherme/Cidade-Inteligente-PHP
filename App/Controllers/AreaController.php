<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Area;
    use App\Utils\{
        Form,
        Response,
        Session
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações da Área.
     *
     * @author Mário Guilherme
     */
    class AreaController extends Controller {
        private Area $areaModel;

        /**
         * Método responsável de instanciar o modelo de Área.
         * @return void
         */
        private function GetModel() : void {
            $this->areaModel = new Area();
        }

        public function Index() : void {
            $this->GetModel();
            $data = [
                "title" => "Áreas",
                "css" => "areas",
                "btns" => $this->RenderButtons(),
                "js" => "areas"
            ];
            $this->View("Areas/index", $data);
        }

        public function New(array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            $area = Form::SanatizeField($form["area"], FILTER_SANITIZE_STRING);

            // VERIFICA SE HÁ CAMPOS VAZIOS
            Form::VerifyEmptyFields([$area]);

            // OBTÉM O MODELO E CADASTRA UMA NOVA ÁREA
            $this->GetModel();
            $this->areaModel::Insert([
                "area" => $area
            ]) > 0 ? Response::Message(AREA_REGISTERED) : Response::Message(GENERAL_ERROR);
        }

        public function ViewByID(int $id_area) : void {
            $this->GetModel();
            $area = $this->areaModel::Select("", "id_area = ?", "", "", "*", [$id_area])->fetch(PDO::FETCH_ASSOC);
            Response::Message($area);
        }

        public function List() : void {
            $this->GetModel();
            $areas = $this->areaModel::Select()->fetchAll(PDO::FETCH_ASSOC);
            foreach ($areas as $area) {
                echo "<tr role='row'>
                    <td class='text-center'>$area[id_area]</td>
                    <td class='text-center'>$area[area]</td>
                    <td class='text-center'>
                        <button id='$area[id_area]' class='btn btn-warning btn-edit-area'>
                            Editar
                        </button>
                        <button id='$area[id_area]' class='btn btn-danger btn-delete-area'>
                            Apagar
                        </button>
                    </td>
                </tr>";
            }
        }

        public function Update(array $form) : void {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            $id_area = (int) Form::SanatizeField($form["id_area"], FILTER_SANITIZE_STRING);
            $area = Form::SanatizeField($form["area"], FILTER_SANITIZE_STRING);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::VerifyEmptyFields([$area]);
            Form::ValidateArea($id_area);

            // OBTÉM O MODELO E ATUALIZA A ÁREA
            $this->GetModel();
            $this->areaModel::Update("id_area = $id_area", [
                "area" => $area
            ]) > 0 ? Response::Message(AREA_UPDATED) : Response::Message(GENERAL_ERROR);
        }

        public function Delete(int $id_area) : void {
            $this->GetModel();
            $projects = (new ProjectController)->GetProjectByArea($id_area);
            if($projects)
                Response::Message(AREA_FK_ERROR);
            else
                $this->areaModel::Delete("id_area = ?", [$id_area]) ? Response::Message(AREA_DELETED) : Response::Message(GENERAL_ERROR);
        }
    }