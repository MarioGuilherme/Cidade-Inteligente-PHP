$(document).ready(() => {
    $(".btn-login").click(() => {
        VerifyFields($("form")[0]);
        Ajax("src/services/login", "json", {
            email: $("input[name=email]").val(),
            password: $("input[name=password]").val(),
            remeber: $("input[name=remember]").is(":checked") ? 1 : 0,
        }, (response) => {
            SweetAlert(response.icon, response.msg);
            Redirect(response.icon, "projetos");
        });
    });
    $(".esqueceu-senha").click(() => {
        $(location).attr("href", "recuperar-senha");
    });
})