<?php

    include('../../database/conexao.php');

    if($conexao){

        if(empty(trim($_POST['curso'])) || empty(trim($_POST['nome'])) || empty(trim($_POST['email'])) || empty(trim($_POST['senha'])) || empty(trim($_POST['tipo'])) || empty(trim($_POST['nivel']))){

            $retorno = CAMPOS_VAZIOS;

        }else{
            $curso = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['curso'])));
            $nome = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['nome'])));
            $email = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['email'])));
            $senha = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['senha'])));
            $tipo = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['tipo'])));
            $nivel = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['nivel'])));

            $sql = 'INSERT INTO usuarios (id_curso, nome, email, senha, tipo, nivel) VALUES (":curso", ":nome", ":email", ":senha", ":tipo", ":nivel")';
            $campos = [':curso', ':nome', ':email', ':senha', ':tipo', ':nivel'];
            $valores = [$curso, $nome, $email, $senha, $tipo, $nivel];
            $sql = str_replace($campos, $valores, $sql);
            $consulta = mysqli_query($conexao, $sql);

            if($consulta){
                session_start();
                $_SESSION['id_usuario'] = $dados['id_usuario'];
                $_SESSION['id_curso'] = $dados['id_curso'];
                $_SESSION['curso'] = $dados['curso'];
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['email'] = $dados['email'];
                $_SESSION['tipo'] = $dados['tipo'];
                $_SESSION['nivel'] = $dados['nivel'];

                $retorno = SUCCESSO_CADASTRO;
            }
        }
    }else{
        $retorno = ERRO_CONEXAO;
    }

    echo json_encode($retorno);