/**
 * Created by MT844 on 7/11/14.
 */
var linkAdmin = '';
var permission = {
    updateStatusPermission: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusPermission = document.getElementById('sys_urlAjaxUpdateStatusPermission').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusPermission,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_permission_'+id).html('');
                        $('#sys_status_permission_'+id).html(data.info);
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

    savePermission:function(){
        $('#submit_permission').attr('disabled', true);
        var code = $('#sys_permission_code').val(),
            name = $('#sys_permission_name').val();
        var result = this.validatePermission(code,name);
        if(result === false){
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_permission').attr('disabled', false);
        }else{
            document.getElementById("permission").submit();
        }
    },

    validatePermission:function(code,name){
        $('#sys_permission_code').css( "background-color","");
        $('#sys_permission_name').css( "background-color","");

        $('#sys_mess').html('');
        $('#sys_mess_form').hide();
        var result = false;
        if(!this.checkEmpty(code)){
            $("#sys_permission_code").focus();
            $("#sys_permission_code").css( "background-color","yellow");
            $('#sys_mess').html('Mã quyền không được bỏ trống');
            $('#sys_mess_form').show();
            return result;
        }

        if(!this.checkEmpty(name)){
            $("#sys_permission_name").focus();
            $("#sys_permission_name").css( "background-color","yellow");
            $('#sys_mess').html('Tên quyền không được bỏ trống');
            $('#sys_mess_form').show();
            return result;
        }
    },

    //check rong
    checkEmpty:function(value){
        if($.trim(value) === ''){
            return false
        }
        return true;
    }
}