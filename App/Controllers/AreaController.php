<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\{
        Controller,
        Page
    };
    use App\Database\Database;
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
        /**
         * Modelo de Área.
         * @var Area
         */
        private Area $model;

        /**
         * Classe do banco de dados com acesso à tabela das áreas.
         */
        private Database $areaDAO;

        /**
         * Método responsável de instanciar o Modelo de Área e o objeto Database para abstração de dados da tabela das áreas.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->model)) $this->model = new Area;
            if (!isset($this->areaDAO)) $this->areaDAO = new Database("areas");
        }

        /**
         * Método responsável por carregar a tela de Áreas.
         * @return void
         */
        public function index() : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança
            $page = new Page(
                "Áreas", // Título da página
                "areas", // Nome do item da navbar a ser desativado
                $this->getAllAreas(), // Dados para a tela
                [ "genericNavbar", "dataTable" ], // Arquivos CSS
                [ "navbar", "areas" ], // Arquivos JS
                "Areas", // Caminho para o formulário de cadastro no modal
            );
            $this->view("Areas/main", $page);
        }

        /**
         * Método responsável por retornar todas as Áreas.
         * @param bool $isForAPI Informa se as áreas deve ser retornadas para uma chamada de API encerrando o script
         * @return array Array com todas as áreas
         */
        public function getAllAreas(bool $isForAPI = false) : array {
            $this->getModel();
            (array) $areas = $this->areaDAO->select()->fetchAll(PDO::FETCH_CLASS, $this->model::class);

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
            (object) $area = $this->areaDAO->select(where: "id_area = ?", params: [$id_area])->fetchObject($this->model::class);
            Response::returnResponse($area);
        }

        /**
         * Método responsável por verificar se uma Área existe pelo ID.
         * @param int $id_area ID da Área
         * @return bool True se existir, false se não existir
         */
        public function areaExists(int $id_area) : bool {
            $this->getModel();
            return !!$this->areaDAO->select(where: "id_area = ?", fields: "id_area", params: [$id_area])->rowCount() > 0;
        }

        /**
         * Método responsável por cadastrar uma Área.
         * @param array $form Dados do formulário
         * @return void
         */
        public function create(array $form) : void {
            Session::checkAuthWithRedirect(); // Verificação completa de segurança

            // LIMPEZA DOS CAMPOS
            (string) $area = Form::sanatizeString($form["area"]);

            // VERIFICAÇÃO DE CAMPOS VAZIOS
            Form::isEmptyFields([$area]);

            // OBTÉM O MODELO E CADASTRA UMA NOVA ÁREA
            $this->getModel();
            (int) $idRegistered = $this->areaDAO->insert(["area" => $area]);

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
            Session::checkAuthWithRedirect(); // Verificação completa de segurança

            // LIMPEZA DOS CAMPOS
            (string) $id_area = Form::sanatizeInt($form["id_area"]);
            (string) $area = Form::sanatizeString($form["area"]);

            // VERIFICA SE HÁ CAMPOS VAZIOS E VALIDA O ID DA ÁREA
            Form::isEmptyFields([$id_area, $area]);

            // OBTÉM O MODELO VERIFICA SE O ID DA ÁREA É VÁLIDO
            if (!$this->areaExists((int) $id_area))
                Response::returnResponse(Response::INVALID_AREA, 400, "error");

            // ATUALIZA A ÁREA E RETORNA A RESPOSTA
            (bool) $isUpdated = $this->areaDAO->update("id_area = $id_area", ["area" => $area]);

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
            Session::checkAuthWithRedirect(); // Verificação completa de segurança

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
            (bool) $isDeleted = $this->areaDAO->delete("id_area = ?", [$id_area]);
    
            $isDeleted ?
                Response::returnResponse(Response::AREA_DELETED, 200, "success") : 
                Response::returnResponse(Response::GENERAL_ERROR, 500, "error");
        }
    }