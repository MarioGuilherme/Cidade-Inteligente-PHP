<?php

    require __DIR__ . "../../../vendor/autoload.php";
    use App\Controller\UserController;
    session_start();

    ((new UserController())->Logout());