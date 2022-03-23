<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\AreaController;

    (new AreaController)->ViewByID($_POST["id_area"]);