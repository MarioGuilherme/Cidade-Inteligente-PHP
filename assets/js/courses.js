$(document).ready(() => {
    setDataTable();

    const resetDataTable = async () => {
        const courses = await api.get("courses");
        const dataTable = $("table").DataTable();

        if (courses.length == 0)
            dataTable.clear().draw();
        else {
            dataTable.clear();
            courses.map(course => {
                dataTable.row.add([
                    course.id_course,
                    course.course,
                    `<button id="${course.id_course}" class="btn btn-edit-course btn-strong-gray">
                        Editar
                    </button>
                    <button id="${course.id_course}" class="btn btn-delete-course btn-strong-red">
                        Apagar
                    </button>`
                ]).draw();
            });
        }
    }

    $(".btn-save").click(async () => {
        if ($("input[name=id_course]").val() == "") {
            sweetAlertAwait("Cadastrando curso");
            const { icon, message } = await api.post("courses", { course: $("input[name=course]").val() });
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

            if (icon == "success") {
                await resetDataTable();
                sweetAlert(icon, message);
                cleanAllFields();
                $(".modal").modal("hide");
            } else
                sweetAlert(icon, message);

        } else {
            sweetAlertAwait("Salvando alterações");
            const { icon, message } = await api.patch("courses", {
                id_course: $("input[name=id_course]").val(),
                course: $("input[name=course]").val()
            });
            window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

            if (icon == "success") {
                await resetDataTable();
                sweetAlert(icon, message);
                cleanAllFields();
                $(".modal").modal("hide");
            } else
                sweetAlert(icon, message);
        }
    });

    $("button[data-target='#formModal']").click(() => {
        cleanAllFields();
        $(".modal-title").html("Cadastrar Curso");
    });

    $("tbody").on("click", ".btn-edit-course", async function() {
        sweetAlertAwait("Carregando dados do curso");
        const course = await api.get(`courses?id=${$(this).attr("id")}`);
        swal.close();
        window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

        $("input[name=id_course]").val(course.id_course);
        $("input[name=course]").val(course.course);
        $(".modal-title").html("Editar Curso");
        $(".modal").modal("show");
    });

    $("tbody").on("click", ".btn-delete-course", async function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este curso?</h2>`,
            background: "rgb(70, 5, 7)",
            icon: "question",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: "Sim",
            confirmButtonColor: "#d9534f",
            cancelButtonText: "Não",
            cancelButtonColor: "#f0ad4e"
        }).then(async result => {
            if (result.value) {
                sweetAlertAwait("Excluindo curso");
                const { icon, message } = await api.delete(`courses?id=${$(this).attr("id")}`);
                window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

                if (icon == "success") {
                    await resetDataTable();
                    sweetAlert(icon, message);
                } else
                    sweetAlert(icon, message);
            }
        });
    });
});