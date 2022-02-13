$(document).ready(() => {
    $(".btn-change").click(() => {
        VerifyFields($("form").serializeArray());
        VerifyPasswords();
        Ajax("services/change-password", "json", {
            token: window.location.href.substr(56),
            password: $("input[name=password]").val(),
        }, response => {
            SweetAlert(response.icon, response.msg);
            Redirect(response.icon, "projetos");
        });
    });
});