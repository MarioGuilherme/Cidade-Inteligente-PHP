function Ajax(url, dataType, data, callback) {
    $.ajax({
        type: "POST",
        dataType: dataType,
        url: url,
        data: new FormData(data),
        nimeType: "multipart/form-data",
        cache: false,
        contentType: false,
        processData: false,
    }).done(callback)
}

function SweetAlert(icon, msg) {
    Swal.fire({
        icon: icon,
        html: `<h2 style="color:white; font-weight:bold;">${msg}</h2>`,
        background: "rgb(31 50 51)",
        allowOutsideClick: false
    })
}

function VerifyFields(form) {
    for (let i = 0; i < form.length; i++) {
        if (form[i].value == "") {
            SweetAlert("error", "Preencha o(s) campo(s) vazio(s)")
            throw "exit"
        }
    }
}

function VerifyPasswords() {
    if ($($("input[type=password")[0]).val() != $($("input[type=password")[1]).val()) {
        SweetAlert("error", "As senhas não conferem")
        throw "exit"
    }
}

function CleanFields(icon) {
    icon === "success" ? $("input, textarea, select").val("") : ""
}

function Redirect(icon, url) {
    if (icon == "success") {
        setTimeout(function() {
            $(location).attr("href", url);
        }, 2000);
    }
}