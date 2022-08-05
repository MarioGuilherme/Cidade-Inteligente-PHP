<h1 style="background: #b11116;color: white;width: 70%;margin-bottom: 0;margin-left: auto;margin-right: auto;padding: 20px;margin-top: 2em;box-shadow: 0 6px 6px rgba(92, 92, 92, 0.4);text-align: center; font-family: Arial, Helvetica, sans-serif;">
    Recuperação de senha
</h1>
<div style="background: #c5c5c55e;width: 70%;margin-left: auto;margin-right: auto;margin-top: 0;padding: 10px;text-align: center;font-family: Arial, Helvetica, sans-serif;">
    <h2>
        Olá, Mário!
    </h2>
    <h3>
        Você solicitou a recuperação de sua senha.
    </h3>
    <a href="{{ URL }}alterar-senha?token={{ TOKEN }}" style="color:white;background:#b11116; padding: 10px;text-decoration: none;text-transform: uppercase;">
        Clique para redefinir a sua senha
    </a>
    <p style="color:rgb(63, 63, 63);">
        Não compartilhe esse link com ninguém!
    </p>
    <p style="color:rgb(63, 63, 63);">
        Este link irá expirar em 1 hora.
    </p>
    <p style="color:rgb(92, 92, 92);">
        Caso não tenha solicitado a recuperação de senha, ignore este email.
    </p>
    <br>
    <p style="font-size:12px;">
        Atenciosamente
    </p>
    <p style="font-size:12px;">
        Equipe Cidade Inteligente
    </p>
</div>
<style>
    @media screen and (max-width: 600px) {
        h2 {
            font-size: 20px;
        }
        h3 {
            font-size: 15px;
        }
        a {
            font-size: 10px;
        }
        h1 {
            font-size: 22px;
            width: 97%;
            margin-top: 2em;
        }
        div {
            width: 100%;
        }
    }
</style>