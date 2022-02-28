$(document).ready(() => {
    function ListUsers() {
        Ajax("services/list-users", "html", null, response => {
            $("tbody").html(response);
        });
    }
    setTimeout(() => {
        ListUsers();
    }, 550);
    $("table").DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
        }
    });
    $(".btn-new-user").click(() => {
        VerifyFields($("form").serializeArray());
        Ajax("services/new-user", "json", $("form").serialize(), response => {
            $("input[name=id_user]").val("0");
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
            response.icon == "success" ? $("#modal").modal("hide") : null;
            ListUsers();
        });
    });
    $(".btn-form-user").click(() => {
        $("input[name=id_user]").val("0");
        $("input[name=user]").val("");
        $(".modal-title").html("Cadastrar Área");
        $(".btn-update-user").hide();
        $(".btn-new-user").show();
        $("#modal").modal("show");
    });
    $("tbody").on("click", ".btn-edit-user", function() {
        Ajax("services/view-user", "json", { id_user: $(this).attr("id") }, user => {
            $("input[name=id_user]").val(user.id_user);
            $("select[name=course]").val(user.id_course);
            $("input[name=name]").val(user.name);
            $("input[name=email]").val(user.email);
            $("#modal").modal("show");
        });
    });
    $(".btn-update-user").click(function() {
        Ajax("services/update-user", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
            response.icon == "success" ? $("#modal").modal("hide") : null;
            ListUsers();
        });
    });
    $("tbody").on("click", ".btn-delete-user", function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este usuário?</h2>`,
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
                Ajax("services/delete-user", "json", { id_user: $(this).attr("id") }, response => {
                    SweetAlert(response.icon, response.msg);
                    response.icon == "success" ? $(this).parents("tr").hide(500) : null;
                });
            }
        });
    });
});