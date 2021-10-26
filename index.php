<?php
    session_start();
    !empty($_SESSION) ? header("Location: projetos") : "";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Login
    </title>
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/MaterialDesign/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/fonts/font.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('assets/img/cidade.jpg');">
            <div class="main">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-6 painel">
                            <h1 class="text-center">
                                <i class="mdi mdi-city-variant-outline icon "></i>
                            </h1>
                            <h1 class="text-center titulo-projeto">
                                Cidade Inteligente
                            </h1>
                            <form id="formulario" class="form">
                                <div class="inputIcon">
                                    <input type="email" name="email" class="form-input" aria-describedby="emailHelp" placeholder="Digite o email">
                                    <i class="mdi mdi-email-check"></i>
                                </div>
                                <div class="inputIcon mt-3">
                                    <input type="password" name="password" class="form-input" placeholder="Digite a sua senha">
                                    <i class="mdi mdi-key"></i>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-6">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" maxlength="55" name="remember" class="form-check-input" id="checkbox">
                                            <label class="form-check-label" for="checkbox">
                                                Lembrar de mim?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 mt-2 text-right">
                                        <p class="esqueceu">
                                            Esqueceu a senha?
                                        </p>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn mb-2 btn-block btn-login">
                                Entrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jQuery/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/access.js"></script>
</body>

</html>