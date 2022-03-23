<div class="fundo-form">
    <div class="container-fluid">
        <?php
            require __DIR__ . "/../Page/Components/_Navbar.php";
            require __DIR__ . "/../Page/Components/_Jumbotron.php";
        ?>
        <div class="container-fluid">
            <div class="conteudo">
                <form class="form">
                    <div class="row">
                        <div class="col-12 col-md-12 title_criar">
                            <h3>
                                Criar projeto
                            </h3>
                            <hr>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-12 col-md-6 input-form-title">
                            <div class="inputIcon">
                                <input type="text" maxlength="60" name="title" class="form-inputUser" aria-describedby="emailHelp" placeholder="Digite o titulo">
                                <i class="mdi mdi-clipboard-edit-outline"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    Data
                                </label>
                                <input class="form-control" type="date" name="date">
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
                                    <?php foreach ($data["users"] as $user): ?>
                                        <div class="user" id="<?= $user["id_user"] ?>">
                                            <span> <?= substr($user["name"], 0, 58) ?> </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="my-textarea">
                                    Descrição
                                </label>
                                <textarea class="form-control" name="description" maxlength="300" rows="5"></textarea>
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
                                <button type="button" class="btn btn-primary btn-add-media">
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
        <?php
                require __DIR__ . "/../Page/Components/_Footer.php";
            ?>
    </div>
</div>