/**
 * User: tuanna
 * Date: 9/13/14
 * Time: 6:36 AM
 */
sendingAjax = false;
$(function(){
    $(".sys_load_comment_shop").on('click',function(){
        var $this = $(this);
        var campaign_id = $(this).attr('data-id');
        var limit = 50;
        var page_no = 1;
        if (!sendingAjax) {
            $.ajax({
                type:"POST",
                url:BASE_URL + "/comment/load",
                data:{
                    campaign_id:campaign_id,
                    page_no:page_no,
                    limit:limit
                },
                dataType:'json',
                beforeSend:function () {
                    sendingAjax = true;
                    $this.addClass("disabled");
                },
                success:function (res) {
                    sendingAjax = false;
                    $this.removeClass("disabled");
                    $("#sys_show_comment_" + campaign_id).addClass('hidden');
                    if (res.html != '') {
                        $("#sys_list_comment_" + campaign_id).append(res.html);
                        $("#sys_hidden_comment_" + campaign_id).removeClass('hidden');
                        $(".reply").css('display','none');
                        $(".sep").css('display','none');
                    } else {
                        $("#sys_list_comment_" + campaign_id).html("Không có bình luận nào");
                    }
                }
            });
        }
    });

    $(".sys_hidden_comment_shop").on('click', function () {
        var campaign_id = $(this).attr('data-id');
        $("#sys_show_comment_" + campaign_id).removeClass('hidden');
        $("#sys_list_comment_" + campaign_id).html("");
        $("#sys_hidden_comment_" + campaign_id).addClass('hidden');
    });

    $('.sys_input_chk').on('change', function () {
        $('#search_deal').submit();
    });
})


function unsetPrice() {
    $('input[name="grp_price"]').prop('checked', false);
    $('#search_deal').submit();
}
function unsetCategory() {
    $('input[name="grp_cate"]').prop('checked', false);
    $('#search_deal').submit();
}
