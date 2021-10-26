<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/MaterialDesign/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/fonts/font.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/<?= $css ?>.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navCity">
        <h4 class="navbar-brand">
            <i class="mdi mdi-city-variant-outline"></i> Cidade Inteligente
        </h4>
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?= $buttons ?>
                <li class="nav-item active">
                    <a class="nav-link" href="services/users/logout">
                        Sair
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron rounded-0">
        <h1 class="display-4">
            Cidade Inteligente
        </h1>
        <hr class="my-4 bg-light">
        <p>
            Fatec Lins - Prof. Antônio Seabra
        </p>
    </div>

    <main>
        <div class="container-fluid mt-4">