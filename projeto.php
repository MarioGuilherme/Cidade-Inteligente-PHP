<?php

    session_start();
    require  __DIR__ . "/vendor/autoload.php";
    use \App\Controller\ProjectController;
    echo (new ProjectController)->View($_GET["id"]);