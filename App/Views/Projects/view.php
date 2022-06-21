<div class="parallax">
    <?php require __DIR__ . "/../Components/_Navbar.php"; ?>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h4 class="font-weight-bold text-center title-projeto">
                    <?= $data["project"]["title"] ?>
                </h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <h5 class="font-weight-bold text-center title-projeto">
                    Pessoas envolvidas
                </h5>
                <div class="row justify-content-center align-items-center text-center m-1 p-1">
                    <?php foreach ($data["project"]["users"] as $user) : ?>
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                            <p>
                                <?= $user["name"] ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row mt-5 text-center">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold title-projeto">
                    Área
                </h5>
                <p>
                    <?= $data["project"]["area"] ?>
                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="font-weight-bold title-projeto">
                    Curso
                </h5>
                <p>
                    <?= $data["project"]["course"] ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h5 class="font-weight-bold text-center title-projeto">
                    Descrição
                </h5>
                <p class="text-center">
                    <?= $data["project"]["description"] ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center align-items-center m-1 p-1">
            <?php foreach ($data["project"]["medias"] as $media): ?>
                <div class="col-12 col-sm-12 col-lg-3 col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if ($media["type"] == "video/mp4"): ?>
                                <video class="d-block" style="width:-webkit-fill-available;" preload="metadata" controls src="medias/<?= $media["path"] ?>"></video>
                            <?php else : ?>
                                <img class="d-block w-100" alt="<?= $media["name"] ?>" src="medias/<?= $media["path"] ?>">
                            <?php endif; ?>
                            <div class="form-group mt-2">
                                <h4>
                                    <?= $media["name"] ?>
                                </h4>
                            </div>
                            <div class="form-group">
                                <?= $media["description"] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require __DIR__ . "/../Components/_Footer.php"; ?>
</div>