$(document).ready(() => {
    $(".btn-new-user").click(() => {
        VerifyFields($("form").serializeArray());
        VerifyPasswords();
        Ajax("services/register", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
        });
    });
});