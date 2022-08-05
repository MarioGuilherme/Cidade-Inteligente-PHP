<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Core\Services;
    use App\Controllers\UserController;

    $payload = Services::getPayload();
    (new UserController)->sendEmailRecover($payload["email"]);