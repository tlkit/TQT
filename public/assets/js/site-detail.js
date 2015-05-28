//
var product = new Array();
var flag = 0;

var update_view = $('#sys_update_view').val();

var _loadComment = 0;
var page_no = 1;
/*new*/
var product_id = $('#sys_product_id').val();
var product_name = $("#sys_product_name").val();
var product_img = $("#sys_product_img").val();
var product_sale_id = $('#sys_product_sale_id').val();
var product_type = $('#sys_product_type').val();
var count_cm =  $('#sys_count_cm').val();
var customer_key = $("#sys_customer_key").val();
var link_detail = $("#sys_link_detail").val();
var cachedProductImgId = [];
var cachedPopupImg = [];


$(document).ready(function () {
    window.history.pushState(null, null, link_detail);

    $("#sys_center_img").find(".cell-center").height($("#sys_center_img").width());
    $(window).on("resize",function(){
        $("#sys_center_img").find(".cell-center").height($("#sys_center_img").width());
    });
    $(".sys_open_popup_login").on("click",function(){
         data_order = $(this).attr('data-order');
        //if(order)
        //    customer.openPopupLogin(order);
        //else
            customer.openPopupInfo('Để mua hàng bạn cần đăng nhập');
    });

    $("#sys_xemthem").on("click",function(){
        detail.updateComment();
    });
    $("body").on("click",".sys_btn_reply_comment",function(){
        var id = $(this).attr('data-id');
        var receive = $(this).attr('data-receive-id');
        var parent = $(this).attr('data-parent-id');
        detail.replyComment(id,receive,parent);
    });

    var sys_list_products = $("#sys_list_products"),
        withSlideAvailable = sys_list_products.find(".viewport").width(),
        itemSlideWidth = 140,
        totalDealItem = sys_list_products.find("li").length;

    if(totalDealItem*itemSlideWidth > withSlideAvailable) {
        $("#sys_list_products").tinycarousel();
    }else{
        sys_list_products.find(".buttons").addClass("hidden");
    }

    // Zoom img
    $("#sys_dl_inner_grp_thumb").on('mouseover',".sys_show_img_big",function(){
        $(".sys_show_img_big").removeClass('active');
        $(this).addClass('active');
        var src = $(this).children("img").first().attr('data-img-big');
        $(".sys_img_big").prop({'src':src}).parent().attr("data-image-id",$(this).attr("data-image-id"));
    });
    $("#sys_col_list_thumb").on('mouseover',".sys_wrap_thumb_img",function(){
        $(this).trigger("click");
        $("#sys_img_zoom_place").parent().attr("data-image-id", $(this).attr("data-image-id"));
    });
    $("#sys_dl_col_list_thumb").on('mouseover',".sys_wrap_thumb_img",function(){
        $("#sys_dl_img_zoom_place").css("background-image",'url("'+$(this).attr("data-image")+'")').parent().attr("data-image-id", $(this).attr("data-image-id"));
    });
    $("#sys_img_zoom_place").elevateZoom({
        gallery: 'sys_col_list_thumb',
        galleryActiveClass: "active",
        //loadingIcon: BASE_URL + "/assets/images/loading.gif",
        zoomWindowPosition: "sys_placeholder_zoom",
        zoomWindowHeight: $("#sys_center_img").height(),
        zoomWindowWidth:$("#sys_placeholder_zoom").width(),
        borderSize: 0
    });
    /*$("#sys_dl_img_zoom_place").elevateZoom({
        gallery: 'sys_col_list_thumb',
        galleryActiveClass: "active",
        //loadingIcon: BASE_URL + "/assets/images/loading.gif",
        zoomWindowPosition: "sys_placeholder_zoom",
        zoomWindowHeight: $("#sys_dl_big_img_viewer").height(),
        zoomWindowWidth:$("#sys_placeholder_zoom").width(),
        borderSize: 0
    });*/
    $(".sys_show_img_big").on("click dbclick",function(){
        var wW=$(window).width(),
            wH=$(window).height(),
            configPaddingBodyToPopup = {top:30,left:30},
            configPaddingPopupToContent = 15,
            configBorderTransparentWidth = 7,
            contentHeight = (wH - 2 * configPaddingPopupToContent - 2 * configPaddingBodyToPopup.top - 2 * configBorderTransparentWidth);

        $.popupCommon({
            attrId:"sys_popup_show_img"
            ,extendClass: "popups-show-img"
            ,widthPop: (wW - 2 * configPaddingBodyToPopup.left)
            //,htmlContent: "<div style='background:red;height: " + (wH - 2 * configPaddingPopupToContent - 2 * configPaddingBodyToPopup.top - 2 * configBorderTransparentWidth) + "px;'><h2 class='rs'>hoang anh </h2></div>"
        });
        function initPopupViewProductImg(dataHtmlPopup) {
            $("#sys_popup_show_img").find(".main-content").html(dataHtmlPopup).end()
                .find(".sys_inner_thumb").parent().css("max-height", contentHeight).end().end()
                .find(".sys_big_column").find(".cell-center").height(contentHeight);

            $(".sys_inner_thumb").on("click", "img", function () {
                $(".sys_big_column").find("img").attr("src", $(this).attr("data-img-big"));
                $(this).addClass("active").siblings().removeClass("active");
            });
            $(".sys_next_big_img").on("click", function () {
                var imgActive = $(".sys_inner_thumb").find("img.active");
                (imgActive.next().length > 0) ? imgActive.next().trigger("click") : $(".sys_inner_thumb").find("img").first().trigger("click");
            });
        }
        var product_image_id = parseInt($(this).attr('data-image-id'));
        if(cachedProductImgId.indexOf(product_image_id)>=0) {
            initPopupViewProductImg(cachedPopupImg[cachedProductImgId.indexOf(product_image_id)])
        }else
            if(!sendingAjax){
                $.ajax({
                    type: "GET",
                    url: BASE_URL + "/product/image/" + product_id + "/" + product_image_id,
                    data: {
                        product_name: product_name
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        sendingAjax = true;
                    },
                    success: function (res) {
                        sendingAjax = false;
                        var dataHtmlPopup = res.html;
                        cachedProductImgId.push(product_image_id);
                        cachedPopupImg.push(dataHtmlPopup);
                        initPopupViewProductImg(dataHtmlPopup);
                    },
                    error:function(){
                        //alert("Có lỗi xảy ra.");
                        sendingAjax = false;
                    }
                });
            }
    });
    $("#sys_jumb_comment").on("click",function(){
        var getHeadHeight = $("#header").find(".top-head").outerHeight();
        $("html, body").animate({
            scrollTop: $("#sys_comments_area").offset().top - getHeadHeight
        },1000,function(){});
        return false;
    });

    var sys_deal_suggested_list = $("#sys_deal_suggested_list");
    /*$(window).on("scroll",function(){
        var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

    });*/


    //$.ajax({
    //    type: "GET",
    //    url: BASE_URL + "/product/suggest/" + product_sale_id ,
    //    dataType: 'json',
    //    beforeSend: function () {},
    //    success: function (res) {
    //        if(res.intIsOK!=-1) {
    //            if(res.size>0) {
    //                var suggestDataDetail = res.data;
    //                $("#sys_deal_suggested_list").addClass("active").removeClass("loading");
    //                initSlideSuggest("sys_deal_suggested_list",suggestDataDetail);
    //                $(window).on("resize",function(){
    //                    initSlideSuggest("sys_deal_suggested_list",suggestDataDetail);
    //                });
    //            }else{
    //                $("#sys_deal_suggested_list").hide();
    //            }
    //        }else{
    //            $("#sys_deal_suggested_list").hide();
    //        }
    //    },
    //    error: function () {
    //        //alert("Có lỗi xảy ra.");
    //    }
    //});

    if (update_view != 0) {
        setTimeout(function () {
            $.ajax({
                url:WEB_ROOT + 'product/updateView',
                data:{product_sale_id:product_sale_id},
                dataType:'json',
                type:'POST',
                beforeSend:function () {
                },
                complete:function () {
                },
                success:function (res) {
                }
            });
        }, 6000);
    }
    /*if(!document.referrer) {
        $("#sys_link_back").addClass("disabled").attr("href","javascript: return false;");
    }else
        $("#sys_link_back").removeClass("disabled").attr("href",document.referrer);*/

    $("#sys_show_more_thumb").on("click",function(){
        $(this).toggleClass("active");
        $(".sys_show_img_big.thumb-more").toggleClass("active-more");
    });


    var sys_tooltips_dl_note = $(".sys_tooltips_dl_note");
    if(sys_tooltips_dl_note.length>0) {
        sys_tooltips_dl_note.each(function(){
            var getTooltipContent = $(this).siblings(".sys_dl_note_content").html();
            $(this).tooltipster({
                trigger: 'click',
                content:$(getTooltipContent),
                minWidth: 300,
                maxWidth: 300,
                position:'bottom',
                interactive:true,
                theme: 'hoang-dai-ca'
            });
        });
    }
});

var detail = {
    createNewComment:function () {
        var content = $("#txt_question").val();
        $("#txt_question").val('');
        if (content == '') {
            alert('Bạn chưa nhập nội dung bình luận');
            return false;
        }
        $.post(
            WEB_ROOT + "/comment/create",
            {
                content:content,
                product_id:product_id,
                product_sale_id:product_sale_id
            },
            function (data) {
//                //console.log(data)
                $("#txt_question").val('');
                $(".list-comment").prepend(data.html);
                $(".sys_box_reply").addClass('hidden');
                temp_comment = parseInt(temp_comment) + 1;
                count_cm = parseInt(count_cm) + 1;
                $("#sys_count_all_cm").html('Có ' + count_cm + ' bình luận');
                alert("Cảm ơn bạn đã gửi phản hồi cho MuaChungPlaza !")
            },
            'json'
        );
    },

    replyComment:function (id, receive_id, parent_id) {
        var content = $("#txt_question_" + id).val();
        $("#txt_question_" + id).val('');
        if (content == '') {
            alert('Bạn chưa nhập nội dung bình luận');
            return false;
        }
        $.post(
            BASE_URL + "/comment/reply",
            {
                id:id,
                product_id:product_id,
                product_sale_id:product_sale_id,
                content:content,
                receive_id:receive_id

            },
            function (data) {
                $("#txt_question_" + id).val('');
                $("#sys_wrap_reply_" + parent_id).prepend(data.html);
                $(".sys_box_reply").addClass('hidden');
                count_cm = parseInt(count_cm) + 1;
                $("#sys_count_all_cm").html('Có ' + count_cm + ' bình luận');
                alert("Cảm ơn bạn đã gửi phản hồi cho MuaChungPlaza !")
            },
            'json'
        );
    },

    updateComment:function () {
        var limit = 5;
        var page = page_no
        page = parseInt(page) + 1;
        //$('#sys_page_no').val(page_no);
        if (!sendingAjax) {
            $.ajax({
                type:"POST",
                url:BASE_URL + "/comment/load",
                data:{
                    product_id:product_id,
                    product_sale_id:product_sale_id,
                    page_no:page,
                    limit:limit,
                    temp:temp_comment
                },
                dataType:'json',
                beforeSend:function () {
                    sendingAjax = true;
                    $("#sys_xemthem").addClass("disabled");
                },
                success:function (res) {
                    sendingAjax = false;
                    $("#sys_xemthem").removeClass("disabled");
                    $("#sys_list_comment").append(res.html);
                    if (parseInt(page) * limit >= res.size) {
                        $('#sys_xemthem').addClass('hidden');
                    }else{
                        $('#sys_xemthem').removeClass('hidden');
                    }
                    page_no = page;
                    count_cm = res.count;
                    $("#sys_count_all_cm").html('Có ' + count_cm + ' bình luận');
                }
            });
        }

    }
};