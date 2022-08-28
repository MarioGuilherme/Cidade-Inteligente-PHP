$(document).ready(() => {
    setDataTable();

    const resetDataTable = async () => {
        const users = await api.get("users");
        const dataTable = $("table").DataTable();

        if (users.length == 0)
            dataTable.clear().draw();
        else {
            dataTable.clear();
            users.map(user => {
                dataTable.row.add([
                    user.id_user,
                    user.name,
                    user.email,
                    user.course,
                    user.isAdmin == 1 ? `<i class="mdi mdi-check-bold mdi-24px text-success"></i>` : `<i class="mdi mdi-close-thick mdi-24px text-danger"></i>`,
                    `<button id="${user.id_user}" class="btn btn-edit-user btn-strong-gray">
                        Editar
                    </button>
                    <button id="${user.id_user}" class="btn btn-delete-user btn-strong-red">
                        Apagar
                    </button>`
                ]).draw();
            });
        }
    }

    $(".btn-save").click(async () => {
        if ($("input[name=id_user]").val() == "") {
            formHasEmptyField($("form").serializeArray().slice(1, -1));

            if ($($("input[type=password")[0]).val() != $($("input[type=password")[1]).val()) {
                sweetAlert("error", "As senhas não conferem");
                return;
            }

            (async () => {
                sweetAlertAwait("Cadastrando usuário");
                const { icon, message } = await api.post("users", {
                    name: $("input[name=name]").val(),
                    email: $("input[name=email]").val(),
                    password: $("input[name=password]").val(),
                    type: $("select[name=type]").val(),
                    id_course: $("select[name=id_course]").val(),
                    isAdmin: $("select[name=isAdmin]").val()
                });
                window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

                if (icon == "success") {
                    await resetDataTable();
                    sweetAlert(icon, message);
                    cleanAllFields();
                    $(".modal").modal("hide");
                } else
                    sweetAlert(icon, message);
            })();
        } else {
            sweetAlertAwait("Salvando alterações");
            const { icon, message } = await api.patch("users", {
                id_user: $("input[name=id_user]").val(),
                name: $("input[name=name]").val(),
                email: $("input[name=email]").val(),
                type: $("select[name=type]").val(),
                id_course: $("select[name=id_course]").val(),
                isAdmin: $("select[name=isAdmin]").val()
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
        $("div.passwordInputs").show();
        cleanAllFields();
        $(".modal-title").html("Cadastrar Usuário");
    });

    $("tbody").on("click", ".btn-edit-user", async function() {
        window.onbeforeunload = () => true; // Ativa o alert de confirmação de saída
        sweetAlertAwait("Carregando dados do usuário");
        const user = await api.get(`users?id=${$(this).attr("id")}`);
        swal.close();
        window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída

        $("input[name=id_user]").val(user.id_user);
        $("input[name=name]").val(user.name);
        $("input[name=email]").val(user.email);
        $("select[name=id_course]").val(user.id_course);
        $("select[name=isAdmin]").val(user.isAdmin);
        $(".modal-title").html("Editar Usuário");
        $("div.passwordInputs").hide();
        $(".modal").modal("show");
    });

    $("tbody").on("click", ".btn-delete-user", async function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este Usuário?</h2>`,
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
                window.onbeforeunload = () => true; // Ativa o alert de confirmação de saída
                sweetAlertAwait("Excluindo usuário");
                const { icon, message } = await api.delete(`users?id=${$(this).attr("id")}`);
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