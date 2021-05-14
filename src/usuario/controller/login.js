$(document).ready(() => {
    $('.btn-entrar').click((e) => {
        e.preventDefault()
        $.ajax({
            url: 'src/usuario/model/login.php',
            type: 'POST',
            dataType: 'json',
            data: $('#formulario').serialize(),
            success: (retorno) => {
                var confirmar = true
                var janela = true
                if (retorno.icone == 'success') {
                    $('.input[name="email"],[name="senha"]').val('')
                    confirmar = false
                    janela = false
                    setInterval(() => {
                        $('.carregando').append('.')
                    }, 600)
                    setTimeout(() => {
                        $(location).attr('href', 'teste.html')
                    }, 2000)
                }
                Swal.fire({
                    icon: retorno.icone,
                    html: '<h2 class="carregando" style="color:white; font-weight:bold;">' + retorno.msg + '</h2>',
                    background: 'rgb(31 50 51)',
                    allowOutsideClick: janela,
                    showConfirmButton: confirmar
                })
            }
        })
    })
})