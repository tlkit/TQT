$(document).ready(function () {
    var category_id = $('#sys_category_id').val();
    var product_id = $('#sys_product_id').val();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: WEB_ROOT + "loadReportRatting",
        data: {category_id: category_id, product_id: product_id},
        beforeSend: function () {
        },
        success: function (res) {
            if(res.isIntOk == 1) {
                $('#show_report_ratting').html(res.html);
            }

            if($(".no-mc-rate").length>0) {
                var tmpW = 0;
                $(".op-rated-lbl").each(function(){
                    tmpW = ($(this).width() >= tmpW) ? $(this).width() : tmpW;
                }).width(tmpW);
            }

            var sys_star_to_make_rate_sm = $(".sys_star_to_make_rate_sm");
            sys_star_to_make_rate_sm.on("mouseenter",function(){
                var idx = $(this).index();
                $(this).addClass("checked");//.parents(".option-item-rated").find(".op-rated-score").hide().end().find(".sys_rate_option_score").removeClass("checked").eq(idx).addClass("checked");
                $(this).siblings().each(function(){
                    if($(this).index()<idx) {
                        $(this).addClass("checked");
                    }else{
                        $(this).removeClass("checked");
                    }
                });
            }).on("click",function(){
                    var idx = $(this).index();
                    var getUid= $(this).parent().attr("data-uid");
                    var getCriteriaIdx = $(this).parents(".option-item-rated").attr("data-criteria-idx");
                    if(getUid==0) {
                        customer.openPopupLogin();
                    }else{
                        customer.openPopupRatting();
                        if(getCriteriaIdx == 0) getCriteriaIdx = -1;
                        $("#sys_rate_cus_" + getCriteriaIdx).find(".sys_star_em_for_rate").eq(idx).trigger("click");
                    }
                });
            $("#sys_btn_write_review").on("click",function(){
                customer.openPopupRatting();
            });

            $(".sys_star_to_make_rate_sm").tooltipster({
                delay: 0,
                theme: "theme-rate-tip",
                speed: 0
            });
        },
        error: function () {
        }
    });
    customer.loadRatting();

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: WEB_ROOT + "loadComment",
        data: {product_id: product_id},
        beforeSend: function () {
        },
        success: function (res) {
            $('#show_content_comment').html(res.html);

            $("#sys_list_comment").on('click', ".reply", function () {
                var id = $(this).attr('data-id');
                $('#txt_question_'+id).val('');
                $('#txt_question_'+id).elastic().height("18px");
                $(this).parents(".sys_comment_item").find("#form_reply_" + id).toggle();

            });

            $("#sys_create_new_comment").on("click",function(){
                detail.createNewComment();
            });

        },
        error: function () {
        }
    });


});