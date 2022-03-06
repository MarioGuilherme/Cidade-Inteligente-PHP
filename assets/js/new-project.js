$(document).ready(() => {
    var users = [];
    var index = 0;

    function CheckEmptyInputFile() {
        for (var i = 0; i < $("input[type=file]").length; i++) {
            if ($("input[type=file]")[i].files.length == 0)
                $("input[type=file]")[i].remove();
        }
    }

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
        CheckEmptyInputFile();
        $(".inputs-medias").append(`<input type="file" hidden name="medias[${index}]" index="${index}">`);
        $("input[type=file]").last().click();
    });

    $(".medias-uploaded").on("click", ".btn-delete-media", function() {
        $(`input[index=${$(this).attr("index")}]`).remove();
        $(this).parents("div.col-12").hide(500);
        setTimeout(() => {
            $(this).parents("div.col-12").remove();
        }, 1500);
    });

    $(".btn-new-project").click(() => {
        let form = $("form").serializeArray();
        form.push({
            name: "users",
            value: users
        });
        VerifyFields(form);
        $(".btn-new-project").text("Criando Projeto...");
        $(".btn-new-project").attr("disabled", true);

        var data = new FormData($("form")[0]);
        for (var i = 0; i < users.length; i++) {
            data.append("users[]", users[i]);
        }

        CheckEmptyInputFile();

        AjaxFile("services/new-project", "json", data, response => {
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
            $(".btn-new-project").text("Criar Projeto");
            $(".btn-new-project").attr("disabled", false);
            response.icon == "success" ? users = [] : null;
        });
    });

    $(".inputs-medias").on("change", "input[type=file]", function() {
        let file = $("input[type=file]").last()[0].files[0];
        let reader = new FileReader();

        reader.onload = function(e) {
            let type = file.type.split("/")[0];

            if (type == "image") {
                media = `<img src="${e.target.result}" class="img-fluid">`;
            } else if (type == "video") {
                media = `<video style="width: -webkit-fill-available;" src="${e.target.result}" controls></video>`;
            } else {
                SweetAlert("error", "Apenas formatos jpg, .png e .mp4 são aceitos.");
                $(".inputs-medias").find("input[type=file]").last().remove();
            }

            if (type == "image" || type == "video") {
                $(".medias-uploaded").append(`
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