<?php

    declare(strict_types=1);

    require __DIR__ . "/../Config/Config.php";
    use App\Database\Database;

    Database::Config(
        getenv("DRIVER"),
        getenv("HOST"),
        getenv("DATABASE"),
        getenv("USER"),
        getenv("PASSWORD"),
        getenv("CHARSET")
    );