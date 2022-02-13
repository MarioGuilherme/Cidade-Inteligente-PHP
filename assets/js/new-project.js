$(document).ready(() => {
    $(".btn-new-project").click(() => {
        //VerifyFields($("form")[0])
        AjaxFile("src/services/new-project", "json", $("form")[0], (response) => {
            SweetAlert(response.icon, response.msg)
            CleanFields(response.icon)
            $(".medias-uploaded").empty()
        })
    });
    $("input").on("change", () => {
        $(".medias-uploaded").empty();
        var files = $("input[type=file]")[0].files;
        // PERCORRE O ARRAY DE ARQUIVOS E APARECE A IMAGEM
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            let reader = new FileReader();
            let media = "";
            reader.onload = function(e) {
                let type = file.type.split("/")[0];
                if (type == "image") {
                    media = `<img src="${e.target.result}" class="img-fluid" alt="">`;
                } else if (type == "video") {
                    media = `<video style="width: -webkit-fill-available;" src="${e.target.result}" controls></video>`;
                }
                console.log(type)
                console.log(media)
                $(".medias-uploaded").append(`
                    <div class="col-12 col-sm-12 col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                ${media}
                                <div class="form-group">
                                    <label>
                                        Nome
                                    </label>
                                    <input class="form-control" type="text" name="title">
                                </div>
                                <div class="form-group">
                                    <label>
                                        Descrição
                                    </label>
                                    <textarea class="form-control" name="description_project" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        }
    });
})