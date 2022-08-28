<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Media;
    use App\Database\Database;
    use App\Utils\{
        File
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações da Mídia.
     * @author Mário Guilherme
     */
    class MediaController extends Controller {
        /**
         * Modelo de Mídia.
         * @var Media
         */
        private Media $model;

        /**
         * Classe do banco de dados com acesso à tabela das mídias.
         */
        private Database $mediaDAO;

        /**
         * Método responsável de instanciar o modelo de Mídia e o objeto Database para abstração de dados da tabela das midias.
         * @return void
         */
        private function getModel() : void {
            if (!isset($this->model)) $this->model = new Media;
            if (!isset($this->mediaDAO)) $this->mediaDAO = new Database("medias");
        }

        /**
         * Método responsável por retornar o nome de um arquivo de acordo com o seu id do banco de dados.
         * @param int $id_media ID da mídia
         * @return string Nome do arquivo
         */
        public function getFileNameByID(int $id_media) : string {
            $this->getModel();
            return $this->mediaDAO->select(where: "id_media = ?", fields: "fileName", params: [$id_media])->fetchObject($this->model::class)->fileName;
        }

        /**
         * Método responsável por retornar os dados básicos (renderizar carrosel) de todas as mídias de um projeto.
         * @param int $id_project ID do projeto
         * @return array Array de mídias
         */
        public function getMediasByProjectToCard(int $id_project) : array {
            $this->getModel();
            return $this->mediaDAO->select(where: "id_project = ?", fields: "id_media, type, fileName", params: [$id_project])->fetchAll(PDO::FETCH_CLASS, $this->model::class);
        }

        /**
         * Método responsável por retornar todos os dados de uma mídia para exibição completa de um projeto.
         * @param int $id_project ID do projeto
         * @return array Array de mídias
         */
        public function getMediasByProjectToDetails(int $id_project) : array {
            $this->getModel();
            return $this->mediaDAO->select(where: "id_project = ?", fields: "id_media, name, type, size, fileName, description", params: [$id_project])->fetchAll(PDO::FETCH_CLASS, $this->model::class);
        }

        /**
         * Método responsável por criar uma mídia no servidor de seu base64 e cadastrá-la no banco de dados já relacionado com o projeto.
         * @param array $media Dados da mídia
         * @param int $id_project ID do projeto
         * @return void
         */
        public function create(array $media, int $id_project) : void {
            $this->getModel();
            $this->mediaDAO->insert([
                "id_project" => $id_project,
                "name" => $media["name"],
                "type" => $media["type"],
                "size" => $media["size"],
                "fileName" => File::createFile($media["base64"], $media["type"]),
                "description" => $media["description"]
            ]);
        }

        /**
         * Método responsável por atualizar os dados de uma mídia mas sem alterar o arquivo.
         * @param array $media Dados da mídia
         * @return void
         */
        public function updateWithoutBase64(array $media) : void {
            $this->getModel();
            $this->mediaDAO->update("id_media = $media[id_media]", [
                "name" => $media["name"],
                "description" => $media["description"]
            ]);
        }

        /**
         * Método responsável por atualizar uma mídia no servidor de seu base64 e seus dados como nome, tamanho, tipo e descrição.
         * @param array $media Dados da mídia
         * @return void
         */
        public function updateFullMedia(array $media) : void {
            (string) $fileName = $this->getFileNameByID((int) $media["id_media"]);
            File::updateFileContent($fileName, $media["base64"]);
            $this->mediaDAO->update("id_media = $media[id_media]", [
                "name" => $media["name"],
                "type" => $media["type"],
                "size" => $media["size"],
                "description" => $media["description"]
            ]);
        }

        /**
         * Método responsável por deletar uma mídia do servidor e no banco de dados.
         * @param int $id_media ID da mídia
         * @return void
         */
        public function delete(int $id_media) : void {
            (string) $fileName = $this->getFileNameByID((int) $id_media);
            $this->mediaDAO->delete("id_media = ?", [$id_media]);
            File::deleteFile($fileName);
        }
    }