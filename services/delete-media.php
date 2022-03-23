<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\MediaController;

    (new MediaController)->Delete($_POST["id_media"]);