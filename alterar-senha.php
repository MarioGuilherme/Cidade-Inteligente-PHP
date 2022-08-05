<?php

    require __DIR__ . "/App/Config/App.php";

    use App\Controllers\UserController;

    !isset($_GET["token"]) ? header("Location: /") : (new UserController)->formChangePassword($_GET["token"]);;