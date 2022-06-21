$(document).ready(() => {
    Ajax("services/list-areas", "html", null, response => {
        $("tbody").html(response);
        $("table").DataTable({
            "language": {
                "url": "assets/pt_br.json"
            }
        });
    });
    $(".btn-new-area").click(() => {
        VerifyFields($("form").serializeArray());
        Ajax("services/new-area", "json", $("form").serialize(), response => {
            $("input[name=id_area]").val("0");
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
            response.icon == "success" ? $("#modal").modal("hide") : null;
            Ajax("services/list-areas", "html", null, response => $("tbody").html(response));
        });
    });
    $(".btn-form-area").click(() => {
        $("input[name=id_area]").val("0");
        $("input[name=area]").val("");
        $(".modal-title").html("Cadastrar Área");
        $(".btn-update-area").hide();
        $(".btn-new-area").show();
        $("#modal").modal("show");
    });
    $("tbody").on("click", ".btn-edit-area", function() {
        Ajax("services/view-area", "json", { id_area: $(this).attr("id") }, area => {
            $("input[name=id_area]").val(area.id_area);
            $("input[name=area]").val(area.area);
            $(".modal-title").html("Editar Área");
            $(".btn-update-area").show();
            $(".btn-new-area").hide();
            $("#modal").modal("show");
        });
    });
    $(".btn-update-area").click(function() {
        Ajax("services/update-area", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
            response.icon == "success" ? $("#modal").modal("hide") : null;
            Ajax("services/list-areas", "html", null, response => $("tbody").html(response));
        });
    });
    $("tbody").on("click", ".btn-delete-area", function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir esta área?</h2>`,
            background: "rgb(51, 51, 51)",
            icon: "question",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: "Sim",
            confirmButtonColor: "#d9534f",
            cancelButtonText: "Não",
            cancelButtonColor: "#f0ad4e"
        }).then(result => {
            if (result.value) {
                Ajax("services/delete-area", "json", { id_area: $(this).attr("id") }, response => {
                    SweetAlert(response.icon, response.msg);
                    response.icon == "success" ? $(this).parents("tr").hide(500) : null;
                });
            }
        });
    });
});