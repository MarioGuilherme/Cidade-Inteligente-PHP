<?php

    declare(strict_types=1);

    $lines = file(__DIR__ . "/.env");
    foreach($lines as $line) {
        putenv(trim($line));
    }