<?php

    require __DIR__ . "/App/Config/App.php";

    use App\Controllers\ProjectController;

    (new ProjectController)->viewProject($_GET["id"]);