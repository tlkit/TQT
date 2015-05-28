$(document).ready(function(){
    $('#star_time_from').datepicker({});
    $('#star_time_to').datepicker({});

    $('#end_time_from').datepicker({});
    $('#end_time_to').datepicker({});
});
var linkAdmin = '';
var campaign_index = {
    updateStatusCampaign: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusCampaign = document.getElementById('sys_urlAjaxUpdateStatusCampaign').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusCampaign,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_campaign_'+id).html('');
                        $('#sys_status_campaign_'+id).html(data.info);
                        window.location.reload();
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

    deleteCampaign:function(id){
        if(confirm("Bạn có chắc muốn xóa Campaign này? \n - Nhấn ok nếu vẫn muốn xóa. \n - Cancel để trở lại.")){
            if(id > 0){
                var urlAjaxDeleteCampaign = document.getElementById('sys_urlAjaxDeleteCampaign').value;
                $.ajax({
                    type: "POST",
                    url: urlAjaxDeleteCampaign,
                    data: {id : id},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $("#row_"+id).remove();
                        }else if(data.intReturn == 2){
                            alert('Bạn không có quyền thực hiện thao tác này');
                        }else if(data.intReturn == 3){
                            window.location = linkAdmin+'login/logout';
                        }
                    }
                });
            }
        }
    },

    setTopFeedHomeCampaign:function(id_campaign){
        if(confirm("Bạn có chắc muốn Set Top Campaign này? \n - Nhấn ok nếu vẫn muốn set top. \n - Cancel để trở lại.")){
            if(id_campaign > 0){
                var urlAjax = document.getElementById('sys_urlAjaxSetTopCampaign').value;
                $('#img_loading_settop_campaign_id_'+id_campaign).show();
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {id_campaign : id_campaign},
                    responseType: 'json',
                    success: function(data) {
                        $('#img_loading_settop_campaign_id_'+id_campaign).hide();
                        alert(data.msg);
                    }
                });
            }
        }
    },

    //done bươc 3 update banner
    updateBanner:function(){
        $('#submit').attr('disabled', true);
        document.getElementById("update_banner").submit();
    },

    openUpdateStatusProcess :function(id){
        $('#approval_'+id).show();
    },

    updateStatusProcess: function(id){
        if(id > 0){
            $('#sys_update_'+id).attr('disabled', true);
            $('#img_loading_'+id).show();
            var process = $('#campaign_approval_'+id).val();
            var urlAjaxUpdateStatusProcess = document.getElementById('sys_urlAjaxUpdateStatusProcess').value;
            if(process > -1){
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateStatusProcess,
                    data: {id : id, status: process},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $('#sys_campaign_approval_'+id).html('');
                            $('#sys_campaign_approval_'+id).html(data.info);
                            $('#approval_'+id).hide();
                            $('#img_loading_'+id).hide();
                            $('#sys_update_'+id).attr('disabled', false);
                        }else if(data.intReturn == 2){
                            alert('Bạn không có quyền thực hiện thao tác này');
                            $('#approval_'+id).hide();
                            $('#img_loading_'+id).hide();
                            $('#sys_update_'+id).attr('disabled', false);
                        }else if(data.intReturn == 3){
                            window.location = linkAdmin+'login/logout';
                        }else{
                            alert('Thao tác lỗi');
                            $('#approval_'+id).hide();
                            $('#img_loading_'+id).hide();
                            $('#sys_update_'+id).attr('disabled', false);
                        }
                    }
                });
            }else{
                $('#approval_'+id).hide();
                $('#img_loading_'+id).hide();
                $('#sys_update_'+id).attr('disabled', false);
            }
        }
    }

}


