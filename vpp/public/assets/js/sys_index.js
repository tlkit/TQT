$(document).ready(function(){
    $('#star_time_from').datepicker({});
    $('#star_time_to').datepicker({});

    $('#end_time_from').datepicker({});
    $('#end_time_to').datepicker({});
});

var promotion_index = {
    updateStatusCampaign: function(id,status){
        if(id > 0){
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
                    }
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
                        }
                    }
                });
            }
        }
    },

    //done bươc 3 update banner
    updateBanner:function(){
        $('#submit').attr('disabled', true);
        document.getElementById("update_banner").submit();
    }

}


