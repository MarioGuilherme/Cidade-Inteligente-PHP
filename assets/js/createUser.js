$(document).ready(() => {
    $(".btn-save").click(() => {
        formHasEmptyField($("form").serializeArray());

        if ($($("input[type=password")[0]).val() != $($("input[type=password")[1]).val()) {
            sweetAlert("error", "As senhas não conferem");
            return;
        }

        (async () => {
            sweetAlertAwait("Cadastrando usuário");
            const { icon, message } = await api.post("users", {
                name: $("input[name=name]").val(),
                email: $("input[name=email]").val(),
                password: $("input[name=password]").val(),
                type: $("select[name=type]").val(),
                id_course: $("select[name=id_course]").val()
            });
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

            if (icon == "success") {
                sweetAlert(icon, message);
                cleanAllFields();
            } else
                sweetAlert(icon, message);
        })();
    });
});