$(document).ready(() => {
    Ajax("services/list-courses", "html", null, response => {
        $("tbody").html(response);
        $("table").DataTable({
            "language": {
                "url": "assets/pt_br.json"
            }
        });
    });
    $(".btn-new-course").click(() => {
        VerifyFields($("form").serializeArray());
        Ajax("services/new-course", "json", $("form").serialize(), response => {
            $("input[name=id_course]").val("0");
            SweetAlert(response.icon, response.msg);
            CleanFields(response.icon);
            if (response.icon == "success") {
                $("#modal").modal("hide");
                Ajax("services/list-courses", "html", null, response => $("tbody").html(response));
            }
        });
    });
    $(".btn-form-course").click(() => {
        $("input[name=id_course]").val("0");
        $("input[name=course]").val("");
        $(".modal-title").html("Cadastrar Curso");
        $(".btn-update-course").hide();
        $(".btn-new-course").show();
        $("#modal").modal("show");
    });
    $("tbody").on("click", ".btn-edit-course", function() {
        Ajax("services/view-course", "json", { id_course: $(this).attr("id") }, course => {
            $("input[name=id_course]").val(course.id_course);
            $("input[name=course]").val(course.course);
            $(".modal-title").html("Editar Curso");
            $(".btn-update-course").show();
            $(".btn-new-course").hide();
            $("#modal").modal("show");
        });
    });
    $(".btn-update-course").click(function() {
        Ajax("services/update-course", "json", $("form").serialize(), response => {
            SweetAlert(response.icon, response.msg);
            if (response.icon == "success") {
                $("#modal").modal("hide");
                Ajax("services/list-courses", "html", null, response => $("tbody").html(response));
            }
        });
    });
    $("tbody").on("click", ".btn-delete-course", function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este curso?</h2>`,
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
                Ajax("services/delete-course", "json", { id_course: $(this).attr("id") }, response => {
                    SweetAlert(response.icon, response.msg);
                    response.icon == "success" ? $(this).parents("tr").hide(500) : null;
                });
            }
        });
    });
});