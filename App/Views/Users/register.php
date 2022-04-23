<?php
            require __DIR__ . "/../Page/Components/_Navbar.php";
        ?>    
<div class="container-fluid">
        <div class="row">
            <div class=" title_criar">
                <h3>
                Criar Usuário/Professor
                </h3>
            </div>
        </div>
        <div class="conteudo">
            <form class="form">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 input-form-title">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" maxlength="60" name="name" class="form-control" aria-describedby="emailHelp" placeholder="Digite o nome">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>
                                Email
                            </label>
                            <input type="email" maxlength="60" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Digite o email">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 input-form-title">
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" maxlength="60" name="password" class="form-control" aria-describedby="emailHelp" placeholder="Crie a senha">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label>
                                Confirmar Senha:
                            </label>
                            <input type="password" maxlength="60" class="form-control" aria-describedby="emailHelp" placeholder="Confirme a senha">
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