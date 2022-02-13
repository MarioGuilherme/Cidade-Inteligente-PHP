
<div class="fundo">
    <div class="conteudo-projeto">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
?>
        <div class="container-fluid">

            <div class="row mt-3 align-items-center justify-content-center">
                    <div class="col-12 col-md-12 lado-a">
                        <h3>Bem vindo ao Projeto Cidade Inteligente</h3>
                        <hr>
                        <h5 class="text-justify">O projeto Cidade Inteligente consiste na representação em minuatura funcional, de um circuito de ambientes dividos em URBANO, RURAL e INDUSTRIAL. </h5>
                    
                        <div class="row mt-3">
                            <div class="col-6 col-md-12">
                            <p>Instagram Cidade Inteligente</p>
                                <a class="btn btn-insta" href=""> @CidadeInteligente</a>
                            </div>
                        </div>
            </div>
        </div>

        <div class="galeria mt-5">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2 class="title-galeria">
                        Galeria de Projetos
                    </h2>
                    <hr class="my-4">
                </div>
            </div>
            <div class="row justify-content-center">
                <?php 
                    foreach($data["projects"] as $project) {
                        $status = "active";
                        $lis = "";
                        $divs = "";

                        foreach($project["medias"] as $media) {
                            $lis .= "<li data-target='#carousel-$project[id_project]' data-slide-to='$project[id_project]' class='$status'></li>";

                            if($media["type"] == "video/mp4")
                                $tagMedia = "<video class='d-block' style='width:inherit;' preload='metadata' controls src='src/medias/$media[path]'></video>";
                            else
                                $tagMedia = "<img class='d-block w-100' src='src/medias/$media[path]'>";

                            $divs .= "<div class='carousel-item $status'>
                                        $tagMedia
                                    </div>";
                            $status = "";
                        }

                        require "Components/card.php";
                    }
                ?>
            </div>
        </div>
<div class="rodape">
    <div class="row text-center">
                <div class="col-12 col-md-4">
                    <h5>Contato</h5>
                    <p>fateclins@fatec.com</p>
                    <p>gisele@fatec.com</p>
                    <p></p>
                </div>
                <div class="col-12 col-md-4">
                    <h5>Quem somos</h5>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Optio hic facilis rerum asperiores numquam omnis ea officiis quae voluptas ad magni porro placeat reiciendis modi libero vel ab, animi tenetur.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h5>Redes Sociais</h5>
                    <p>Facebook</p>
                    <p>Instagram</p>
                    <p>Twitter</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12 col-md-12">
                <p>© Copyright 2022 - DIREITOS RESERVADOS FATEC LINS</p>
                </div>
            </div>
    </div>
<<<<<<< HEAD
=======
    <div class="row justify-content-center">
        <?php 
            foreach($data["projects"] as $project) {
                $status = "active";
                $lis = "";
                $divs = "";

                foreach($project["medias"] as $media) {
                    $lis .= "<li data-target='#carousel-$project[id_project]' data-slide-to='$project[id_project]' class='$status'></li>";

                    if($media["type"] == "video/mp4")
                        $tagMedia = "<video class='d-block' style='width:inherit;' preload='metadata' controls src='medias/$media[path]'></video>";
                    else
                        $tagMedia = "<img class='d-block w-100' src='medias/$media[path]'>";

                    $divs .= "<div class='carousel-item $status'>
                                $tagMedia
                              </div>";
                    $status = "";
                }

                require "Components/card.php";
            }
        ?>
>>>>>>> 78d875e296fdf5f02f806a2f1dc5102438c17062
    </div>
</div>
