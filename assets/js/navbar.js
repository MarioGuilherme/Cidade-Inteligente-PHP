$("#dropDownRegister, #dropDownAdmin, #dropDownProject").click(function(e) {
    if ($(this).find("i").hasClass("fa-chevron-up")) {
        $(".dropdown").find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
        $(this).find("i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
    } else
        $(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
});

$(".dropdown-menu").click(e => e.stopPropagation());