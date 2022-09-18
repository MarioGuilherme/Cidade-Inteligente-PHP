<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 pb-2">
                <button class="btn btn-default-red btn-block btn-generate-qrcode">
                    Gerar QRCODE do Projeto
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <hr>
                <h4 class="font-weight-bold text-center default-color mt-2">
                    <?= $page->data["project"]->title ?>
                </h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <h5 class="font-weight-bold text-center default-color">
                    Pessoas envolvidas
                </h5>
                <div class="row justify-content-center align-items-center text-center m-1 p-1">
                    <?php foreach ($page->data["project"]->users as $user) : ?>
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                            <p>
                                <?= $user->name ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row mt-5 text-center">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold default-color">
                    Área
                </h5>
                <p>
                    <?= $page->data["project"]->area ?>
                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold default-color">
                    Curso
                </h5>
                <p>
                    <?= $page->data["project"]->course ?>
                </p>
            </div>
        </div>
        <div class="row mt-5 text-center">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold default-color">
                    Data de ínicio do projeto
                </h5>
                <p>
                    <?= date("d/m/Y", strtotime($page->data["project"]->startDate)) ?>
                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold default-color">
                    Data de término do projeto
                </h5>
                <p>
                    <?= date("d/m/Y", strtotime($page->data["project"]->endDate)) ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h5 class="font-weight-bold text-center default-color">
                    Descrição
                </h5>
                <p class="text-justify">
                    <?= $page->data["project"]->description ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center align-items-center m-1 p-1">
            <?php foreach ($page->data["project"]->medias as $media): ?>
                <div class="col-12 col-sm-12 col-lg-3 col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if ($media->type == "video/mp4"): ?>
                                <video class="d-block" style="width:-webkit-fill-available;" preload="metadata" controls src="medias/<?= $media->fileName ?>"></video>
                            <?php else : ?>
                                <img class="d-block w-100 img-card" alt="<?= $media->name ?>" src="medias/<?= $media->fileName ?>">
                            <?php endif; ?>
                            <div class="form-group mt-2">
                                <h4>
                                    <?= $media->name ?>
                                </h4>
                            </div>
                            <div class="form-group">
                                <?= $media->description ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../Shared/_Footer.php" ?>