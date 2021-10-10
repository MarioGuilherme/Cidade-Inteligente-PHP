<?php

    namespace App\Model\DAO;
    use App\Database\Connection;
    use App\Utils\Utils;
    use App\Utils\File;

    class MediaDAO{
        /**
         * Objeto PDO
         * @var PDO
         */
        private $PDO;

        /**
         * Construtor que inicializa o objeto PDO e carrega as respostas
         * @return void
         */
        public function __construct(){
            $this->PDO = Connection::Connect();
            Utils::LoadResponses();
        }

        /**
         * Função que deleta um registro das midias
         * @param Media $media
         * @return array
         */
        public function Delete($media){
            $sql = "DELETE FROM medias WHERE id_media = ?";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([$media->getId_media()]);
            if($stmt->rowCount()){
                File::DeleteMedia($media->getPath());
                return MEDIA_DELETED;
            }else{
                return GENERAL_ERROR;
            }
        }

        /**
         * Função responsável por fazer o da mídia registro no banco de dados
         * @param Media $media
         * @return boolean
         */
        public function Create($media){
            try{
                $sql = "INSERT INTO medias (id_project, name, type, path, description) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    $media->getId_project(),
                    $media->getName(),
                    $media->getType(),
                    $media->getpath(),
                    $media->getDescription()
                ]);
                return $stmt->rowCount() ? true : GENERAL_ERROR;
            }catch(\PDOException $e){
                return "Erro: {$e->getMessage()}";
            }
        }
    }