<?php

    require __DIR__ . "../../../vendor/autoload.php";
    use App\Controller\UserController;
    session_start();

    echo json_encode((new UserController())->Register($_POST["course"], $_POST["name"], $_POST["email"], $_POST["password"], $_POST["type"], $_POST["level"]));