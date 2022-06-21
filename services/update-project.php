<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\ProjectController;

    (new ProjectController)->Update($_POST, $_FILES ? $_FILES["medias"] : null);