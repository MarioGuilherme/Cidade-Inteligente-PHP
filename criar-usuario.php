<?php

    require  __DIR__ . "/vendor/autoload.php";
    use App\Controller\UserController;
    use App\Controller\Page;
    new Page("Criar Usuário", "form-user", 2, new UserController(), "LoadForm");