<?php
    require __DIR__ . "/../Shared/navbar.php";
    require __DIR__ . "/../Shared/jumbotron.php";
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Descrição Geral
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
        <?php foreach($data["project"]["users"] as $user) : ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
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
        <?php
            foreach($data["project"]["medias"] as $media) {
                switch ($media["type"]) {
                    case "video/mp4":
                        $tagMedia = "<video controls src='src/medias/$media[path]'></video>";
                    
                        break;

                    default:
                        $tagMedia = "<img src='src/medias/$media[path]' alt='$media[name]'>";
                        break;
                }
                echo "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>$tagMedia</div>";
            }
        ?>
    </div>
</div>