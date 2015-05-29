$(document).ready(function(){
    $('.sys_input_chk').on('change',function(){
        $('#search_deal').submit();
    });
    /*$(".sys_other_cate").on("click",function(){
        $(this).toggleClass("active");
        $(this).next().slideToggle();
    });*/
    $(".sys_unset_price").on('click',function(){
        var id = $(this).attr('data-id');
        $("#sys_content_price_"+id).prop('checked', false);
        $('#search_deal').submit();
    })
});

function unsetPrice(){
    $('input[name="grp_price"]').prop('checked', false);
    $('#search_deal').submit();
}

var flag = 1;
var page = 2;
var noAjax = 0;
var cat_parent = $('input[name="cat_parent"]').val();
$(window).scroll(function () {
    if ($(document).height() <= $(window).scrollTop() + $(window).height() + 400) {
        if (window.flag == 1 && window.noAjax == 0 && page < 3) {
            list.callAjaxLoadData();
        }
        return false;
    }
});


var list = {
    callAjaxLoadData:function(){
        $("#sys_icon_load").removeClass('hidden');
        $("#sys_view_more").addClass('hidden');
        var category = $('input[name="grp_cate"]').val();
        var price_save = $('input[name="grp_price"]:checked').val();
        var sort_by = $('input[name="grp_sort"]').val();
        $.ajax({
            type:"POST",
            url:BASE_URL + "/list/loadDeal",
            data:{
                page:window.page,
                cat_parent:cat_parent,
                category:category,
                price_save:price_save,
                sort_by:sort_by
            },
            beforeSend:function () {
                window.flag = 0;
            },
            success:function (data) {
                $("#sys_mod_home_list_deal").append(data.html);
                $("#sys_mod_home_list_deal").find(".sys_countdown").each(function () {
                    var arrDateData = $(this).attr("data-times").split(",");
                    var destDay = new Date(arrDateData[0], arrDateData[1] - 1, arrDateData[2], arrDateData[3], arrDateData[4], arrDateData[5]);
                    $(this).countdown({
                        until:destDay,
                        layout:'{dn} <span>{dl}</span> {hnn}{sep}{mnn}{sep}{snn}s'
                    });
                });

                window.flag = 1;
                var full = parseInt(window.page) * 30
                if (full >= data.size) {
                    window.noAjax = 1;
                }
                window.page++;
                if(page >= 3 && noAjax == 0){
                    $("#sys_view_more").removeClass('hidden');
                }
                $("#sys_icon_load").addClass('hidden');
            }
        }, "json");
    },
    loadNewData:function(){
        if (flag == 1 && noAjax == 0) {
            list.callAjaxLoadData();
        }
        return false;
    }
}