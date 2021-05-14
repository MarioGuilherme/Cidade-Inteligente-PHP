<?php

    include('../../database/conexao.php');

    if($conexao){

        if(trim($_POST['email']) == '' || trim($_POST['senha']) == ''){

            $retorno = CAMPOS_VAZIOS;

        }else{
            $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
            $senha = md5(mysqli_real_escape_string($conexao, trim($_POST['senha'])));

            $sql = 'SELECT * FROM usuarios WHERE email = ":email"';
            $sql = str_replace(':email', $email, $sql);
            $consulta = mysqli_query($conexao, $sql);
            $emails = mysqli_num_rows($consulta);

            if($emails == 1){

                $sql .= ' AND senha = ":senha"';
                $sql = str_replace(':senha', $senha, $sql);
                $consulta = mysqli_query($conexao, $sql);
                $encontrados = mysqli_num_rows($consulta);

                if($encontrados == 1){
                    $dados = mysqli_fetch_assoc($consulta);
                    session_start();
                    $_SESSION['id_usuario'] = $dados['id_usuario'];
                    $_SESSION['nome'] = $dados['nome'];
                    $_SESSION['email'] = $dados['email'];
                    $_SESSION['tipo'] = $dados['tipo'];
                    $_SESSION['nivel'] = $dados['nivel'];

                    $retorno = SUCCESSO_LOGIN;

                }else{
                    $retorno = SENHA_INCORRETA;
                }

            }else{
                $retorno = NAO_CADASTRADO;
            }
        }

    }else{
        $retorno = ERRO_CONEXAO;
    }

    echo json_encode($retorno, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);