<?php

    session_start();
    $_SESSION["tipo"] != "Professor(a)" ? header("Location: main") : "";
    require  __DIR__ . "/vendor/autoload.php";
    use App\Controller\Page;
    echo ((new Page("Novo Projeto", "form-project"))->structure);