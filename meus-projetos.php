<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Meu Projetos
    </title>
    <link rel="icon" type="imagem/png" href="assets/img/logo3.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/<?= $data["css"] ?>.css">
</head>
   
<body>
<nav class="navbar navbar-expand-lg navCity">
    <h4 class="navbar-brand">
        <i class="mdi mdi-city-variant-outline"></i> Cidade Inteligente
    </h4>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
           <p>colocar nav</p>
        </ul>
    </div>
</nav>
        
<div class="container-fluid">
        <h3>
            Meus Projetos
        </h3>
        <hr>
        <div class="row">
             <div class="col-12 col-md-4"> 
                 <div class="card card-projeto">
                     <img class="card-img-top" src="assets\img\fatec1.jpg" alt="">
                     <div class="card-body">
                         <h5 class="card-title">Automatização residencial</h5>
                         <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam beatae tempore modi ipsa provident tempora blanditiis quas iure placeat quidem!</p>
                     </div>
                     <button class="btn btn-warning">Editar</button>
                     <button class="btn btn-danger mt-2">Excluir</button>
                 </div>
             </div>
             <div class="col-12 col-md-4"> <div class="card card-projeto">
                     <img class="card-img-top" src="assets\img\fatec1.jpg" alt="">
                     <div class="card-body">
                         <h5 class="card-title">Automatização residencial</h5>
                         <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam beatae tempore modi ipsa provident tempora blanditiis quas iure placeat quidem!</p>
                     </div>
                     <button class="btn btn-warning">Editar</button>
                     <button class="btn btn-danger mt-2">Excluir</button>
                 </div></div>
             <div class="col-12 col-md-4 "> <div class="card card-projeto">
                     <img class="card-img-top" src="assets\img\fatec1.jpg" alt="">
                     <div class="card-body">
                         <h5 class="card-title">Automatização residencial</h5>
                         <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam beatae tempore modi ipsa provident tempora blanditiis quas iure placeat quidem!</p>
                     </div>
                     <button class="btn btn-warning">Editar</button>
                     <button class="btn btn-danger mt-2">Excluir</button>
                 </div></div>
        </div>
    </div>

    <div class="rodape mt-2">
    <div class="row text-center">
        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
            <h5>
                Contato
            </h5>
            <p>
                fateclins@fatec.com
            </p>
            <p>
                gisele@fatec.com
            </p>
            <p></p>
        </div>
        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
            <h5>
                Desenvolvedores
            </h5>
            <p>
                Mário Guilherme de Andrade Rodrigues
            </p>
            <p>
                Vitor Luís Martins de Oliveira
            </p>
        </div>
        <div class="col-12 col-sm-12 col-lg-4 col-md-4">
            <h5>
                Redes Sociais
            </h5>
            <p>
                <a target="_blank" href="http://www.fateclins.edu.br/v4.0/">
                    Site Fatec Lins
                </a>
            </p>
            <p>
                <a target="_blank" href="https://www.instagram.com/fateclins/">
                    Instagram
                </a>
            </p>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-12 col-sm-12 col-lg-12 col-md-12">
            <small>
                &copy; Copyright 2022 - DIREITOS RESERVADOS FATEC LINS
            </small>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/<?= $data["js"] ?>.js"></script>
</body>

</html>