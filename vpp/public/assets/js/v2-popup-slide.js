update_view = 0;
$(function () {
    $(".sys_view_deal_relate").on("click",function(){
        if($(window).width() >= 1024) {
            var campaign_product_id = $(this).attr('data-id');
            PopupSlide.initPopup(campaign_product_id);
            return false;
        }
        return true;
    });

    var campaign_product_id = $.cookie('ck_campaign_products_id_slide');
    var s_supplier_id = $.cookie('ck_supplier_id_slide');
    var s_statusBuySlide = $.cookie('ck_status_buy_slide');
    var s_buy_product = $.cookie('ck_campaign_type_slide');

    if(s_statusBuySlide == 1) {
        Cart.config.price = $.cookie('ck_product_price_slide');
        product_name = $.cookie('ck_product_name_slide');
        $.cookie('ck_status_buy_slide', 0 , {path: '/', domain: COOKIE_DOMAIN});
        $.ajax({
            url:WEB_ROOT + 'home/orderStep1',
            data:{
                supplier_id:s_supplier_id
            },
            dataType:'json',
            beforeSend:function () {
                sendingAjax = true;
            },
            success:function (res) {
                sendingAjax = false;
                frameStep1 = res.step1;
                frameStep2_1 = res.step21;
                frameStep2_2 = res.step22;
                frameStep3 = res.step3;

                frameCouponStep1 = res.step_coupon_1;
                frameCouponStep2_1 = res.step_coupon_2_1;
                frameCouponStep2_2 = res.step_coupon_2_2;
                frameCouponStep3 = res.step_coupon_3;
                frameCouponStep4 = res.step_coupon_4;

                frameProductStep1 = res.step_product_1;
                frameProductStep2_1 = res.step_product_2_1;
                frameProductStep2_2 = res.step_product_2_2;
                frameProductStep2_3 = res.step_product_2_3;
                frameProductStep3 = res.step_product_3;
                frameProductStep4 = res.step_product_4;
                if (s_buy_product == 1) {
                    //Cart.start(1);
                    Cart.order_step_product_1(false, false);
                } else {
//                    Cart.start();
                    Cart.order_step_1(false, false);
                }
            },
            error:function () {
                sendingAjax = false;
            }
        });
    }
});

var PopupSlide = {
    initPopup:function(campaign_product_id,idPopupParent) {
        if(!idPopupParent) {
            idPopupParent = "sys_popup_slide_show";
            $.popupCommon({
                htmlContent:$("#sys_frame_popup_slide").html(),
                extendClass: "popup-slide-show",
                widthPop: "914px",
                attrId:idPopupParent,
                successOpen:function(){},
                preClose:function(){
                    $("#sys_hidden_data_deal").html("");
                }
            });
        }

        var sys_popup_slide_show = $("#" + idPopupParent);
        $.ajax({
            url:WEB_ROOT + 'home/detailProduct',
            data:{
                id:campaign_product_id
            },
            dataType:'json',
            success:function (res) {
                sys_popup_slide_show.find(".main-content").html(res.html);
                $("#sys_hidden_data_deal").html(res.hiddenData);
                product_id = $("#sys_products_id_popup").val();
                product_name = $("#sys_product_name_" + product_id).val();
                product_img = $("#sys_product_img_" + product_id).val();
                var buy_product = $("#sys_product_campaign_type_" + product_id).val();
                Cart.config.price = $("#sys_price_" + product_id).val();

                $("#buy_number_in_popup").on("change",function(){
                    $('#buy_number_' + product_id).val($(this).val());
                });
                $(".xxxDropdown").xxxDropdown();
                //CloudZoom.quickStart();
                sys_popup_slide_show.find(".sys_loading_deal").addClass("hide-elem");
                if ($("#sys_popup_relate_deal").length > 0) {
                    if ($("#sys_popup_relate_deal").find("li").length > 7)
                        $("#sys_popup_relate_deal").tinycarousel();
                    else
                        $("#sys_popup_relate_deal").find(".buttons").remove();
                }
                // set height for description area
                var sys_wrap_viewer_img = $("#sys_wrap_viewer_img"),
                    sys_deal_name = $("#sys_deal_name"),
                    sys_deal_desc = $("#sys_deal_desc"),
                    sys_grp_bottom_price = $("#sys_grp_bottom_price");
                var setMaxHeight = sys_wrap_viewer_img.outerHeight() - sys_deal_name.outerHeight() - sys_grp_bottom_price.outerHeight();
                sys_deal_desc.css("height", setMaxHeight);

                $("body").find(".sys_btn_order_in_slide").on("click", function () {
                    var $this = $(this);
                    var supplier_id = $(this).attr('data-id');
                    if (!sendingAjax) {
                        $.ajax({
                            url:WEB_ROOT + 'home/orderStep1',
                            data:{
                                supplier_id:supplier_id
                            },
                            dataType:'json',
                            beforeSend:function () {
                                sendingAjax = true;
                                $this.addClass("disabled");
                            },
                            success:function (res) {
                                sendingAjax = false;
                                $this.removeClass("disabled");
                                frameStep1 = res.step1;
                                frameStep2_1 = res.step21;
                                frameStep2_2 = res.step22;
                                frameStep3 = res.step3;

                                frameCouponStep1 = res.step_coupon_1;
                                frameCouponStep2_1 = res.step_coupon_2_1;
                                frameCouponStep2_2 = res.step_coupon_2_2;
                                frameCouponStep3 = res.step_coupon_3;
                                frameCouponStep4 = res.step_coupon_4;

                                frameProductStep1 = res.step_product_1;
                                frameProductStep2_1 = res.step_product_2_1;
                                frameProductStep2_2 = res.step_product_2_2;
                                frameProductStep2_3 = res.step_product_2_3;
                                frameProductStep3 = res.step_product_3;
                                frameProductStep4 = res.step_product_4;

                                if (buy_product == 1) {
                                    Cart.order_step_product_1(false, true, idPopupParent);
                                } else {
                                    Cart.order_step_1(false, true, idPopupParent);
                                }
                            },
                            error:function () {
                                sendingAjax = false;
                                $this.removeClass("disabled");
                                $this.siblings(".error-log").removeClass("hide-elem");
                            }
                        });
                    }
                });
                $("#sys_btn_login_slide").on("click",function(){
                    var campaign_products_id = $(this).attr('data-campaign-product-id');
                    var supplier_id = $(this).attr('data-id');
                    var product_id = $(this).attr('data-value');
                    var campaign_type = $(this).attr('data-campaign-type');
                    var amount = $('#buy_number_in_popup').val();
                    var product_price = $("#sys_price_" + product_id).val();
                    var product_name = $("#sys_product_name_" + product_id).val();

                    $.cookie('ck_campaign_products_id_slide', campaign_products_id , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_supplier_id_slide', supplier_id , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('product_id', product_id , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_campaign_type_slide', campaign_type , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_status_buy_slide', 1 , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_amount_buy_slide', amount , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_product_price_slide', product_price , {path: '/', domain: COOKIE_DOMAIN});
                    $.cookie('ck_product_name_slide', product_name , {path: '/', domain: COOKIE_DOMAIN});

                    customer.openPopupLogin(true, idPopupParent);
                });
                $("#sys_next_img_zoom_slide").on("click",function(){
                    var thumbCurrent = $(".sys_thumb_img_slide_popup.active");
                    var thumbNext = (thumbCurrent.next().length > 0) ? thumbCurrent.next() : $(".sys_thumb_img_slide_popup").first();
                    $("#sys_img_zoom_slide").attr({
                        "src": thumbNext.attr("data-img-small"),
                        "data-cloudzoom": "zoomImage:'" + thumbNext.attr("data-img-origin") + "',zoomPosition:'inside',zoomOffsetX:0 "
                    });
                    $(".sys_thumb_img_slide_popup").removeClass("active");
                    thumbNext.addClass("active");
                    //CloudZoom.quickStart();
                });
                $(".sys_thumb_img_slide_popup").on("click",function(){
                    if(!$(this).hasClass("active")) {
                        $("#sys_img_zoom_slide").attr({
                            "src": $(this).attr("data-img-small"),
                            "data-cloudzoom": "zoomImage:'" + $(this).attr("data-img-origin") + "',zoomPosition:'inside',zoomOffsetX:0 "
                        });
                        $(this).addClass("active").siblings().removeClass("active");
                        //CloudZoom.quickStart();
                    }
                });

                $(".sys_thumb_relate_deal").on("click",function(){
                    $(this).find(".sys_loading").removeClass("hide-elem");
                    PopupSlide.initPopup($(this).attr("data-id"),$(this).parents(".popup-common").attr("id"));
                    //console.log("ajax naof: " +$(this).attr("data-id"));
                });
            },
            error:function () {
                sys_popup_slide_show.find(".sys_loading_deal").children("p").removeClass("hide-elem").siblings().addClass("hide-elem");
            }
        });
    }
};
