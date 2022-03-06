<div class="parallax">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <form>
            <input type="hidden" name="id_project" value="<?= $data["project"]["id_project"] ?>">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="text-dark">
                            Título
                        </label>
                        <input maxlenght="60" class="form-control" type="text" value="<?= $data["project"]["title"] ?>" name="title">
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>
                            Data
                        </label>
                        <input class="form-control" type="date" value="<?= $data["project"]["date"] ?>" name="date">
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="my-textarea">
                            Descrição
                        </label>
                        <textarea class="form-control" name="description" maxlength="300" rows="5"><?= $data["project"]["description"] ?></textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="my-select">
                            Pessoas Envolvidas
                        </label>
                        <select id="my-select" class="form-control" name="users[]" multiple>
                        <?php foreach($data["project"]["users"] as $user) : ?>
                            <option value="<?= $user["id_user"] ?>">
                                <?= $user["name"] ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <h6 class="text-dark text-center">
                            Segure Ctrl enquanto seleciona as pessoas
                        </h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>
                            Área do projeto
                        </label>
                        <select class="form-control" name="area">
                            <option value="">
                                SELECIONE A ÁREA
                            </option>
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
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="my-select">
                            Curso do projeto
                        </label>
                        <select id="my-select" class="form-control" name="course">
                            <option value="">
                                SELECIONE O CURSO
                            </option>
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
            </div>
            <h3 class="display-4">
                Mídias
            </h3>
            <div class="row bg-info justify-content-center align-items-center m-1 p-1">
                <div class="col-12 col-sm-12 col-lg-12 col-md-12">
                    <h3>
                        Mídias cadastradas
                    </h3>
                </div>
                <?php foreach($data["project"]["medias"] as $media): ?>
                    <div class="col-12 col-sm-12 col-lg-3 col-md-3">
                        <div class="card">
                            <div style="left: 0;" class="position-absolute">
                                <button type="button" class="btn btn-warning btn-change-media" id="<?= $media["id_media"] ?>">
                                    <i class="mdi mdi-sync"></i>
                                    Trocar mídia
                                </button>
                            </div>
                            <div style="right: 0;" class="position-absolute">
                                <button type="button" class="btn btn-danger btn-delete-media" id="<?= $media["id_media"] ?>">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    Apagar
                                </button>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="id_media[]" value="<?= $media["id_media"] ?>">
                                <?php if($media["type"] == "video/mp4") : ?>
                                    <video class="d-block" style="width:-webkit-fill-available;" preload="metadata" controls src="medias/<?= $media["path"] ?>"></video>
                                <?php else : ?>
                                    <img class="d-block w-100" alt="<?= $media["name"] ?>" src="medias/<?= $media["path"] ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="text-dark">
                                        Nome
                                    </label>
                                    <input maxlength="60" class="form-control" type="text" name="name_media[]" value="<?= $media["name"] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark">
                                        Descrição
                                    </label>
                                    <textarea maxlength="300" class="form-control" name="description_media[]"  rows="3"><?= $media["description"] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-primary btn-add-medias">
                        <i class="mdi mdi-plus"></i>
                        Adicionar mídias
                    </button>
                </div>
                <div class="col-12 col-sm-12 col-lg-12 col-md-12">
                    <input class="d-none form-control-file input-medias" multiple="multiple" type="file" name="medias[]">
                    <input class="d-none form-control-file input-media" type="file" name="media">
                    <h3>
                        Mídias a serem adicionadas
                    </h3>
                </div>
                <div class="col-12 col-sm-12 col-lg-12 col-md-12">
                    <div class="row medias-uploaded"></div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-12">
                    <button type="button" class="btn btn-update-project btn-block btn-success">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll("select")[1].value = "<?= $data["project"]["id_area"] ?>";
    document.querySelectorAll("select")[2].value = "<?= $data["project"]["id_course"] ?>";
</script>