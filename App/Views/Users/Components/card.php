<div class="col-12 col-sm-12 col-md-4 col-lg-4">
    <div class="card card-projeto">
        <img class="card-img-top" src="medias/<?= $project["media"]["path"] ?>">
        <div class="card-body">
            <h5 class="card-title">
                <?= $project["title"] ?>
            </h5>
            <p class="card-text">
                <?= $project["description"] ?>
            </p>
        </div>
        <?php if(\App\Utils\Session::IsAdmin()): ?>
            <a href="ver-projeto?id=<?= $project["id_project"] ?>" class="btn btn-block mt-2 btn-view-project">
            Ver Projeto
            </a>
            <a href="editar-projeto?id=<?= $project["id_project"] ?>" class="btn mt-2 btn-edit-project">
                Editar
            </a>
            <button id="<?= $project["id_project"] ?>" class="btn  mt-2 btn-delete-project">
                Excluir
            </button>
        <?php endif; ?>
    </div>
</div>