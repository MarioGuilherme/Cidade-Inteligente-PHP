$(document).ready(() => {
    $(".btn-changePassword").click(() => {
        formHasEmptyField($("form").serializeArray());

        if ($($("input[type=password")[0]).val() != $($("input[type=password")[1]).val()) {
            sweetAlert("error", "As senhas não conferem");
            return;
        }

        (async () => {
            sweetAlertAwait("Alterando senha");
            const { icon, message } = await api.post("changePassword", {
                password: $("input[name=password]").val(),
                token: $("input[name=token]").val()
            });
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída
    
            if (icon == "success") {
                sweetAlert(icon, message);
                redirect(icon, "/");
            } else
                sweetAlert(icon, message);
        })();
    });
});