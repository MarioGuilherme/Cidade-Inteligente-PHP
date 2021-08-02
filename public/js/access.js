$(document).ready(() => {
    $(".btn-login").click(() => {
        Ajax("ajax/users/login", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            if (response.icon == "success") {
                setTimeout(() => {
                    $(location).attr("href", "menu")
                }, 1250);
            }
        })
    })
})