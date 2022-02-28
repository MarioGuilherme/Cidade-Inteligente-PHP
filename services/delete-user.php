<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\UserController;

    (new UserController())->Delete($_POST["id_user"]);