<?php

    require  __DIR__ . "/vendor/autoload.php";
    use App\Controller\ProjectController;
    use App\Controller\Page;
    new Page("Projetos", "projects", 0, new ProjectController(), "Index");