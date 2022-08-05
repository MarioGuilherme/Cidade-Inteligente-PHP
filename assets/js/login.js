$(document).ready(() => {
    $(".btn-login").click(() => {
        formHasEmptyField($("form").serializeArray());

        (async () => {
            sweetAlertAwait("Fazendo login");
            const { icon, message } = await api.post("login", {
                email: $("input[name=email]").val(),
                password: $("input[name=password]").val()
            });
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

            if (icon == "success") {
                sweetAlert(icon, message);
                cleanAllFields();
                redirect(icon, "/");
            } else
                sweetAlert(icon, message);
        })();
    });
});