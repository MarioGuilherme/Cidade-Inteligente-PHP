<?php

    require __DIR__ . "/../../vendor/autoload.php";
    use App\Controller\UserController;
    ((new UserController())->Login($_POST));