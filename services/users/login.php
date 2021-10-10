<?php

    require __DIR__ . "/../../vendor/autoload.php";
    use App\Controller\UserController;
    echo json_encode((new UserController())->Login($_POST));