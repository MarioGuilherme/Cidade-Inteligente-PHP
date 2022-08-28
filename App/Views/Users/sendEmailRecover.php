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
                            Recuperação de Senha
                        </h3>
                        <form id="formulario" class="form">
                            <label class="text-dark">
                                Digite o Email de sua conta
                            </label>
                            <div class="inputIcon">
                                <input type="email" name="email" class="form-input" aria-describedby="emailHelp" placeholder="Digite o email">
                                <i class="mdi mdi-email-check"></i>
                            </div>
                        </form>
                        <button type="button" class="btn mb-2 btn-strong-red btn-block btn-recover">
                            Enviar Email de Recuperação
                        </button>
                        <a href="login" class="forget-password">
                            Voltar ao Login
                        </a>
                        <div class="text-center font-weight-bold mt-3">
                            &copy;<?= date("Y") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>