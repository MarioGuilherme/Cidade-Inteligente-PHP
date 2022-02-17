$(document).ready(() => {
    $(".btn-new-area").click(() => {
        VerifyFields($("form").serializeArray());
        Ajax("services/new-area", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
            $("input[name=id_area]").val("0");
        });
    })
    $(".btn-form-area").click(() => {
        $("input[name=id_area]").val("0");
        $("input[name=area]").val("");
        $(".modal-title").html("Cadastrar Área");
        $(".btn-update-area").hide();
        $(".btn-new-area").show();
        $("#modal").modal("show");
    });
    $(".btn-edit-area").click(function() {
        Ajax("services/view-area", "json", { id_area: $(this).attr("id") }, area => {
            $("input[name=id_area]").val(area.id_area);
            $("input[name=area]").val(area.area);
            $(".modal-title").html("Editar Área");
            $(".btn-update-area").show();
            $(".btn-new-area").hide();
            $("#modal").modal("show");
        });
    });
    $("table").DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        }
    });
});