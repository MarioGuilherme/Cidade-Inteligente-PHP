<?php

    require __DIR__ . "../../../vendor/autoload.php";
    use App\Controller\UserController;
    session_start();

    echo json_encode((new UserController())->Login($_POST["email"], $_POST["password"], $_POST["remember"]));