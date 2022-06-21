<?php require __DIR__ . "/../Components/_Navbar.php"; ?>    
<div class="container-fluid">
    <div class="row">
        <div class="title_criar">
            <h3>
            Criar Novo Projeto
            </h3>
        </div>
    </div>
    <div class="conteudo">
        <form class="form">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 input-form-title">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" maxlength="60" name="title" class="form-control" aria-describedby="emailHelp" placeholder="Digite o titulo">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>
                        Data
                        </label>
                        <input class="form-control" type="date" name="date">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 input-form-title">
                    <div class="form-group">
                        <label>
                            Área do projeto
                        </label>
                        <select class="form-control" name="area">
                            <option value="">
                                SELECIONE A ÁREA
                            </option>
                            <?php foreach ($data["areas"] as $area): ?>
                                <option value="<?= $area["id_area"] ?>">
                                    <?= $area["area"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="my-select">
                            Curso do projeto
                        </label>
                        <select id="my-select" class="form-control" name="course">
                            <option value="">
                                SELECIONE O CURSO
                            </option>
                            <?php foreach ($data["courses"] as $course): ?>
                                <option value="<?= $course["id_course"] ?>">
                                    <?= $course["course"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                    <label for="my-select">
                            Pessoas Envolvidas
                        </label>
                        <div class="users">
                            <?php foreach ($data["users"] as $user): ?>
                                <div class="user" id="<?= $user["id_user"] ?>">
                                    <span> <?= substr($user["name"], 0, 58) ?> </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                       <label for="my-textarea">
                            Descrição
                        </label>
                        <textarea class="form-control" name="description" maxlength="1000" rows="5"></textarea>
                   </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 d-flex align-items-center justify-content-center flex-column text-center">
                    <div class="form-group">
                        <label>
                            Mídias incluídas
                        </label>
                        <br>
                        <button type="button" class="btn btn-add-media">
                            <i class="mdi mdi-plus"></i>
                            Adicionar mídia
                        </button>
                    </div>
                </div>
            </div>
            <div class="inputs-medias"></div>
            <div class="row medias-uploaded align-items-center"></div>
            <div class="row mt-3">
                <div class="col-12 col-md-12">
                    <button class="btn btn-new-project btn-block" type="button">
                        Criar Projeto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . "/../Components/_Footer.php"; ?>