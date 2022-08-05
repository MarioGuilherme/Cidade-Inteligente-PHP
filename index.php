<?php

    require __DIR__ . "/App/Config/App.php";

    use App\Controllers\ProjectController;

    (new ProjectController)->index(!array_key_exists("page", $_GET) ? 1 : (int) $_GET["page"]);