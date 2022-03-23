<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\CourseController;

    (new CourseController)->Update($_POST);