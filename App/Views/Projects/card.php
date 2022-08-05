<div class="col-12 col-sm-12 col-lg-3 col-md-3 mb-2">
    <div class="card">
        <div id="mediaIndicators-<?= $project["id_project"] ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#mediaIndicators-<?= $project["id_project"] ?>" data-slide-to="<?= $project["medias"][0]["id_media"] ?>" class="active"></li>
                <?php for ($i = 1; $i < count($project["medias"]); $i++) : ?>
                    <li data-target="#mediaIndicators-<?= $project["id_project"] ?>" data-slide-to="<?= $project["medias"][$i]["id_media"] ?>"></li>
                <?php endfor; ?>
            </ol>
            <div class="carousel-inner">
                <?php if ($project["medias"][0]["type"] == "video/mp4"): ?>
                    <div class="carousel-item active">
                        <video class="d-block" style="width:inherit;" preload="metadata" src="medias/<?= $project["medias"][0]["fileName"] ?>"></video>
                    </div>
                <?php else: ?>
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="medias/<?= $project["medias"][0]["fileName"] ?>">
                    </div>
                <?php endif; ?>
                <?php for ($i = 1; $i < count($project["medias"]); $i++) : ?>
                    <?php if ($project["medias"][$i]["type"] == "video/mp4"): ?>
                        <div class="carousel-item">
                            <video class="d-block" style="width:inherit;" preload="metadata" src="medias/<?= $project["medias"][$i]["fileName"] ?>"></video>
                        </div>
                    <?php else: ?>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="medias/<?= $project["medias"][$i]["fileName"] ?>">
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <a class="carousel-control-prev" href="#mediaIndicators-<?= $project["id_project"] ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Previous
                </span>
            </a>
            <a class="carousel-control-next" href="#mediaIndicators-<?= $project["id_project"] ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Next
                </span>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">
                <?= $project["title"] ?>
            </h6>
            <p class="card-text">
                <?= mb_strlen($project["description"]) <= 125 ? $project["description"] : substr($project["description"], 0, 125) .  " ..." ?> 
            </p>
            <a href="ver-projeto?id=<?= $project["id_project"] ?>" class="btn btn-default-red btn-block">
                Ver Mais Sobre
            </a>
        </div>
    </div>
</div>