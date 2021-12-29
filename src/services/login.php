<?php

    require __DIR__ . "/../../vendor/autoload.php";

    use App\Controllers\UserController;

    (new UserController())->Login($_POST);