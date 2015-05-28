$(document).ready(function(){
    $('#start_time').datepicker({});
    $('#end_time').datepicker({});
});
var linkAdmin = '';
var comment = {
    cfg: {
        product_comment_id: 0,
        product_id: 0,
        product_comment_receiver_id: 0,
        product_comment_receiver_name: '',
        product_comment_receiver_email: ''
    },
    updateStatusComment: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusComment = document.getElementById('sys_urlAjaxUpdateStatusComment').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusComment,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_comment_'+id).html('');
                        $('#sys_status_comment_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                    $('#img_loading_status_'+id).hide();
                }
            });
        }
    },

    updateDelFlag: function(id,flag){
        if(id > 0){
            $('#sys_del_'+id).attr('disabled', true);
            $('#img_loading_del_'+id).show();
            var urlAjaxDeleteComment = document.getElementById('sys_urlAjaxDeleteComment').value;
            $.ajax({
                type: "POST",
                url: urlAjaxDeleteComment,
                data: {id : id, flag: flag},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_del_comment_'+id).html('');
                        $('#sys_del_comment_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                    $('#img_loading_del_'+id).hide();
                }
            });
        }
    },

    replyComment: function(product_comment_id, product_id, product_comment_receiver_id, product_comment_receiver_name, product_comment_receiver_email) {
        comment.cfg.product_comment_id = product_comment_id;
        comment.cfg.product_id = product_id;
        comment.cfg.product_comment_receiver_id = product_comment_receiver_id;
        comment.cfg.product_comment_receiver_name = product_comment_receiver_name;
        comment.cfg.product_comment_receiver_email = product_comment_receiver_email;

        var faq_comment = $('#sys_content_comment_'+product_comment_id).html();
        $('#sys_content_comment').html(faq_comment);
        $('#sys_content').val('');
        $('#sys_PopupInsertImageToDesc').modal('show');
    },

    sendReplyComment: function() {
        var content = $('#sys_content').val();
        if(content != '') {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "shop/comment/reply",
                data: {
                    id:comment.cfg.product_comment_id,
                    product_id:comment.cfg.product_id,
                    content:content,
                    receive_id:comment.cfg.product_comment_receiver_id,
                    receiver_name: comment.cfg.product_comment_receiver_name,
                    receiver_email: comment.cfg.product_comment_receiver_email},
                responseType: 'json',
                success: function(res) {
                    if(res.isIntOk == 1) {
                        window.location.reload();
                    } else {
                        alert('Lỗi không trả lời được comment');
                    }
                }
            });
        }
    },

    sendReplyCommentAdmin: function() {
        var content = $('#sys_content').val();
        if(content != '') {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "admin/comment/reply",
                data: {
                    id:comment.cfg.product_comment_id,
                    product_id:comment.cfg.product_id,
                    content:content,
                    receive_id:comment.cfg.product_comment_receiver_id,
                    receiver_name: comment.cfg.product_comment_receiver_name,
                    receiver_email: comment.cfg.product_comment_receiver_email},
                responseType: 'json',
                success: function(res) {
                    if(res.isIntOk == 1) {
                        window.location.reload();
                    } else {
                        alert('Lỗi không trả lời được comment');
                    }
                }
            });
        }
    },

    /**
     * QuynhTM sua noi dung biận cho cham soc khach hang
     * @param id_comment
     */
    inforCommentAdmin: function(id_comment) {
        //var content = $('#sys_content').val();
        $('#sys_PopupEditComment').modal('show');
        if(id_comment > 0){
            $.ajax({
                type: "get",
                url: WEB_ROOT + "admin/comment/getInforComment",
                data: {id:id_comment},
                responseType: 'json',
                success: function(res) {
                    if(res.isIntOk == 1) {
                        $('#sys_content_edit').val(res.noidung_comment);
                        $('#sys_comment_id_edit').val(id_comment);
                        $('#btn_edit_comment').show();
                    } else {
                        alert('Lỗi không sửa được comment');
                    }
                }
            });
        }
    },

    editCommentAdmin: function() {
        var id_comment = document.getElementById('sys_comment_id_edit').value;
        var content = $('#sys_content_edit').val();
        $('#sys_PopupEditComment').modal('show');
        if(id_comment > 0){
            $.ajax({
                type: "post",
                url: WEB_ROOT + "admin/comment/editComment",
                data: {id:id_comment,content:content},
                responseType: 'json',
                success: function(res) {
                    if(res.isIntOk == 1) {
                        alert(res.msg);
                        $('#sys_PopupEditComment').modal('hide');
                        window.location.reload();
                    } else {
                        alert('Lỗi không sửa được comment');
                    }
                }
            });
        }
    }
    /*
    end Quynhtm
     */

}


