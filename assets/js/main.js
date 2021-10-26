$(document).ready(() => {
    $(".btn-new-project").click(() => {
        VerifyFields($("form")[0])
        AjaxFile("services/projects/new-project", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            CleanFields(response.icon)
            $(".medias-uploaded").empty()
        })
    })
    $(".btn-new-user").click(() => {
        VerifyFields($("form")[0])
        VerifyPasswords()
        Ajax("services/users/register", "json", $("form").serialize(), (response) => {
            SweetAlert(response.icon, response.msg)
            CleanFields(response.icon)
        })
    })
    $(".btn-delete-media").click(function() {
        Ajax("src/projects/delete-media", "json", `id=${$(this).attr("id")}&path=${$(this).parent().parent().find("img, video").attr("src")}`, (response) => {
            SweetAlert(response.icon, response.msg)
            response.icon === "success" ? $(this).parent().parent().remove() : ""
        })
    })
    $("input[type=file]").change(() => {
        $(".medias-uploaded").empty()
        for (let i = 0; i < $("input[type=file]")[0].files.length; i++) {
            $($(".medias-uploaded")).append(`
                <div class="col-3 flex-column mb-3 border-1 p-2 m-1" style="border: 1px dotted;">
                    <p class="font-weight-bold">${$("input[type=file]")[0].files[i]["name"]}</p>
                    <label class="mb-0">
                        Nome da mídia
                    </label>
                    <input class="form-control mb-2" type="text" name="media_name_${i}">
                    <label class="mt-1 mb-0">
                        Descrição da mídia
                    </label>
                    <textarea class="form-control" name="media_description_${i}" rows="3"></textarea>
                </div>
            `)
        }
    })
})