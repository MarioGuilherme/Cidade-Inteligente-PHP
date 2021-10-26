<?php

    require __DIR__ . "/../../vendor/autoload.php";
    use App\Controller\UserController;
    ((new UserController())->Register($_POST));