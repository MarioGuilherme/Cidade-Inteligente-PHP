<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\CourseController;

    (new CourseController)->Delete($_POST["id_course"]);