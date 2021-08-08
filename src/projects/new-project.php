<?php

    require __DIR__ . "../../../vendor/autoload.php";
    use App\Controller\ProjectController;
    session_start();

    echo json_encode((new ProjectController())
    ->NewProject($_POST["area"], $_POST["course"], $_POST["desc_geral"], $_POST["desc_detail"], $_POST["date"], $_FILES["medias"]));