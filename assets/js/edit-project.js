$(document).ready(() => {
    var users = [];
    var index = 0;

    for (let i = 0; i < $(".user[involved=true]").length; i++)
        users.push($(".user[involved=true]")[i].id);

    $(".user").click(function() {
        if ($(this).attr("involved") == "true") {
            $(this).attr("involved", false);
            users.splice(users.indexOf($(this).attr("id")), 1);
        } else {
            users.push($(this).attr("id"));
            $(this).attr("involved", true);
        }
    });

    $(".btn-add-media").click(() => {
        RemoveEmptyInputsFile();
        $(".inputs-medias").append(`<input type="file" hidden name="medias[${index}]" index="${index}">`);
        $("input[type=file]").last().click();
    })

    $(".btn-update-project").click(() => {
        let form = $("form").serializeArray();
        form.push({
            name: "users",
            value: users
        });
        VerifyFields(form);
        RemoveEmptyInputsFile();

        var data = new FormData($("form")[0]);
        for (var i = 0; i < users.length; i++)
            data.append("users[]", users[i]);

        if ($(".medias-included").children(".col-12").length == 0)
            SweetAlert("warning", "Você precisa enviar pelo menos uma mídia para o projeto");
        else {
            $(".btn-update-project").text("Salvando alterações...");
            $(".btn-update-project").attr("disabled", true);
            AjaxFile("services/update-project", "json", data, response => {
                SweetAlert(response.icon, response.msg);
                $(".btn-update-project").text("Salvar alterações");
                $(".btn-update-project").attr("disabled", false);
            });
        }
    });

    $(".btn-delete-media").click(function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir esta mídia?</h2>`,
            background: "rgb(39, 39, 61)",
            icon: "question",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: "Sim",
            confirmButtonColor: "#d9534f",
            cancelButtonText: "Não",
            cancelButtonColor: "#f0ad4e"
        }).then(result => {
            if (result.value) {
                Ajax("services/delete-media", "json", { id_media: $(this).attr("id") }, response => {
                    response.icon == "success" ? $(this).parents("div.col-12").hide(500) : null;
                    setTimeout(() => {
                        response.icon == "success" ? $(this).parents("div.col-12").remove() : null;
                    }, 1500);
                });
            }
        });
    });

    $(".inputs-medias").on("change", "input[type=file]", function() {
        let file = $("input[type=file]").last()[0].files[0];
        let reader = new FileReader();

        reader.onload = function(e) {
            let type = file.type.split("/")[0];

            if (type == "image")
                media = `<img src="${e.target.result}" class="img-fluid">`;
            else if (type == "video")
                media = `<video style="width: -webkit-fill-available;" src="${e.target.result}" controls></video>`;
            else {
                SweetAlert("error", "Apenas formatos jpg, .png e .mp4 são aceitos.");
                $(".inputs-medias").find("input[type=file]").last().remove();
            }

            if (type == "image" || type == "video") {
                $(".col-btn").before(`
                    <div class="col-12 col-sm-12 col-lg-3 col-md-3 my-3">
                        <div class="card">
                            <div style="right: 0;" class="position-absolute">
                                <button type="button" class="btn btn-danger btn-delete-media" index="${index}">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    Apagar
                                </button>
                            </div>
                            <div class="card-body">
                                ${media}
                                <div class="form-group">
                                    <label class="text-dark">
                                        Nome
                                    </label>
                                    <input maxlenght="60" class="form-control" type="text" value="${file.name.substr(0, file.name.lastIndexOf('.')) || file.name}" name="medias[${index}][name]">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark">
                                        Descrição
                                    </label>
                                    <textarea maxlenght="300" class="form-control" name="medias[${index}][description]" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                index++;
            }
        }
        reader.readAsDataURL(file);
    });
});