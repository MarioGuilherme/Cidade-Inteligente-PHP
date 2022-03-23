<div class="fundo-form">
    <div class="container-fluid">
        <?php
            require __DIR__ . "/../Page/Components/_Navbar.php";
            require __DIR__ . "/../Page/Components/_Jumbotron.php";
        ?>
        <div class="container-fluid">
            <div class="conteudo">
                <form class="form">
                    <input type="hidden" name="id_project" value="<?= $data["project"]["id_project"] ?>">
                    <div class="row">
                        <div class="col-12 col-md-12 title_criar">
                            <h3>
                                Editar projeto
                            </h3>
                            <hr>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 col-md-6 input-form-title">
                            <div class="inputIcon">
                                <input value="<?= $data["project"]["title"] ?>" type="text" maxlength="60" name="title" class="form-inputUser" aria-describedby="emailHelp" placeholder="Digite o titulo">
                                <i class="mdi mdi-clipboard-edit-outline"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    Data
                                </label>
                                <input class="form-control" type="date" value="<?= $data["project"]["date"] ?>" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12 col-md-12">
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
                                <div class="col-12 col-md-12">
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
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="my-select">
                                    Pessoas Envolvidas
                                </label>
                                <div class="users">
                                    <?php foreach ($data["project"]["users"] as $user): ?>
                                        <?php if ($user["involved"] == true): ?>
                                            <div class="user" id="<?= $user["id_user"] ?>" involved="true">
                                                <span> <?= substr($user["name"], 0, 58) ?> </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="user" id="<?= $user["id_user"] ?>">
                                                <span> <?= substr($user["name"], 0, 58) ?> </span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="my-textarea">
                                    Descrição
                                </label>
                                <textarea class="form-control" name="description" maxlength="300" rows="5"><?= $data["project"]["description"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex align-items-center justify-content-center flex-column text-center">
                            <div class="form-group">
                                <label>
                                    Mídias incluídas
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row medias-included align-items-center">
                        <?php foreach ($data["project"]["medias"] as $media): ?>
                            <div class="col-12 col-sm-12 col-lg-3 col-md-3 my-3">
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
                                        <?php if($media["type"] == "video/mp4") : ?>
                                            <video class="d-block" style="width:-webkit-fill-available;" preload="metadata" controls src="medias/<?= $media["path"] ?>"></video>
                                        <?php else : ?>
                                            <img class="d-block w-100" alt="<?= $media["name"] ?>" src="medias/<?= $media["path"] ?>">
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label class="text-dark">
                                                Nome
                                            </label>
                                            <input maxlength="60" class="form-control" type="text" name="name_media[<?= $media["id_media"] ?>]" value="<?= $media["name"] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark">
                                                Descrição
                                            </label>
                                            <textarea maxlength="300" class="form-control" name="description_media[<?= $media["id_media"] ?>]"  rows="3"><?= $media["description"] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-12 col-sm-12 col-lg-3 col-md-3 my-3 col-btn">
                            <button type="button" class="btn btn-primary btn-add-media btn-lg btn-block">
                                <i class="mdi mdi-plus"></i>
                                Adicionar mídia
                            </button>
                        </div>
                    </div>
                    <div class="inputs-medias"></div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-12">
                            <button class="btn btn-update-project btn-block" type="button">
                                Salvar alterações
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            require __DIR__ . "/../Page/Components/_Footer.php";
        ?>
    </div>
</div>
<script>
    document.querySelectorAll("select")[0].value = "<?= $data["project"]["id_area"] ?>";
    document.querySelectorAll("select")[1].value = "<?= $data["project"]["id_course"] ?>";
</script>