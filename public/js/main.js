$(document).ready(() => {
    class CRUD {
        constructor() {
            this.init();
        }
    }
    $(".btn").click(() => {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "src/projects/new-project",
            data: new FormData($($("form"))[0]),
            nimeType: "multipart/form-data",
            cache: false,
            contentType: false,
            processData: false,
        }).done((response) => {
            SweetAlert(response.icon, response.msg)
        })
    })
})