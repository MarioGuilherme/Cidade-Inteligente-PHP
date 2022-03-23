<div class="parallax">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="font-weight-bold">
                    Título
                </h2>
                <p>
                    <?= $data["project"]["title"] ?>
                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="font-weight-bold">
                    Descrição
                </h2>
                <p>
                    <?= $data["project"]["description"] ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="font-weight-bold">
                    Área
                </h2>
                <p>
                    <?= $data["project"]["area"] ?>
                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="font-weight-bold">
                    Curso
                </h2>
                <p>
                    <?= $data["project"]["course"] ?>
                </p>
            </div>
        </div>
        <h3 class="display-4">
            Pessoas envolvidas
        </h3>
        <div class="row bg-info justify-content-center align-items-center m-1 p-1">
            <?php foreach ($data["project"]["users"] as $user) : ?>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <p>
                        <?= $user["name"] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <h3 class="display-4">
            Mídias
        </h3>
        <div class="row bg-info justify-content-center align-items-center m-1 p-1">
            <?php foreach ($data["project"]["medias"] as $media): ?>
                <div class="col-12 col-sm-12 col-lg-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <?php if($media["type"] == "video/mp4") : ?>
                                <video class="d-block" style="width:-webkit-fill-available;" preload="metadata" controls src="medias/<?= $media["path"] ?>"></video>
                            <?php else : ?>
                                <img class="d-block w-100" alt="<?= $media["name"] ?>" src="medias/<?= $media["path"] ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="text-dark">
                                    Nome
                                </label>
                                <input maxlength="60" class="form-control" type="text" value="<?= $media["name"] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label class="text-dark">
                                    Descrição
                                </label>
                                <textarea maxlength="300" class="form-control" rows="3" disabled><?= $media["description"] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>