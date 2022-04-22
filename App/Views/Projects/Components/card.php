<div class="col-12 col-sm-12 col-lg-3 col-md-3 mb-2">
    <div class="card" style="width: 18rem;">
        <div id="carousel-<?= $project["id_project"] ?>" data-interval="0" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?= $lis ?>
            </ol>
            <div class="carousel-inner" style="height: 150px;">
                <?= $divs ?>
            </div>
            <a class="carousel-control-prev" href="#carousel-<?= $project["id_project"] ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Anterior
                </span>
            </a>
            <a class="carousel-control-next" href="#carousel-<?= $project["id_project"] ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Próximo
                </span>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">
                <?= $project["title"] ?>
            </h6>
            <p class="card-text">
                <?= $project["description"] ?>
            </p>
            <a href="ver-projeto?id=<?= $project["id_project"] ?>" class="btn btn-card btn-block">
                Ver Mais Sobre
            </a>
        </div>
    </div>
</div>