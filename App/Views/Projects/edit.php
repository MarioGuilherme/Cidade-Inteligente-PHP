<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid d-flex justify-content-center align-items-center flex-column p-0">
        <div class="formTitle">
            <h3 class="m-0 p-2 text-center">
                Editar Projeto
            </h3>
        </div>
        <div class="formContent">
            <form class="form">
                <input type="hidden" name="id_project" value="<?= $page->data["project"]->id_project ?>">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12 input-form-title">
                        <div class="form-group">
                            <label>
                                Título
                            </label>
                            <input value="<?= $page->data["project"]->title ?>" type="text" maxlength="120" name="title" class="form-control" placeholder="Digite o titulo">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-lg-8 col-md-8 d-flex justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>
                                        Área do projeto
                                    </label>
                                    <select class="form-control" name="id_area">
                                        <?php foreach ($page->data["areas"] as $area): ?>
                                            <option value="<?= $area->id_area ?>">
                                                <?= $area->area ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="my-select">
                                        Curso do projeto
                                    </label>
                                    <select id="my-select" class="form-control" name="id_course">
                                        <?php foreach ($page->data["courses"] as $course): ?>
                                            <option value="<?= $course->id_course ?>">
                                                <?= $course->course ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>
                                        Data de ínicio do projeto
                                    </label>
                                    <input class="form-control" value="<?= $page->data["project"]->startDate ?>" type="date" name="startDate">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>
                                        Data de término do projeto
                                    </label>
                                    <input class="form-control" value="<?= $page->data["project"]->endDate ?>" type="date" name="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="my-select">
                                Pessoas Envolvidas
                            </label>
                            <div class="users">
                                <?php foreach ($page->data["allUsers"] as $user): ?>
                                    <?php if ($user->involved == true): ?>
                                        <div class="user" id="<?= $user->id_user ?>" involved="true">
                                            <span> <?= substr($user->name, 0, 58) ?> </span>
                                        </div>
                                    <?php else: ?>
                                        <div class="user" id="<?= $user->id_user ?>">
                                            <span> <?= substr($user->name, 0, 58) ?> </span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="my-textarea">
                                Descrição
                            </label>
                            <textarea class="form-control" name="description" maxlength="800" rows="5"><?= $page->data["project"]->description ?></textarea>
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
                            <input type="file" name="media[]" class="d-none input-new-medias" multiple accept=".jpg,.jpeg,.png,.mp4">
                            <input type="file" class="d-none input-change-media" accept=".jpg,.jpeg,.png,.mp4">
                        </div>
                    </div>
                </div>
                <div class="medias row align-items-center">
                    <?php foreach ($page->data["project"]->medias as $media): ?>
                        <div class="col-12 col-sm-12 col-lg-3 col-md-3 my-3">
                            <div class="card media" id="<?= $media->id_media ?>">
                                <div class="card-body">
                                    <?php if($media->type == "video/mp4") : ?>
                                        <video class="d-block" style="width:100%;" preload="metadata" controls src="medias/<?= $media->fileName ?>" size="<?= $media->size ?>"></video>
                                    <?php else : ?>
                                        <img class="d-block w-100" src="medias/<?= $media->fileName ?>" size="<?= $media->size ?>">
                                    <?php endif; ?>
                                    <div class="row mt-2 mb-1">
                                        <div class="col-12 col-lg-6 pr-1">
                                            <button type="button" class="btn btn-change-media w-100 btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                                Alterar
                                            </button>
                                        </div>
                                        <div class="col-12 col-lg-6 pl-1">
                                            <button type="button" class="btn w-100 btn-remove-media btn-default-red" id="<?= $media->id_media ?>">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                                Apagar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Nome
                                        </label>
                                        <input maxlength="60" class="form-control" type="text" value="<?= $media->name ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Descrição
                                        </label>
                                        <textarea maxlength="200" class="form-control" rows="3"><?= $media->description ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12">
                        <button class="btn btn-strong-red btn-save btn-block" type="button">
                            Salvar alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../Shared/_Footer.php" ?>

<script>
    document.querySelectorAll("select")[0].value = "<?= $page->data["project"]->id_area ?>";
    document.querySelectorAll("select")[1].value = "<?= $page->data["project"]->id_course ?>";
</script>