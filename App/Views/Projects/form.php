<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid d-flex justify-content-center align-items-center flex-column p-0">
        <div class="formTitle">
            <h3 class="m-0 p-2 text-center">
                Criar Projeto
            </h3>
        </div>
        <div class="formContent">
            <form class="form">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12 input-form-title">
                        <div class="form-group">
                            <label>
                                Título
                            </label>
                            <input type="text" maxlength="120" name="title" class="form-control" placeholder="Digite o titulo">
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
                                        <option value="">
                                            SELECIONE A ÁREA
                                        </option>
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
                                        <option value="">
                                            SELECIONE O CURSO
                                        </option>
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
                                    <input class="form-control" type="date" name="startDate">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>
                                        Data de término do projeto
                                    </label>
                                    <input class="form-control" type="date" name="endDate">
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
                                <?php foreach ($page->data["users"] as $user): ?>
                                    <div class="user" id="<?= $user->id_user ?>">
                                        <span> <?= substr($user->name, 0, 58) ?> </span>
                                    </div>
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
                            <textarea class="form-control" name="description" maxlength="800" rows="5"></textarea>
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
                <div class="medias row align-items-center"></div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12">
                        <button class="btn btn-block btn-new-project" type="button">
                            Criar Projeto
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../Shared/_Footer.php" ?>