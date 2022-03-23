<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\MediaController;

    (new MediaController)->Update($_POST["id_media"], $_FILES["media"]);