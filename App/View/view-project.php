<form>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Descrição Geral
            </h2>
            <p>
                <?= $data["title"] ?>
            </p>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Descrição Detalhada
            </h2>
            <p>
                <?= $data["description"] ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Área
            </h2>
            <p>
                <?= $data["area"] ?>
            </p>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Curso
            </h2>
            <p>
                <?= $data["course"] ?>
            </p>
        </div>
    </div>
</form>
<h3 class="display-4">
    Mídias
</h3>
<div class="row bg-info justify-content-center align-items-center m-1 p-1">
    <?php
        for ($i = 0; $i < count($data["medias"]); $i++) {
            switch ($data["medias"][$i]["type"]) {
                case "mp4":
                    echo "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                            <video controls src='services/paths/".$data["medias"][$i]["path"]."'></video>
                        </div>";
                    break;

                default:
                    echo "<div class='col-12 col-sm-12 col-md-2 col-lg-2 mt-1 mb-1'>
                            <img src='services/paths/".$data["medias"][$i]["path"]."' alt=''>
                        </div>";
                    break;
            }
        }
    ?>
</div>