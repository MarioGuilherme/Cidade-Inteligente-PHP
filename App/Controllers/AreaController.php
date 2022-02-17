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
        private function GetModel() {
            $this->areaModel = new Area();
        }

        public function Index() {
            $this->GetModel();
            $areas = $this->areaModel::Select()->fetchAll(PDO::FETCH_ASSOC);
            $data = [
                "title" => "Áreas",
                "css" => "areas",
                "btns" => $this->RenderButtons(),
                "areas" => $areas,
                "js" => "areas"
            ];
            $this->View("Areas/index", $data);
        }

        public function New(array $form) {
            // VERIFICA SE O USUÁRIO É PROFESSOR
            Session::IsAdmin() ? "" : Response::Message(INVALID_PERMISSION);

            // LIMPEZA DOS CAMPOS
            $area = Form::SanatizeField($form["area"], FILTER_SANITIZE_STRING);

            // VERIFICA SE HÁ CAMPOS VAZIOS, SE O EMAIL É VÁLIDO E O CURSO
            Form::VerifyEmptyFields([$area]);

            // OBTÉM O MODELO E CADASTRA UMA NOVA ÁREA
            $this->GetModel();
            $this->areaModel::Insert([
                "area" => $area
            ]) > 0 ? Response::Message(AREA_REGISTERED) : Response::Message(GENERAL_ERROR);
        }

        public function ViewByID(int $id_area) {
            $this->GetModel();
            $area = $this->areaModel::Select("", "id_area = ?", "", "", "*", [$id_area])->fetch(PDO::FETCH_ASSOC);
            Response::Message($area);
        }
    }