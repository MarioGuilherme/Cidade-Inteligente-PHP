<div class="limiter">
    <div class="container-login100" style="background-image: url('assets/img/cidade.jpg');">
        <div class="main">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 painel">
                        <h1 class="text-center">
                            <i class="mdi mdi-city-variant-outline icon"></i>
                        </h1>
                        <h1 class="text-center titulo-projeto">
                            Cidade Inteligente
                        </h1>
                        <form id="formulario" class="form">
                            <label class="text-dark">
                                Olá <?= $data["name"] ?>, digite sua nova senha:
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
                        <button type="button" class="btn mb-2 btn-block btn-change">
                            Alterar Senha
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>