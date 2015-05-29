var BASE_URL = window.location.origin;
var temp_comment = 0;
$(document).ready(function () {
    //$("#sys_list_comment").on('click', ".reply", function () {
    //    var id = $(this).attr('id');
    //    $(this).parents(".sys_comment_item").find("#form_" + id).toggle();
    //});
    $("#sys_unlike").on("click",function(e){e.stopPropagation();});
    $("#sys_extent_unlike").on("click",function(e){
        var $this = $(this);
        $this.parent().toggleClass("active");
        $("body").on("click.hideExtent",function(){
            $this.parent().removeClass("active");
            $("body").off("click.hideExtent");
        });
        e.stopPropagation();
    });
});
var oRDLog4MC = {
    visit: function (oData) {
        //alert(JSON.stringify(oData));
        try {
            _MA.run('mc_visit', oData);
        } catch (e) {
        }
    },

    checkout: function (oData) {
        try {
            oData.tracking = 1;
            _MA.run('mc_tran', oData);
        } catch (e) {
        }
    }
}
var site = {
    follow:function () {
        var supplier = $("input#sys_supplier_id").val();
        var dataString = 'supplier=' + supplier;
        $.ajax({
            type:"POST",
            url:BASE_URL + "/shop/createLike",
            data:dataString,
            success:function (data) {
                if (data.code = 200 && data.intIsOK == 1) {
                    $("#sys_like").addClass('hidden');
                    $("#sys_unlike").removeClass('hidden active');
                }
            }
        }, "json");
        return false;
    },
    unFollow:function () {
        var supplier = $("input#sys_supplier_id").val();
        var dataString = 'supplier=' + supplier;
        $.ajax({
            type:"POST",
            url:BASE_URL + "/shop/unLike",
            data:dataString,
            success:function (data) {
                if (data.code = 200 && data.intIsOK == 1) {
                    $("#sys_unlike").addClass('hidden').removeClass("active");
                    $("#sys_like").removeClass('hidden');
                }
            }
        }, "json");
        return false;
    },
    createLikeById:function (id) {
        var dataString = 'supplier=' + id;
        $.ajax({
            type:"POST",
            url:BASE_URL + "/shop/createLike",
            data:dataString,
            success:function (data) {
                if (data.code = 200 && data.intIsOK == 1) {
                    alert('Thành công');
                    $("#sys_like_" + id).addClass('hidden');
                    $("#sys_unlike_" + id).removeClass('hidden').addClass('active');
                }
            }
        }, "json");
        return false;
    },
    unLikeById:function (id) {
        var dataString = 'supplier=' + id;
        $.ajax({
            type:"POST",
            url:BASE_URL + "/shop/unLike",
            data:dataString,
            success:function (data) {
                if (data.code = 200 && data.intIsOK == 1) {
                    alert('Thành công');
                    $("#sys_unlike_" + id).addClass('hidden');
                    $("#sys_like_" + id).removeClass('hidden');
                }
            }
        }, "json");
        return false;
    },
    updateCommentSupplier:function (products_id, campaign_product) {
        var limit = 5;
        var page_no = $('#sys_page_no_' + products_id).val();
        page_no = parseInt(page_no) + 1;
        $('#sys_page_no_' + products_id).val(page_no);
        $.post(
            BASE_URL + "/supplier/comment/load",
            {
                products_id:products_id,
                campaign_product:campaign_product,
                page_no:page_no,
                limit:limit


            },
            function (data) {
                $(".sys_list_comment_" + products_id).append(data.html);
                if (data.html != "") {
                    $('#sys_an_' + products_id).removeClass('hidden');
                }
                if (parseInt(page_no) * limit > data.size) {
                    $('#sys_xemthem_' + products_id).addClass('hidden');
                }
//                console.log(data);
//                if (data.code == 200 && data.intIsOK == 1) {
//                $("#txt_question_" + id).val('');
//                $("#sys_wrap-reply_"+parent_id).prepend(data.html);
//                $(".sys_box_reply").addClass('hidden');
//                    alert('Cảm ơn bạn đã gửi bình luận cho mua chung về sản phẩm này')
//                } else {
//                    alert('Có lỗi khi gửi bình luận của bạn xin vui lòng thử lại sau')
//                }
            },
            'json'
        );

    },
    hiddenComment:function(products_id){
        $('#sys_an_' + products_id).addClass('hidden');
        $('#sys_page_no_' + products_id).val(0);
        $(".sys_list_comment_" + products_id).html('');
        $('#sys_xemthem_' + products_id).removeClass('hidden');
    },
    createEmailSubcrice: function() { //Tao email subcrice
        var email = $('#sys_email_subcrice').val();
        if(email == '') {
            alert('Bạn vui lòng nhập email');
        } else if(!LibJS.is_email(email)) {
            alert('Định dạng email không đúng');
        } else {
            $.ajax({
                url: WEB_ROOT + 'createSubcrice',
                data: {email: email},
                dataType: 'json',
                beforeSend: function() {
                    $('#sys_email_subcrice').css('background-color','#ccc');
                },
                complete: function() {
                    $('#sys_email_subcrice').css('background-color','#fff');
                },
                success: function(res) {
                    if (res.intIsOK == 1) {
                        alert('Bạn đã đăng ký thành công để nhận thông tin khuyến mãi mỗi ngày!');
                        $('#sys_email_subcrice').val('');
                    } else if(res.intIsOK == 0) {
                        alert('Email của bạn đã được đăng ký để nhận thông tin khuyến mãi mỗi ngày!');
                    } else {
                        alert('Địa chỉ email không hợp lệ.');
                    }
                }
            });


        }
    }

};