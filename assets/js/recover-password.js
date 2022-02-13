$(document).ready(() => {
    $(".btn-recover").click(() => {
        VerifyFields($("form").serializeArray());
        Ajax("services/recover-password", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
        });
    });
});