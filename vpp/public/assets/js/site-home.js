/**
 * Created with JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 8/8/14
 * Time: 3:25 PM
 * To change this template use File | Settings | File Templates.
 */
var flag = 1;
var page = 2;
var noAjax = 0;
$(window).scroll(function () {
    // var html = $('#sys_list_deal').html();
    //console.log($(document).height());
    //        console.log($(window).scrollTop() + $(window).height() + 2000);
    if ($(document).height() <= $(window).scrollTop() + $(window).height() + 2000) {

        if (window.flag == 1 && window.noAjax == 0) {
            home.callAjaxLoadData();
        }
        return false;
    }
});
$(document).ready(function () {
    //$(".sys_sort_home").on('change', function () {
    //    var sort = $("#sort_options").val();
    //    $.ajax({
    //        url:WEB_ROOT + 'sortHome',
    //        data:{sort_by:sort},
    //        dataType:'json',
    //        beforeSend:function () {
    //
    //        },
    //        complete:function () {
    //
    //        },
    //        success:function (res) {
    //            if (res.isIntOK == 1) {
    //                window.location.reload();
    //            }
    //        }
    //    });
    //})
})
var home = {
    callAjaxLoadData:function () {
        $("#sys_icon_load").removeClass('hidden');
        //$("#sys_view_more").addClass('hidden');
        $.ajax({
            type:"POST",
            url:BASE_URL + "/home/loadDeal",
            data:{
                page:page
            },
            beforeSend:function () {
                flag = 0;
            },
            success:function (data) {
                $("#sys_list_deal").append(data.html);
                //$("#sys_mod_home_list_deal").find(".sys_countdown").each(function () {
                //    var arrDateData = $(this).attr("data-times").split(",");
                //    var destDay = new Date(arrDateData[0], arrDateData[1] - 1, arrDateData[2], arrDateData[3], arrDateData[4], arrDateData[5]);
                //    $(this).countdown({
                //        until:destDay,
                //        layout:'{dn} <span>{dl}</span> {hnn}{sep}{mnn}{sep}{snn}s'
                //    });
                //});

                flag = 1;
                var full = parseInt(page) * 25
                if (full >= data.size) {
                    noAjax = 1;
                }
                window.page++;
                //if (page >= 3 && noAjax == 0) {
                //    $("#sys_view_more").removeClass('hidden');
                //}
                $("#sys_icon_load").addClass('hidden');
            }
        }, "json");
    },
    loadNewData:function(){
        if (flag == 1 && noAjax == 0) {
            home.callAjaxLoadData();
        }
        return false;
    }
}


