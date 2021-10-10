$(document).ready(() => {
    $(".btn-login").click(() => {
        VerifyFields($("form")[0]) ? Ajax("services/users/login", "json", $("form")[0], (response) => {
            SweetAlert(response.icon, response.msg)
            Redirect(response.icon, "projetos")
        }) : ""
    })
})