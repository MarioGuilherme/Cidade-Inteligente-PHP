$(document).ready(() => {
    $(".btn-delete-project").click(function() {
        Swal.fire({
            html: `<h2 style="color: white;">Deseja mesmo excluir este projeto?</h2>`,
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
                sweetAlertAwait("Apagando projeto");
                const { icon, message } = await api.delete(`projects?id=${$(this).attr("id")}`);
                window.onbeforeunload = () => {}; // Desativa o alert de confirmação de saída
                sweetAlert(icon, message);

                if (icon == "success") {
                    $(this).parents("div.col-12").hide(500);
                    setTimeout(() => {
                        $(this).parents("div.col-12").remove();
                        if ($(".myProjects").find("div.col-12").length == 0 && $(".pages").find("a").length == 0) // Se não mais projetos nestá única página, aparece uma mensagem de que não há projetos
                            $(".myProjects").html("<h3 class='text-center'>Você não está participando de nenhum projeto ainda.</h3>");

                        if ($(".myProjects").find("div.col-12").length == 0 && $(".pages").find("a").length > 0) // Se não hour mais projetos nesta página, vai para a página anterior
                            [...$(".pages a")].at(-1).click();
                    }, 500);
                }
            }
        });
    })
});