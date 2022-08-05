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
     * @author Mário Guilherme
     */
    class AreaController extends Controller {
        private Area $areaModel;

        /**
         * Método responsável de instanciar o modelo de Área.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->areaModel)) $this->areaModel = new Area;
        }

        /**
         * Método responsável por carregar a tela de Áreas.
         * @return void
         */
        public function index() : void {
            Session::checkAuthWithRedirect(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            (array) $page = [ // VÁRIAVEL COM AS INFORMAÇÕES DA PÁGINA
                "title" => "Áreas",
                "currentNavItem" => "areas",
                "areas" => $this->getAllAreas(),
                "pathForm" => "Areas",
                "css" => [
                    "font",
                    "global",
                    "genericNavbar",
                    "dataTable"
                ],
                "js" => [
                    "navbar",
                    "areas"
                ]
            ];
            $this->view("Areas/main", $page);
        }

        /**
         * Método responsável por retornar todas as Áreas.
         * @param bool $isForAPI Informa se as áreas deve ser retornadas para uma chamada de API encerrando o script
         * @return array Array com todas as áreas
         */
        public function getAllAreas(bool $isForAPI = false) : array {
            $this->getModel();
            (array) $areas = $this->areaModel::select()->fetchAll(PDO::FETCH_ASSOC);

            if ($isForAPI) // Se true, ele encerra o script com o json (usado para chamada da api)
                Response::returnResponse($areas);

            return $areas;
        }

        /**
         * Método responsável por retornar os dados de uma Área a partir de seu ID.
         * @param int $id_area ID da Área
         * @return void
         */
        public function getAreaByID(int $id_area) : void {
            $this->getModel();
            (array) $area = $this->areaModel::select(where: "id_area = ?", params: [$id_area])->fetch(PDO::FETCH_ASSOC);
            Response::returnResponse($area);
        }

        /**
         * Método responsável por verificar se uma Área existe pelo ID.
         * @param int $id_area ID da Área
         * @return bool True se existir, false se não existir
         */
        public function areaExists(int $id_area) : bool {
            $this->getModel();
            return !!$this->areaModel::select(where: "id_area = ?", fields: "id_area", params: [$id_area])->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Método responsável por cadastrar uma Área.
         * @param array $form Dados do formulário
         * @return void
         */
        public function create(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $area = Form::sanatizeString($form["area"]);

            // VERIFICAÇÃO DE CAMPOS VAZIOS
            Form::isEmptyFields([$area]);

            // OBTÉM O MODELO E CADASTRA UMA NOVA ÁREA
            $this->getModel();
            (int) $idRegistered = $this->areaModel::insert(["area" => $area]);

            $idRegistered > 0
                ? Response::returnResponse(Response::AREA_REGISTERED, 201, "success")
                : Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por atualizar uma Área.
         * @param array $form Dados do formulário
         * @return void
         */
        public function update(array $form) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            (string) $id_area = Form::sanatizeInt($form["id_area"]);
            (string) $area = Form::sanatizeString($form["area"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::isEmptyFields([$id_area, $area]);

            // OBTÉM O MODELO VERIFICA SE O ID DA ÁREA É VÁLIDO
            if (!$this->areaExists((int) $id_area))
                Response::returnResponse(Response::INVALID_AREA, 400, "error");

            // ATUALIZA A ÁREA E RETORNA A RESPOSTA
            (bool) $isUpdated = $this->areaModel::update("id_area = $id_area", ["area" => $area]);

            $isUpdated ?
                Response::returnResponse(Response::AREA_UPDATED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }

        /**
         * Método responsável por excluir uma Área.
         * @param string $id_area ID da Área
         * @return void
         */
        public function delete(string $id_area) : void {
            Session::checkAuthWithJson(); // VERIFICAÇÃO BRUTA DE SEGURANÇA

            // LIMPEZA DOS CAMPOS
            $id_area = Form::sanatizeInt($id_area);
    
            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::isEmptyFields([$id_area]);
    
            // OBTÉM O MODELO E VERIFICA SE ESTA ÁREA EXISTE E SE ESTÁ RELACIONADA A ALGUM PROJETO
            if (!$this->areaExists((int) $id_area))
                Response::returnResponse(Response::INVALID_AREA, 400, "error");
    
            (bool) $hasProjectsLinked = (new ProjectController)->areaHasProjectsLinked((int) $id_area);
    
            if ($hasProjectsLinked)
                Response::returnResponse(Response::AREA_FK_ERROR, 403, "error");
    
            // DELETA A ÁREA E RETORNA A RESPOSTA
            (bool) $isDeleted = $this->areaModel::delete("id_area = ?", [$id_area]);
    
            $isDeleted ?
                Response::returnResponse(Response::AREA_DELETED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }
    }