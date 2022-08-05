<?php

    require __DIR__ . "/App/Config/App.php";

    use App\Controllers\UserController;

    (new UserController)->myProjects(!array_key_exists("page", $_GET) ? 1 : (int) $_GET["page"]);