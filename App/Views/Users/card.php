<div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-3">
    <div class="card card-projeto">
        <?php if ($project->media->type == "video/mp4"): ?>
            <video class="d-block" style="width:inherit;" preload="metadata" src="medias/<?= $project->media->fileName ?>"></video>
        <?php else: ?>
            <img class="card-img-top" src="medias/<?= $project->media->fileName ?>">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title">
                <?= $project->title ?>
            </h5>
            <p class="card-text">
                <?= mb_strlen($project->description) <= 125 ? $project->description : substr($project->description, 0, 125) .  " ..." ?>
            </p>
        </div>
        <a href="ver-projeto?id=<?= $project->id_project ?>" class="btn btn-block mt-2 btn-view-project">
            Ver Projeto
        </a>
        <?php if (\App\Utils\Session::isAdmin()): ?>
            <a href="editar-projeto?id=<?= $project->id_project ?>" class="btn mt-2 btn-edit-project">
                Editar
            </a>
            <button id="<?= $project->id_project ?>" class="btn mt-2 btn-delete-project">
                Excluir
            </button>
        <?php endif; ?>
    </div>
</div>