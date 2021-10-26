<form>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Descrição Geral
            </h2>
            <p>
                <textarea class="form-control" name="general_desc" rows="3"><?= $data["title"] ?></textarea>
            </p>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Descrição Detalhada
            </h2>
            <p>
                <textarea class="form-control" name="detail_desc" rows="3"><?= $data["description"] ?></textarea>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Área
            </h2>
            <select class="form-control" name="area">
                <option value="1">
                    Industrial
                </option>
                <option value="2">
                    Rural
                </option>
                <option value="3">
                    Urbana
                </option>
            </select>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="font-weight-bold">
                Curso
            </h2>
            <select id="my-select" class="form-control" name="course">
                <option value="1">
                    Análise e Desenvolvimento de Sistemas
                </option>
                <option value="2">
                    Gestão Empresarial
                </option>
                <option value="3">
                    Gestão da Produção Indústrial
                </option>
                <option value="4">
                    Gestão da Qualidade
                </option>
                <option value="5">
                    Logística
                </option>
                <option value="6">
                    Sistema para Internet
                </option>
            </select>
        </div>
    </div>
</form>
<h3 class="display-4">
    Mídias
</h3>
<div class="row bg-info media justify-content-center align-items-center m-1 p-1">
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
<script>
    $("select[name=area]").val("<?= $data["id_area"] ?>")
    $("select[name=course]").val("<?= $data["id_course"] ?>")
</script>