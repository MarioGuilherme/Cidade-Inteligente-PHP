<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Core\Services;

    (new Services("Course"))->run();