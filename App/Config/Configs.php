<?php

    $json = json_decode(file_get_contents(__DIR__ . "/options.json"), true);

    define("ISDEV", $json["ISDEV"]);
    define("EMAIL", $json["EMAIL"]);

    if (ISDEV) {
        define("URL", $json["DEV"]["URL"]);
        define("DATABASE", $json["DEV"]["DATABASE"]);
    } else {
        define("URL", $json["PRODUCTION"]["URL"]);
        define("DATABASE", $json["PRODUCTION"]["DATABASE"]);
    }

    unset($json);