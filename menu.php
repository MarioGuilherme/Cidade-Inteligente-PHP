<?php
    session_start();
    if(empty($_SESSION)){
        header("Location: cidade-inteligente");
    }else{
        if(time() > $_SESSION['hora_login']){
            session_destroy();
            header("Location: cidade-inteligente");
        }
    }
?>