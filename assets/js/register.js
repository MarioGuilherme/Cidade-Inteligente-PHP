$(document).ready(() => {
    $(".btn-new-user").click(() => {
        VerifyFields($("form")[0]);
        VerifyPasswords();
        Ajax("src/services/register", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
        });
    })
})