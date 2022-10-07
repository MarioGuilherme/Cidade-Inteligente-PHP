<?php

    declare(strict_types=1);

    // IMPORTA O AUTOLOAD E AS CONSTANTES PARA CONFIGURAÇÕES DO SISTEMA
    require __DIR__ . "/../../vendor/autoload.php";
    require __DIR__ . "/Configs.php";

    use App\Utils\Session;
    use App\Database\Database;

    // CONFIGURA EXIBIÇÃO DE ERROS, CONFIGURA D TIME ZONE E ESPECIFICAÇÕES LOCAIS E INICIA A SESSÃO
    ini_set("display_errors", (string) ISDEV);
    setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "pt_BR.utf-8", "portuguese");
    date_default_timezone_set("America/Sao_Paulo");
    Session::startSession();

    // SETA AS CONFIGURAÇÕES DA CONEXÃO COM O BANCO DE DADOS
    Database::config(
        DATABASE["DRIVER"],
        DATABASE["HOST"],
        DATABASE["DATABASE"],
        DATABASE["USER"],
        DATABASE["PASSWORD"],
        DATABASE["CHARSET"]
    );