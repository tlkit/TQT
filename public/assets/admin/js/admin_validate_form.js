/**
 * @author: ChungDuc
 * @class: admin_validate_form
 * Created by Administrator on 8/20/14.
 */

var AdminValidateForm = {
    config: {

    },

    displayValError: function(id, mess){
        this.disableValError(id);
        $('#'+id).css({'background-color':'#ffc1c1'});
        $('#'+id).parent().append('<span id="show-error" style="color:#888;font-size:11px">' + mess + '</span>');
    },

    disableValError: function(id){
        $('#'+id).css({'background-color':''});
        $('#show-error').remove();
    },

    campaign_validate: function(supplier, start_time, end_time) {
        if(supplier > 0) {
            if(start_time == '') {
                $("html, body").animate({ scrollTop: 0 }, 500);
                this.displayValError('campaign_start_time', 'Ngày bắt đầu không được trống');
                $('#campaign_start_time').focus();
                return false;
            }
            if(end_time == '') {
                $("html, body").animate({ scrollTop: 0 }, 500);
                this.displayValError('campaign_end_time', 'Ngày bắt đầu không được trống');
                $('#campaign_end_time').focus();
                return false;
            }
            $('#img_loading').show();
            return true;
        }
    }
}

