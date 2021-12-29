<?php

    require __DIR__ . "/../../vendor/autoload.php";

    use App\Controllers\ProjectController;

    (new ProjectController())->NewProject($_POST, $_FILES["medias"]);