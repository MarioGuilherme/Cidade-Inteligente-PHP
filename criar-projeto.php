<?php

    session_start();
    require  __DIR__ . "/vendor/autoload.php";
    use App\Controller\Page;
    echo ((new Page("Novo Projeto", "form-project"))->structure);