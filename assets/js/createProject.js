$(document).ready(() => {
    const project = {
        title: null,
        startDate: null,
        endDate: null,
        description: null,
        id_area: null,
        id_course: null,
        users:[],
        medias: []
    };
    var indexMediaToUpdate = 0;

    $(".btn-new-project").click(() => {
        formHasEmptyField([...$(".medias").find("input, textarea"), ...$("form").serializeArray()]);

        project.title = $("input[name=title]").val();
        project.startDate = $("input[name=startDate]").val();
        project.endDate = $("input[name=endDate]").val();
        project.description = $("textarea[name=description]").val();
        project.id_area = $("select[name=id_area]").val();
        project.id_course = $("select[name=id_course]").val();

        if (project.users.length == 0 || project.medias.length == 0) {
            sweetAlert("warning", "Por favor, selecione pelo menos um usuário e uma mídia para o projeto.");
            return;
        }

        if (project.medias.length > 10) {
            sweetAlert("warning", "Por favor, selecione no máximo 10 mídias para o projeto.");
            return;
        }

        // VERIFICA SE TODAS AS MÍDIAS TÊM 2.5MB OU MENOS
        for (let i = 0; i < project.medias.length; i++)
            if (project.medias[i].size > 2621440) {
                sweetAlert("warning", "Por favor, selecione mídias com menos de 2.5MB.");
                return;
            }

        (async () => {
            sweetAlertAwait("Cadastrando projeto");
            const { icon, message } = await api.post("projects", project);
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

            if (icon == "success") {
                Swal.fire({
                    icon: "success",
                    html: `<div class="qrCode mb-1 d-flex justify-content-center"></div><h2 style="color:white;">Projeto cadastrado com sucesso!</h2>`,
                    background: "rgb(70, 5, 7)",
                    allowOutsideClick: false
                });
                new QRCode(document.querySelector(".qrCode"), message);
                cleanAllFields();
                $(".medias").empty();
                project.title = null;
                project.date = null;
                project.description = null;
                project.id_area = null;
                project.id_course = null;
                project.users = [];
                project.medias = [];
            } else
                sweetAlert("error", message);
        })();
    });

    $(".user").click(function() {
        if ($(this).attr("involved") == "true") {
            $(this).attr("involved", false);
            project.users.splice(project.users.indexOf($(this).attr("id")), 1);
        } else {
            project.users.push($(this).attr("id"));
            $(this).attr("involved", true);
        }
    });

    $(".btn-add-media").click(() => {
        if (project.medias.length >= 10) {
            sweetAlert("warning", "Limite de mídias atingido.");
            return;
        };
        $(".input-new-medias").click();
    });

    $(".medias").on("click", ".btn-change-media", function() {
        indexMediaToUpdate = [...$(".media")].indexOf($(this).parents(".media")[0]);
        $(".input-change-media").click();
    });

    $(".medias").on("click", ".btn-remove-media", function() {
        const indexMediaToDelete = [...$(".media")].indexOf($(this).parents(".media")[0]);
        setTimeout(() => $(this).parents(".col-12").remove(), 1000);
        $(this).parents(".col-12").hide(500);
        project.medias.splice(indexMediaToDelete, 1);
    });

    $(".medias").on("input", "input", function() {
        const i = [...$(".medias > div")].indexOf($(this).parents(".col-12")[0]);
        project.medias[i].name = $(this).val();
    });

    $(".medias").on("input", "textarea", function() {
        const i = [...$(".medias > div")].indexOf($(this).parents(".col-12")[0]);
        project.medias[i].description = $(this).val();
    });

    $(".input-new-medias").on("change", function() {
        const files = $(".input-new-medias")[0].files;

        for (let i = 0; i < files.length; i++) {
            const fileReader = new FileReader;
            const file = files[i];

            fileReader.onloadend = e => {
                if (project.medias.length == 10) {
                    sweetAlert("warning", "Limite de 10 mídias atingido.");
                    return;
                }

                if (isValidFile(file)) { // VERIFICA SE É UM ARQUIVO VALIDO, E O TRATAMENTO DE ERRO É FEITO DENTRO DA FUNÇÃO
                    const type = file.type.split("/")[0];
                    let mediaElement = "";

                    type == "image" ? 
                        mediaElement = `<img src="${e.target.result}" class="img-fluid">` :
                        mediaElement = `<video src="${e.target.result}" style="max-width: 100%;" controls></video>`;

                    $(".medias").append(`
                        <div class="col-12 col-sm-12 col-lg-3 col-md-3 my-3">
                            <div class="card media">
                                <div class="card-body">
                                    ${mediaElement}
                                    <div class="row mt-2 mb-1">
                                        <div class="col-12 col-lg-6 pr-1">
                                            <button type="button" class="btn btn-change-media w-100 btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                                Alterar
                                            </button>
                                        </div>
                                        <div class="col-12 col-lg-6 pl-1">
                                            <button type="button" class="btn w-100 btn-remove-media btn-default-red">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                                Apagar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Nome
                                        </label>
                                        <input maxlength="60" class="form-control" type="text" value="${file.name.substr(0, file.name.lastIndexOf(".")) || file.name}">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Descrição
                                        </label>
                                        <textarea maxlength="200" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    project.medias.push({
                        name: file.name.substr(0, file.name.lastIndexOf(".")) || file.name,
                        type: file.type,
                        size: file.size,
                        description: "",
                        base64: e.target.result.split(",")[1]
                    });
                }
            }
            fileReader.readAsDataURL(file);
        }
    });

    $(".input-change-media").on("change", function() {
        const file = $(".input-change-media")[0].files[0];
        const fileReader = new FileReader;

        fileReader.onloadend = e => {
            if (isValidFile(file)) { // VERIFICA SE É UM ARQUIVO VALIDO, E O TRATAMENTO DE ERRO É FEITO DENTRO DA FUNÇÃO
                const type = file.type.split("/")[0];
                let mediaElement = "";

                type == "image" ? 
                    mediaElement = `<img src="${e.target.result}" class="img-fluid">` :
                    mediaElement = `<video src="${e.target.result}" style="max-width: 100%;" controls></video>`;

                $($(".media")[indexMediaToUpdate]).find("img, video").remove();
                $($(".media")[indexMediaToUpdate]).find(".card-body").prepend(mediaElement);

                project.medias[indexMediaToUpdate].base64 = e.target.result.split(",")[1];
                project.medias[indexMediaToUpdate].type = file.type;
                project.medias[indexMediaToUpdate].size = file.size;
            }
        }
        fileReader.readAsDataURL(file);
    });
});