<div class="fundo-form-register">
    <div class="container-fluid" id="container-register">
        <?php
            require __DIR__ . "/../Page/Components/_Navbar.php";
            require __DIR__ . "/../Page/Components/_Jumbotron.php";
        ?>

        <div class="container justify-content-center">
            <div class="conteudo">
                <form class="form">
                    <div class="row">
                        <div class="col-12 col-md-12 title_criar mt-2">
                            <h3>
                                Criar Usuário/Professor
                            </h3>
                            <hr class="hr-user">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <div class="inputIcon">
                                <input type="text" maxlength="60" name="name" class="form-inputUser" aria-describedby="emailHelp" placeholder="Digite o nome">
                                <i class="mdi mdi-account"></i>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="inputIcon">
                                <input type="email" maxlength="60" name="email" class="form-inputUser" aria-describedby="emailHelp" placeholder="Digite o email">
                                <i class="mdi mdi-email"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-md-6">
                            <div class="inputIcon">
                                <input type="password" maxlength="60" name="password" class="form-inputUser" aria-describedby="emailHelp" placeholder="Crie a senha">
                                <i class="mdi mdi-key"></i>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="inputIcon">
                                <input type="password" maxlength="60" class="form-inputUser" aria-describedby="emailHelp" placeholder="Confirme a senha">
                                <i class="mdi mdi-key-change"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    Tipo de Usuário
                                </label>
                                <select class="form-control" name="type">
                                    <option value="">
                                        SELECIONE O TIPO DE USUÁRIO
                                    </option>
                                    <option value="Professor(a)">
                                        Professor(a)
                                    </option>
                                    <option value="Aluno(a)">
                                        Aluno(a)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    Curso do usuário
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
                </form>
                <div class="col-12 col-md-12">
                    <button class="btn btn-new-user btn-block" type="button">
                        Cadastrar
                    </button>
                </div>
            </div>
        </div>
        <?php
                require __DIR__ . "/../Page/Components/_Footer.php";
            ?>
    </div>
</div>