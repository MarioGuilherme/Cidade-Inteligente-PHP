<?php

    declare(strict_types=1);

    /**
     * Laço de repetição para carregar as variaveis de ambiente
     */
    $lines = file(__DIR__ . "/.env");
    foreach($lines as $line) {
        putenv(trim($line));
    }