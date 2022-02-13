<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Media;
    use App\Utils\File;

    /**
     * Classe herdada de Controller responsável por controlar as ações da Mídia.
     *
     * @author Mário Guilherme
     */
    class MediaController extends Controller {
        private Media $mediaModel;

        /**
         *  Método responsável de instanciar o modelo de Mídia.
         * @return void
         */
        private function GetModel() : void {
            $this->mediaModel = new Media();
        }

        /**
         * Método responsável por cadastrar um mídia e fazer o upload do arquivo
         * @param array $projects Dados dos projetos
         * @return array Projetos com suas mídias associadas
         */
        public function NewMedia(array $media) : void {
            $this->GetModel();
            $newMedia = $this->mediaModel->Insert([
                "id_project" => $media["id_project"],
                "name" => $media["name"],
                "type" => $media["type"],
                "path" => File::UploadFile($media),
                "description" => $media["description"]
            ]);
        }

        /**
         * Método responsável 
         * @param array $projects Dados dos projetos
         * @return array Projetos com suas mídias associadas
         */
        public function GetMedias(int $id_project) : array {
            $this->GetModel();
            return $this->mediaModel->Select("", "id_project = ?", "", "", "id_media, name, type, path", [$id_project])->fetchAll(PDO::FETCH_ASSOC);
        }
    }