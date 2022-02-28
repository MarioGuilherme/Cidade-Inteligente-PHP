<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\AreaController;

    (new AreaController())->Delete($_POST["id_area"]);