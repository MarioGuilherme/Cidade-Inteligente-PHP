<div class="limiter">
    <div class="container-login100">
        <div class="main">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5 painel">
                        <div class="img-logo-cidade">
                            <img src="assets/img/iconAuth.png">
                        </div>
                        <h3 class="text-center title mb-3">
                            Alteração de Senha
                        </h3>
                        <form id="formulario" class="form">
                            <input type="hidden" name="token" value="<?= $page->data["token"] ?>">
                            <label class="text-dark">
                                Olá <b><?= $page->data["name"] ?></b>, digite sua nova senha:
                            </label>
                            <div class="inputIcon">
                                <input type="password" name="password" class="form-input" placeholder="Digite a sua nova senha">
                                <i class="mdi mdi-key"></i>
                            </div>
                            <div class="inputIcon">
                                <input type="password" name="password" class="form-input" placeholder="Confirme a sua nova senha">
                                <i class="mdi mdi-key"></i>
                            </div>
                        </form>
                        <button type="button" class="btn mb-2 btn-strong-red btn-block btn-changePassword">
                            Alterar Senha
                        </button>
                        <div class="text-center font-weight-bold mt-3">
                            &copy;<?= date("Y") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>