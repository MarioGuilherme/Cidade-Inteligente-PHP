<div class="col-12 col-sm-12 col-lg-3 col-md-3">
    <div class="card">
        <div id="carousel-<?= $project["id_project"] ?>" data-interval="0" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?= $lis ?>
            </ol>
            <div class="carousel-inner" style="height: 400px;">
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
            <h4 class="card-title font-weight-bold">
                <?= $project["title"] ?>
            </h4>
            <p class="card-text">
                <?= $project["description"] ?>
            </p>
            <a href="ver-projeto?id=<?= $project["id_project"] ?>" class="btn btn-card btn-block">
                Ver Mais Sobre
            </a>
        </div>
    </div>
</div>