    <div class="conteudo-projeto">
        <div class="nav-fundo">
            <?php
                require __DIR__ . "/../Page/Components/_Navbar.php";
            ?>

                    <h3 class="titulo-principal">
                        Projeto Cidade Inteligente
                    </h3>
        </div>
            <div class="sub-titulo">
                <p class="text-center">
                            O projeto Cidade Inteligente consiste na representação em minuatura funcional, de um circuito de ambientes dividos em URBANO, RURAL e INDUSTRIAL.
                </p>
            </div>

            <div class="galeria mt-5">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h3 class="title-galeria mt-3 mb-3">
                            Galeria de <b class="galeria-projetos">Projetos</b>
                        </h3>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <?php
                        if(empty($data["projects"])) {
                            echo "<h3 class='text-center'>Nenhum projeto cadastrado</h3>";
                        } else {
                            foreach ($data["projects"] as $project) {
                                (String) $status = "active";
                                (String) $lis = "";
                                (String) $divs = "";

                                foreach ($project["medias"] as $media) {
                                    $lis .= "<li data-target='#carousel-$project[id_project]' data-slide-to='$project[id_project]' class='$status'></li>";

                                    if($media["type"] == "video/mp4")
                                        (String) $tagMedia = "<video class='d-block' style='width:inherit;' preload='metadata' controls src='medias/$media[path]'></video>";
                                    else
                                        (String) $tagMedia = "<img class='d-block w-100' src='medias/$media[path]'>";

                                    $divs .= "<div class='carousel-item $status'>
                                                  $tagMedia
                                              </div>";
                                    $status = "";
                                }
                                require "Components/card.php";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
           <?php
                require __DIR__ . "/../Page/Components/_Footer.php";
            ?>
    </div>
