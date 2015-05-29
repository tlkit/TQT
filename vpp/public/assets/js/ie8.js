$(function () {
    if ($(".sys_input_chk").length > 0) {
        $(".sys_input_chk").each(function(){
            if($(this).is(":checked"))
                $(this).siblings("i").addClass("active");
            else
                $(this).siblings("i").removeClass("active");
        });
    }
    $(".sys_input_chk,.input-chk").on("change", function () {
        console.log("11111111");
        if($(this).is(":checked"))
            $(this).siblings("i").addClass("active");
        else
            $(this).siblings("i").removeClass("active");
    });
});
