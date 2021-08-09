<?php

    session_start();
    $_SESSION["tipo"] != "Professor(a)" ? header("Location: main") : "";
    require  __DIR__ . "/vendor/autoload.php";
    use \App\Controller\ProjectController;
    echo (new ProjectController())->EditProject($_GET["id"]);