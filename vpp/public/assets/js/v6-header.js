/**
 * User: hoangnm
 * Date: 11/18/2014
 * Time: 4:41 PM
 */

var location_select = 0;
var splitCate = false;
$(function(){

    var sys_header_grp_cate_link = $("#sys_header_grp_cate_link"),
        subCateW = sys_header_grp_cate_link.width();

    sys_header_grp_cate_link.find(".cate-link").each(function(){
        var positionLink = $(this).position().left + $(this).outerWidth();
        if(splitCate) {
            $(this).clone().removeClass("cate-link").addClass("new-cate-link").appendTo("#sys_panel_extend_cate");
        }else
            if(positionLink > subCateW) {
                splitCate = true;
                $("#sys_extend_cate_link").addClass("active");
                var lblW = $("#sys_extend_cate_link").position().left + $("#sys_extend_cate_link").outerWidth(true);
                if(lblW > subCateW){
                    $("#sys_header_grp_cate_link").children().first().css("padding-right", $("#sys_extend_cate_link").outerWidth(true));
                }
                $(this).clone().removeClass("cate-link").addClass("new-cate-link").appendTo("#sys_panel_extend_cate");
            }
    });

    $("#frmSearch").on("submit",function(){
        var keyword = $('#sys_txt_keyword_s').val();
        if (keyword == '' || keyword == undefined) {
            alert('Bạn vui lòng nhập từ khóa để tìm kiếm.');
            return false;
        }else{
            return true;
        }
    });

    /*Mo popup chon tinh thanh khi chua chon*/
    var ck_location = $.cookie('muachung_cityMC');
    if(!ck_location){
        var popupLocationContent = $("#popupTQ").html();
        $("#popupTQ").html("");
        var settingPopupLocationId = "sys_popup_location";
        $.popupCommon({
            attrId: settingPopupLocationId,
            widthPop: 640,
            extendClass: "popup-choose-location",
            htmlContent: popupLocationContent,
            overlayClickHide:false,
            successOpen: function () {
                $("#" + settingPopupLocationId).find(".opacity-border").hide().end().find(".closePopup").hide();
            },
            preClose: function () {
                settingPopupLocationId = null;
            }
        });
    };

    $(".popCityID").on('click',function(){
        if($(".popCityList").hasClass('hidden'))
            $(".popCityList").removeClass('hidden');
        else
            $(".popCityList").addClass('hidden');
    });
    //$(".popCityID").on('mouseout', function () {
    //    $(".popCityList").addClass('hidden');
    //});
    $(".sys_change_location").on('click',function(){
        var t = $(this).attr('data-name');
        location_select = parseInt($(this).attr('data-id'));
        $(".popCityValue").html(t);
        $(".popCityList").addClass('hidden');
        return false;
    })

    $.ajax({
        type: "GET",
        url: BASE_URL + "/getCategoryMC",
        data: {},
        dataType: 'json',
        beforeSend: function () {
        },
        success: function (res) {
            if (res.intIsOK == 1) {
                $("#sys_cate_mc").html(res.html);
                $("#sys_footer_mc").html(res.html1);
            }
        },
        error: function () {
        }
    });


    $("#sys_icon_search_sb").on("click",function(e){
        $(this).toggleClass("active");
        $("#sys_wrap_right_sb").toggleClass("active");
        $("#sys_location_selection").toggleClass("active");
        $("#sys_txt_keyword_s").focus();
        $("body").on("click.closeBoxSearch",function(){
            $("#sys_icon_search_sb").removeClass("active");
            $("#sys_location_selection").removeClass("active");
            $("#sys_wrap_right_sb").removeClass("active");
            $("body").off("click.closeBoxSearch");
        });
        e.stopPropagation();
    });
    $("#sys_wrap_right_sb").on("click",function(e){
        e.stopPropagation();
    });
});
function loadLocation(value) {
    $.cookie('muachung_cityMC',value,{expires: 30,path: '/', domain: COOKIE_DOMAIN});
    window.location.reload();
}
function setLocationPopup(){

    //var location = $('#sys_location_plaza').val();
    //alert(location);return false;
    if (location_select != 0) {
        $.cookie('muachung_cityMC', location_select, {expires: 30,path: '/', domain: COOKIE_DOMAIN});
        window.location.reload();
    }else{
        alert('Quý khách vui lòng chọn tỉnh/Thành phố');
        return false;
    }
}
function cityPopSelect(value){

}