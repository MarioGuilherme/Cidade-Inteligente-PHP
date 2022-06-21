<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Media;
    use App\Utils\{
        File,
        Response
    };

    /**
     * Classe herdada de Controller responsável por controlar as ações da Mídia.
     *
     * @author Mário Guilherme
     */
    class MediaController extends Controller {
        private Media $mediaModel;

        /**
         * Método responsável de instanciar o modelo de Mídia.
         * @return void
         */
        private function GetModel() : void {
            $this->mediaModel = new Media();
        }

        /**
         * Método responsável por cadastrar um mídia e fazer o upload do arquivo
         * @param Array $projects Dados dos projetos
         * @return Array Projetos com suas mídias associadas
         */
        public function NewMedia(Array $media) : void {
            $this->GetModel();
            File::SetFile($media);
            $this->mediaModel::Insert([
                "id_project" => $media["id_project"],
                "name" => $media["name_file"],
                "type" => $media["type"],
                "path" => File::MoveFile(),
                "description" => $media["description"]
            ]);
        }

        public function UpdateDataMedia(Array $form) : void {
            $this->GetModel();
            $this->mediaModel::Update("id_media = $form[id_media]", [
                "name" => $form["name_file"],
                "description" => $form["description"]
            ]);
        }

        public function Update(Int $id_media, Array $media) : void {
            $this->GetModel();
            (String) $path = $this->mediaModel::Select("", "id_media = ?", "", "", "path", [$id_media])->fetch(PDO::FETCH_ASSOC)["path"];
            File::DeleteFile($path);
            File::SetFile($media);
            $this->mediaModel::Update("id_media = $id_media", [
                "type" => $media["type"],
                "path" => File::MoveFile()
            ]);
            Response::Message(MEDIA_UPDATED);
        }

        /**
         * Método responsável 
         * @param Array $projects Dados dos projetos
         * @return Array Projetos com suas mídias associadas
         */
        public function GetAllMedias(Int $id_project) : Array {
            $this->GetModel();
            return $this->mediaModel::Select("", "id_project = ?", "", "", "id_media, name, type, path, description", [$id_project])->fetchAll(PDO::FETCH_ASSOC);
        }

        public function Delete(Int $id_media) : void {
            $this->GetModel();
            (String) $path = $this->mediaModel::Select("", "id_media = ?", "", "", "path", [$id_media])->fetch(PDO::FETCH_ASSOC)["path"];
            $this->mediaModel::Delete("id_media = ?", [$id_media]);
            File::DeleteFile($path);
            Response::Message(MEDIA_DELETED);
        }

        public function DeleteProjectMedias(Array $medias) : void {
            for((Int) $i = 0; $i < count($medias); $i++) {
                File::DeleteFile($medias[$i]["path"]);
            }
        }
    }