$(document).ready(() => {
    var tagMedia = null;
    $(".btn-update-project").click(() => {
        VerifyFields($("form").serializeArray());
        AjaxFile("services/update-project", "json", $("form")[0], response => {
            SweetAlert(response.icon, response.msg);
            if (response.icon == "success") {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
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

    // reordena as mídias
    $(".medias-uploaded").sortable({
        revert: true,
        update: function(event, ui) {
            var order = $(this).sortable("toArray");
            for (var i = 0; i < order.length; i++) {
                $(`div[id=${order[i]}]`).attr("index", i);
            }

        }

    })
    $(".btn-add-medias").click(() => {
        $(".input-medias").click();
    });
    $(".btn-change-media").click(function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo editar a mídia, ao selecionar arquivo? Será irreversível!</h2>`,
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
                $(".input-media").click();
                tagMedia = $(this);
            }
        });
    });
    $(".input-media").on("change", () => {
        let file = $(".input-media")[0].files[0];
        let reader = new FileReader();
        reader.onload = function(e) {
            let type = file.type.split("/")[0];
            if (type == "image") {
                media = `<img src="${e.target.result}" class="img-fluid" alt="">`;
            } else if (type == "video") {
                media = `<video style="width: -webkit-fill-available;" src="${e.target.result}" controls></video>`;
            }
            if (type == "image" || type == "video") {
                $(tagMedia).parents("div.col-12").find("video, img").remove();
                $(tagMedia).parents("div.col-12").find(".card-body").prepend();
                $(tagMedia).parents("div.col-12").find(".card-body").prepend(media + `<input type="hidden" name="id_media" value="${(tagMedia).attr("id")}">`);
            }
        }
        reader.readAsDataURL(file);
        setTimeout(() => {
            AjaxFile("services/update-media", "json", $("form")[0], response => {
                SweetAlert(response.icon, response.msg);
            })
        }, 750);
    });
    $(".input-medias").on("change", () => {
        $(".medias-uploaded").empty();
        var files = $(".input-medias")[0].files;
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
                if (type == "image" || type == "video") {
                    $(".medias-uploaded").append(`
                        <div class="col-12 col-sm-12 col-lg-3 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    ${media}
                                    <div class="form-group">
                                        <label class="text-dark">
                                            Nome
                                        </label>
                                        <input maxlenght="60" class="form-control" type="text" name="name_media[]">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark">
                                            Descrição
                                        </label>
                                        <textarea maxlenght="300" class="form-control" name="description_media[]" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                }
            }
            reader.readAsDataURL(file);
        }
    });
});