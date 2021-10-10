<?php

    require __DIR__ . "/../../vendor/autoload.php";
    use App\Controller\ProjectController;
    echo json_encode((new ProjectController())->Create($_POST, $_FILES["medias"]));