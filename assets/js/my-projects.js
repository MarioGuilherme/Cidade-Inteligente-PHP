$(document).ready(() => {
    $(".btn-delete-project").click(function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este projeto?</h2>`,
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
                Ajax("services/delete-project", "json", { id_project: $(this).attr("id") }, response => {
                    SweetAlert(response.icon, response.msg);
                    response.icon == "success" ? $(this).parents("div.col-12").hide(500) : null;
                });
            }
        });
    })
});