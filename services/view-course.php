<?php

    require __DIR__ . "/../App/Config/App.php";

    use App\Controllers\CourseController;

    (new CourseController())->ViewByID($_POST["id_course"]);