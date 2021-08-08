function Ajax(url, dataType, data, callback) {
    $.ajax({
        url: url,
        type: "POST",
        dataType: dataType,
        data: data,
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

function Create() {

}