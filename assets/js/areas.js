$(document).ready(() => {
    setDataTable();

    const resetDataTable = async () => {
        const areas = await api.get("areas");
        const dataTable = $("table").DataTable();

        if (areas.length == 0)
            dataTable.clear().draw();
        else {
            dataTable.clear();
            areas.map(area => {
                dataTable.row.add([
                    area.id_area,
                    area.area,
                    `<button id="${area.id_area}" class="btn btn-edit-area btn-strong-gray">
                        Editar
                    </button>
                    <button id="${area.id_area}" class="btn btn-delete-area btn-strong-red">
                        Apagar
                    </button>`
                ]).draw();
            });
        }
    }

    $(".btn-save").click(async () => {
        if ($("input[name=id_area]").val() == "") {
            sweetAlertAwait("Cadastrando área");
            const { icon, message } = await api.post("areas", { area: $("input[name=area]").val() });
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
            const { icon, message } = await api.patch("areas", {
                id_area: $("input[name=id_area]").val(),
                area: $("input[name=area]").val()
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
        $(".modal-title").html("Cadastrar Área");
    });

    $("tbody").on("click", ".btn-edit-area", async function() {
        sweetAlertAwait("Carregando dados da área");
        const area = await api.get(`areas?id=${$(this).attr("id")}`);
        swal.close();
        window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

        $("input[name=id_area]").val(area.id_area);
        $("input[name=area]").val(area.area);
        $(".modal-title").html("Editar Área");
        $(".modal").modal("show");
    });

    $("tbody").on("click", ".btn-delete-area", async function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir esta área?</h2>`,
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
                sweetAlertAwait("Excluindo área");
                const { icon, message } = await api.delete(`areas?id=${$(this).attr("id")}`);
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