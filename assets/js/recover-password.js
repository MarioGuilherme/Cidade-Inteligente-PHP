$(document).ready(() => {
    $(".btn-recover").click(() => {
        VerifyFields($("form")[0]);
        Ajax("src/services/recover-password", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg);
        });
    })
})