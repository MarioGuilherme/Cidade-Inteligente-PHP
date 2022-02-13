function AjaxFile(url, dataType, data, callback) {
    $.ajax({
        type: "POST",
        url: url,
        dataType: dataType,
        data: new FormData(data),
        nimeType: "multipart/form-data",
        cache: false,
        contentType: false,
        processData: false
    }).done(callback);
}

function Ajax(url, dataType, data, callback) {
    $.ajax({
        type: "POST",
        url: url,
        dataType: dataType,
        data: data,
    }).done(callback);
}

function SweetAlert(icon, msg) {
    Swal.fire({
        icon: icon,
        html: `<h2 style="color:white; font-weight:bold;">${msg}</h2>`,
        background: "rgb(31, 50, 51)",
        allowOutsideClick: false
    });
}

function Redirect(icon, url) {
    if (icon == "success") {
        setTimeout(function() {
            $(location).attr("href", url);
        }, 2000);
    }
}

function VerifyPasswords() {
    if ($($("input[type=password")[0]).val() != $($("input[type=password")[1]).val()) {
        SweetAlert("error", "As senhas não conferem");
        throw "exit";
    }
}

function VerifyFields(form) {
    for (let i = 0; i < form.length; i++) {
        if (form[i].value == "") {
            SweetAlert("error", "Há campo(s) vazio(s) que precisam ser preenchidos");
            throw "exit";
        }
    }
}

function CleanFields(icon) {
    if (icon == "success") {
        $("input, select, textarea").val("");
        $("select").prop("selectedIndex", 0);
    }
}

function Redirect(icon, url) {
    icon == "success" ? setTimeout(() => {
        $(location).attr("href", url);
    }, 2000) : "";
}