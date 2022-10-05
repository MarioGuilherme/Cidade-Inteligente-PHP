<?php

    $json = json_decode(file_get_contents(__DIR__ . "/options.json"));

    define("DATABASE", $json->DATABASE);
    define("EMAIL", $json->EMAIL);
    define("ENVIRONMENT", $json->ENVIRONMENT);

    unset($json);