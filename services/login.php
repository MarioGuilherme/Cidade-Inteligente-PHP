<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Core\Services;
    use App\Controllers\UserController;

    (array) $payload = Services::getPayload();
    (new UserController)->login($payload);