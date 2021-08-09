$(document).ready(() => {
    $(".btn-new-project").click(() => {
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
            if (response.icon === "success") {
                $("input, textarea, select").val("")
            }
        })
    })
    $(".btn-new-user").click(function() {
        Ajax("src/users/register", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            if (response.icon === "success") {
                $("input, textarea, select").val("")
            }
        })
    })
    $(".btn-delete-media").click(function() {
        Ajax("src/projects/delete-media", "json", `id=${$(this).attr("id")}&path=${$(this).parent().parent().find("img, video").attr("src")}`, (response) => {
            SweetAlert(response.icon, response.msg)
            if (response.icon === "success") {
                $(this).parent().parent().remove()
            }
        })
    })
})