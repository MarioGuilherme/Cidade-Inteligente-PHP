<?php
    require __DIR__ . "/../Shared/navbar.php";
    require __DIR__ . "/../Shared/jumbotron.php";
?>

<div class="galeria">
    <div class="row">
        <div class="col-12 col-md-12">
            <h2>
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

                require "card.php";
            }
        ?>
    </div>
</div>