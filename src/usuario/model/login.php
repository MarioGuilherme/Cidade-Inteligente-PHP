<?php

    include('../../database/conexao.php');

    if($conexao){

        if(empty(trim($_POST['email'])) || empty(trim($_POST['senha']))){
            $retorno = CAMPOS_VAZIOS;
        }else{
            $email = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['email'])));
            $senha = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST['senha'])));
            $_POST['conectado'] == 1 ? $conectado = 1 : $conectado = time() + 14400;
                    
            $sql = 'SELECT * FROM usuarios u INNER JOIN cursos c ON u.id_curso=c.id_curso WHERE email = ":email"';
            $sql = str_replace(':email', $email, $sql);
            $consulta = mysqli_query($conexao, $sql);

            if(mysqli_num_rows($consulta) > 0){

                $dados = mysqli_fetch_assoc($consulta);
                if(password_verify($senha, $dados['senha'])){

                    session_start();
                    $_SESSION['id_usuario'] = $dados['id_usuario'];
                    $_SESSION['id_curso'] = $dados['id_curso'];
                    $_SESSION['curso'] = $dados['curso'];
                    $_SESSION['nome'] = $dados['nome'];
                    $_SESSION['email'] = $dados['email'];
                    $_SESSION['tipo'] = $dados['tipo'];
                    $_SESSION['nivel'] = $dados['nivel'];
                    $_SESSION['hora_login'] = $conectado;
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

    echo json_encode($retorno);