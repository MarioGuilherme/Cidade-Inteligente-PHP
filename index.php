<?
    session_start();
    if(!empty($_SESSION)){
        header("Location: menu");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="componentes/css/bootstrap.css">
    <link rel="stylesheet" href="componentes/css/estilo.css">
    <link rel="stylesheet" href="componentes/libs/MaterialDesign/css/materialdesignicons.css">
    <link rel="stylesheet" href="componentes/libs/sweetalert2/dist/sweetalert2.css">
    <title>Projeto Fatec</title>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('img/cidade.jpg');">
            <div class="main">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-md-6 painel">
                            <h1 class="text-center">
                                <i class="mdi mdi-city-variant-outline icon "></i>
                            </h1>
                            <h1 class="text-center titulo-projeto">
                                Projeto Cidade Inteligente
                            </h1>

                            <form id="formulario" class="form">

                                <div class="inputIcon">
                                    <input type="email" class="form-input" aria-describedby="emailHelp" placeholder="Digite o email">
                                    <i class="mdi mdi-email-check"></i>
                                </div>

                                <div class="inputIcon mt-3">
                                    <input type="password" class="form-input" placeholder="Digite a sua senha">
                                    <i class="mdi mdi-key"></i>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-6">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" class="form-check-input" id="checkbox">
                                            <label class="form-check-label" for="checkbox">
                                            Lembrar de mim?
                                        </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 mt-2 text-right">
                                        <p class="esqueceu">Esqueceu a senha?</p>
                                    </div>
                                </div>

                                <button type="submit" class="btn mt-2 btn-block btn-entrar">
                                Entrar
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="componentes/js/jquery-3.6.0.min.js"></script>
    <script src="componentes/js/bootstrap.js"></script>
    <script src="componentes/libs/sweetalert2/dist/sweetalert2.js"></script>
    <script src="src/usuario/controller/login.js"></script>
    <script src="ws.js"></script>
</body>

</html>