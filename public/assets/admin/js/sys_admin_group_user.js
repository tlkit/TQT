/**
 * Created by MT844 on 7/11/14.
 */
var linkAdmin = '';
var groupUser = {
    updateStatusGroupUser: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusGroupUser = document.getElementById('sys_urlAjaxUpdateStatusGroupUser').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusGroupUser,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_group_user_'+id).html('');
                        $('#sys_status_group_user_'+id).html(data.info);
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

    saveGroup:function(){
        $('#submit_group').attr('disabled', true);
        var name = $('#sys_group_user_name').val();
        var result = this.validateGroupUser(name);
        console.log(result);
        if(result === false){
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_group').attr('disabled', false);
        }else{
            document.getElementById("group-user").submit();
        }
    },

    validateGroupUser:function(name){
        $('#sys_group_user_name').css( "background-color","");

        $('#sys_mess').html('');
        $('#sys_mess_form').hide();
        var result = false;

        if(!this.checkEmpty(name)){
            $("#sys_group_user_name").focus();
            $("#sys_group_user_name").css( "background-color","yellow");
            $('#sys_mess').html('Tên nhóm quyền không được bỏ trống');
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