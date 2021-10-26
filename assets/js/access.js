$(document).ready(() => {
    $(".btn-login").click(() => {
        VerifyFields($("form"))
        Ajax("services/users/login", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            Redirect(response.icon, "projetos")
        })
    })
})