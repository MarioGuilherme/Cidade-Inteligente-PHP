$(document).ready(() => {
    $(".btn-generate-qrcode").click(() => {
        Swal.fire({
            html: `<div class="qrCode mb-1 d-flex justify-content-center"></div>`,
            background: "rgb(70, 5, 7)",
            showConfirmButton: false
        });
        new QRCode(document.querySelector(".qrCode"), window.location.href);
    });
})