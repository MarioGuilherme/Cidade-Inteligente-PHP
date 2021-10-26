<?php

    require  __DIR__ . "/vendor/autoload.php";
    use App\Controller\ProjectController;
    (new ProjectController())->ViewProject($_GET["id"]);