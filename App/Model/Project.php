<?php

    namespace App\Model;
    use App\Server\Connection;
    use PDO;

    class Project extends Connection{
        public function Select(){
            $sql = "SELECT p.id_projeto, a.descricao AS area, c.curso, descricao_geral,
            descricao_detalhe, data FROM projetos p
            INNER JOIN areas a ON p.id_area = a.id_area
            INNER JOIN cursos c ON p.id_curso = c.id_curso";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $datas = $this->AssocMedias($datas);
            return $datas;
        }

        public function AssocMedias($datas){
            foreach ($datas as $key => $value) {
                $sql = "SELECT id_midia, tipo, path FROM midias WHERE id_projeto = ?";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([$value["id_projeto"]]);
                $medias = $stmt->fetchAll();
                for ($i=0; $i < count($medias); $i++) {
                    $datas[$key]["medias"][$i]["id_media"] .= $medias[$i]["id_midia"];
                    $datas[$key]["medias"][$i]["type"] .= $medias[$i]["tipo"];
                    $datas[$key]["medias"][$i]["path"] .= $medias[$i]["path"];
                }
            }
            return $datas;
        }

        public function Insert($id_area, $id_course, $desc_geral, $desc_detail, $date, $medias){
            $sql = "INSERT INTO projetos (id_area, id_curso, descricao_geral, descricao_detalhe, data) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([$id_area, $id_course, $desc_geral, $desc_detail, $date]);
            $id_projeto = $this->PDO->lastInsertId();
            if($stmt->rowCount()){
                for ($i=0; $i < count($medias["name"]); $i++) { 
                    $media = $this->UploadFile([
                        "name" => $medias["name"][$i],
                        "tmp_name" => $medias["tmp_name"][$i],
                    ]);
                    if($media == INVALID_EXTENSION){
                        return INVALID_EXTENSION;
                        exit;
                    }else{
                        $sql = "INSERT INTO midias (id_projeto, nome, tipo, path) VALUES (?, ?, ?, ?)";
                        $stmt = $this->PDO->prepare($sql);
                        $stmt->execute([$id_projeto, $media[0], $media[1], $media[0]]);
                    }
                }
                return PROJECT_CREATED;
            }else{
                return GENERAL_ERROR;
            }
        }
        public function DeleteMedia($id_media, $path){
            $sql = "DELETE FROM midias WHERE id_midia = ?";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([$id_media]);
            if($stmt->rowCount()){
                unlink(__DIR__ . "../../../$path");
                return MEDIA_DELETED;
            }else{
                return GENERAL_ERROR;
            }
        }
        public function View($id){
            $sql = "SELECT p.id_projeto, a.id_area, a.descricao AS area, c.curso, c.id_curso, descricao_geral,
            descricao_detalhe, data FROM projetos p
            INNER JOIN areas a ON p.id_area = a.id_area
            INNER JOIN cursos c ON p.id_curso = c.id_curso WHERE p.id_projeto = ?";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([$id]);
            $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $datas = $this->AssocMedias($datas);
            return $datas;
        }
    }