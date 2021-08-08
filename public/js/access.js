$(document).ready(() => {
    $(".btn-login").click(() => {
        Ajax("src/users/login", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            if (response.icon == "success") {
                setTimeout(() => {
                    $(location).attr("href", "main")
                }, 1250);
            }
        })
    })
})