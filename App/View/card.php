<?php 
    $li = "";
    $medias = "";
    for($i = 1; $i < count($key["medias"]); $i++){
        $li .= "<li data-target='#carousel-$key[id_project]' data-slide-to='$i'></li>";
        if($key["medias"][$i]["type"] == "video/mp4"){
            $medias .= "<div class='carousel-item'>
                            <video class='d-block' style='width:inherit;' preload='metadata' controls src='medias/".$key["medias"][$i]["path"]."'></video>
                        </div>";
        }else{
            $medias .= "<div class='carousel-item'>
                            <img class='d-block w-100' src='medias/".$key["medias"][$i]["path"]."'>
                        </div>";
        }
    }
?>
<div class="col-12 col-sm-12 col-lg-3 col-md-3">
    <div class="card">
        <div id="carousel-<?= $key["id_project"] ?>" data-interval="0" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-<?= $key["id_project"] ?>" data-slide-to="0" class="active"></li>
                <?= $li ?>
            </ol>
            <div class="carousel-inner" style="height: 400px;">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="medias/<?= $key["medias"][0]["path"] ?>">
                </div>
                <?= $medias ?>
            </div>
            <a class="carousel-control-prev" href="#carousel-<?= $key["id_project"] ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carousel-<?= $key["id_project"] ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>
        <div class="card-body">
            <h4 class="card-title font-weight-bold">
                <?= $key["title"] ?>
            </h4>
            <p class="card-text">
                <?= $key["description"] ?>
            </p>
            <a href="projeto?id=<?= $key["id_project"] ?>" class="btn btn-card btn-block">
                Ver Mais Sobre
            </a>
        </div>
    </div>
</div>