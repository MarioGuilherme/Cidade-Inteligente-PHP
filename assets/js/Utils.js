const setDataTable = () => {
    $("table").DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        language: {
            "url": "assets/pt_br.json"
        }
    });
}

const sweetAlert = (icon, msg) => {
    Swal.fire({
        icon: icon,
        html: `<h2 style="color:white;">${msg}</h2>`,
        background: "rgb(70, 5, 7)",
        allowOutsideClick: false
    });
}

const sweetAlertAwait = msg => {
    window.onbeforeunload = () => true; // Ativa o alert de confirmação de saída
    Swal.fire({
        icon: "info",
        html: `<div class="qrCode mb-1 d-flex justify-content-center"></div><h2 style="color:white;">${msg}, aguarde...</h2>`,
        background: "rgb(70, 5, 7)",
        allowOutsideClick: false,
        showConfirmButton: false
    });
}

const formHasEmptyField = form => {
    for (let i = 0; i < form.length; i++)
        if (form[i].value == "") {
            sweetAlert("error", "Há campo(s) vazio(s) que precisam ser preenchidos");
            throw "exit";
        }
}

const cleanAllFields = () => {
    $(".user").attr("involved", false);
    $(".medias-uploaded").empty();
    $("input, select, textarea").val("");
    $("select").prop("selectedIndex", 0);
}

const redirect = (icon, url) => {
    if (icon == "success")
        setTimeout(() => $(location).attr("href", url), 2000);
}

const isValidFile = file => {
    const type = file.type.split("/")[0];
    const extension = file.type.split("/")[1];

    if (file.size > 2621440) {
        sweetAlert("warning", "Por favor, selecione mídias com menos de 2.5MB.");
        return false;
    } else if (type != "image" && type != "video") {
        sweetAlert("warning", "É permitido apenas anexos do tipo vídeo e foto.");
        return false;
    } else if (extension != "mp4" && extension != "jpg" && extension != "jpeg" && extension != "png") {
        sweetAlert("warning", "Apenas mídias .jpg, .jpeg, .png e .mp4.");
        return false;
    }

    return true;
}