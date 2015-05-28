Common = {
    config: {
    },
    /*
        QuynhTM su dung common
        Hàm xóa common
        update common
     */
    deleteItem: function(id,url){
        if(id > 0 && confirm('Bạn có thật sự muốn xóa item này?')) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + url,
                data: {id : id},
                responseType: 'json',
                beforeSend: function () {
                },
                success: function (res) {
                    if(res.error == 0) {
                        alert('Bạn đã xóa thông tin thành công.');
                        location.reload();
                    } else {
                        alert('Bạn không thể xóa thông tin item này, vui lòng liên hệ quản trị.');
                    }
                },
                error: function () {
                }
            });
        }
    },
    updateStatusItem: function(id,status,url){
        if(id > 0) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + url,
                data: {id : id,status : status},
                responseType: 'json',
                beforeSend: function () {
                },
                success: function (res) {
                    if(res.error == 0) {
                        location.reload();
                    } else {
                        alert('Bạn không thể thao tác, vui lòng liên hệ quản trị.');
                    }
                },
                error: function () {
                }
            });
        }
    },

    approve: function(id, is_approve){
        if(id > 0 && confirm('Bạn có muốn approve bài viết này không?')) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/posts/approve/'+id,
                responseType: 'json',
                beforeSend: function () {
                },
                success: function (res) {
                    if(res.error == 0) {
                        alert('Bạn đã approve bài viết thành công.');
                        var html = '';
                        if(is_approve == 1) {
                            html = '<a href="javascript:void(0);" onclick="Common.approve('+id+', 0)"><img src="'+WEB_ROOT+'assets/images/tick.png" width="22">';
                        } else {
                            html = '<a href="javascript:void(0);" onclick="Common.approve('+id+', 1)"><img src="'+WEB_ROOT+'assets/images/untick.png" width="22">';
                        }
                        $('#sys_posts_approve_'+id).html(html);
                    } else {
                        alert('Bạn không thể xóa thông tin item này, vui lòng liên hệ quản trị.');
                    }
                },
                error: function () {
                }
            });
        }
    },
    getViewLog: function(Id) {
        $('#sys_PopupShowLog').modal('show');
        $('#sys_table_view_log').hide();
        $('#img_loading').show();
        if (Id > 0) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/logCronjob/viewLog',
                data: {id : Id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn === 1){
                        var html = res.info;
                        $('#sys_infor_view').show();
                        $('#sys_infor_view').html(html);
                    }else{
                        $('#sys_infor_view').show();
                        $('#sys_infor_view').html(res.msg);
                    }
                }
            });
        }
    },
};