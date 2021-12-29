<?php

    require  __DIR__ . "/vendor/autoload.php";

    use App\Controllers\UserController;

    (new UserController())->FormRegister();