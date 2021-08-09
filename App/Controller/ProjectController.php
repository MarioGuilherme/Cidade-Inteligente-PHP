<?php

    namespace App\Controller;
    use App\Model\Project;
    use App\Controller;

    class ProjectController{

        public function __construct(){
            $this->model = new Project;
        }

        public function List(){
            $page = new Page("Projetos", "projects");
            $data = $this->model->Select();
            $structure_card = file_get_contents(__DIR__ . "../../View/components/structure-card.html");
            if(!empty($data)){
                $cards = "";
                foreach($data as $key => $value){
                    $li = "";
                    $medias = "";
                    for($i = 1; $i < count($value["medias"]); $i++){
                        $li .= "<li data-target='#carousel-$value[id_projeto]' data-slide-to='$i'></li>";
                        if($value["medias"][$i]["type"] == "mp4"){
                            $medias .=
                            "<div class='carousel-item'>
                                <video class='d-block' style='width:inherit;' preload='metadata' controls src='src/medias/".$value["medias"][$i]["path"]."'></video>
                            </div>";
                        }else{
                            $medias .=
                            "<div class='carousel-item'>
                                <img class='d-block w-100' src='src/medias/".$value["medias"][$i]["path"]."'>
                            </div>";
                        }
                    }
                    $cards .= str_replace([
                        "{{ id }}",
                        "{{ li }}",
                        "{{ path }}",
                        "{{ img }}",
                        "{{ general_description }}",
                        "{{ detail_description }}",
                    ], [
                        $value["id_projeto"],
                        $li,
                        $value["medias"][0]["path"],
                        $medias,
                        $value["descricao_geral"],
                        $value["descricao_detalhe"]
                    ], $structure_card);
                }
            }else{
                $cards = NOTHING_FOUND;
            }
            return str_replace("{{ projects }}", $cards, $page->structure);
        }

        public function View($id_project){
            $page = new Page("Ver Projeto", "view-project");
            $datas = $this->model->View($id_project);
            for ($i = 0; $i < count($datas[0]["medias"]) - 1; $i++) {
                switch ($datas[0]["medias"][$i]["type"]) {
                    case "mp4":
                        $datas[0]["medias"]["rendered"] .=
                        "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                            <video controls src='src/medias/".$datas[0]["medias"][$i]["path"]."'></video>
                        </div>";
                        break;

                    default:
                        $datas[0]["medias"]["rendered"] .=
                        "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                            <img src='src/medias/".$datas[0]["medias"][$i]["path"]."' alt=''>
                        </div>";
                        break;
                }
            }
            return str_replace([
                "{{ general_description }}",
                "{{ detail_description }}",
                "{{ area }}",
                "{{ course }}",
                "{{ medias }}"
            ], [
                $datas[0]["descricao_geral"],
                $datas[0]["descricao_detalhe"],
                $datas[0]["area"],
                $datas[0]["curso"],
                $datas[0]["medias"]["rendered"]
            ], $page->structure);
        }

        public function NewProject($id_area, $id_course, $desc_geral, $desc_detail, $date, $medias){
            if($this->model->VerifyUser() === 1){
                if(empty($id_area) || empty($id_course) || empty($desc_geral) || empty($desc_detail) || empty($date) || empty($medias["name"][0])){
                    return EMPTY_FIELDS;
                }else{
                    if($this->model->VerifyFiles($medias) === 1){
                        $id_area = trim(substr(htmlspecialchars($id_area), 0, 999));
                        $id_course = trim(substr(htmlspecialchars($id_course), 0, 999));
                        $desc_geral = trim(substr(htmlspecialchars($desc_geral), 0, 300));
                        $desc_detail = trim(substr(htmlspecialchars($desc_detail), 0, 1000));
                        $date = trim(substr(htmlspecialchars($date), 0, 10));
                        return $this->model->Insert($id_area, $id_course, $desc_geral, $desc_detail, $date, $medias);
                    }else{
                        return $this->model->VerifyFiles($medias);
                    }
                }
            }else{
                return $this->model->VerifyUser();
            }
        }
        public function DeleteMedia($id_media, $path){
            if($this->model->VerifyUser() === 1){
                if(empty($id_media) || empty($path)){
                    return EMPTY_FIELDS;
                }else{
                    return $this->model->DeleteMedia($id_media, $path);
                }
            }else{
                return $this->model->VerifyUser();
            }
        }
        public function EditProject($id_project){
            if($this->model->VerifyUser() === 1){
                $page = new Page("Editar Projeto", "edit-project");
                $datas = $this->model->View($id_project);
                for ($i = 0; $i < count($datas[0]["medias"]) - 1; $i++) {
                    switch ($datas[0]["medias"][$i]["type"]) {
                        case "mp4":
                            $datas[0]["medias"]["rendered"] .=
                            "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                                <div>
                                    <button style='z-index: 999;' type='button' id='".$datas[0]["medias"][$i]["id_media"]."'class='btn btn-danger btn-delete-media position-absolute'>Apagar Vídeo</button>
                                </div>
                                <video controls src='src/medias/".$datas[0]["medias"][$i]["path"]."'></video>
                            </div>";
                            break;
                        
                        default:
                            $datas[0]["medias"]["rendered"] .=
                            "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                                <div>
                                    <button type='button' id='".$datas[0]["medias"][$i]["id_media"]."'class='btn btn-danger btn-delete-media position-absolute'>Apagar Foto</button>
                                </div>
                                <img src='src/medias/".$datas[0]["medias"][$i]["path"]."' alt=''>
                            </div>";
                            break;
                    }
                }
                return  str_replace([
                    "{{ general_description }}",
                    "{{ detail_description }}",
                    "{{ area }}",
                    "{{ course }}",
                    "{{ medias }}"
                ], [
                    $datas[0]["descricao_geral"],
                    $datas[0]["descricao_detalhe"],
                    $datas[0]["id_area"],
                    $datas[0]["id_curso"],
                    $datas[0]["medias"]["rendered"]
                ], $page->structure);
            }else{
                return $this->model->VerifyUser();
            }
        }
    }