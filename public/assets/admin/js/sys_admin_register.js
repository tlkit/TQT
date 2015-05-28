var linkAdmin = '';
var shopRegister = {
    updateStatusRegister: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusRegister = document.getElementById('sys_urlAjaxUpdateStatusRegister').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusRegister,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_register_'+id).html('');
                        $('#sys_status_register_'+id).html(data.info);
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
            var urlAjaxDeleteRegister = document.getElementById('sys_urlAjaxDeleteRegister').value;
            $.ajax({
                type: "POST",
                url: urlAjaxDeleteRegister,
                data: {id : id, flag: flag},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $("#row_"+id).remove();
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

    updateStatusProcess: function(id){
        if(id > 0){
            $('#sys_update_'+id).attr('disabled', true);
            $('#img_loading_'+id).show();
            var process = $('#status_process_'+id).val();
            var urlAjaxUpdateStatusProcess = document.getElementById('sys_urlAjaxUpdateStatusProcess').value;
            if(process > -1){
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateStatusProcess,
                    data: {id : id, status: process},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $('#sys_status_process_'+id).html('');
                            $('#sys_status_process_'+id).html(data.info);
                            $('#process_'+id).hide();
                            $('#img_loading_'+id).hide();
                            $('#sys_update_'+id).attr('disabled', false);
                        }else if(data.intReturn == 2){
                            alert('Bạn không có quyền thực hiện thao tác này');
                        }else if(data.intReturn == 3){
                            window.location = linkAdmin+'login/logout';
                        }
                    }
                });
            }else{
                $('#process_'+id).hide();
                $('#img_loading_'+id).hide();
                $('#sys_update_'+id).attr('disabled', false);
            }
        }
    },

    openUpdateStatusProcess :function(id){
        $('#process_'+id).show();
    },

    shopRegister:function(){
        var name = $('#sys_shop_name').val(),
            phone = $('#sys_shop_phone').val(),
            email = $('#sys_shop_email').val(),
            address = $('#sys_shop_address').val(),
            business = $('#sys_shop_business').val();
        var result = this.validateRegister(name,email,phone,address,business);
        if(!result){
            $("html, body").animate({ scrollTop: 0 }, 500);
        }else{
            document.getElementById("form-register").submit();
        }
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

    setValError: function(id){
        $('#'+id).css({'background-color':'red'});
    },

    validateRegister:function(name, email, phone, address, business){
        if(name == '') {
            this.displayValError('sys_shop_name', 'Tên nhà cung cấp không được trống.');
            return false;
        }
        if(phone == '') {
            this.displayValError('sys_shop_phone', 'Số điện thoại liên hệ không được trống.');
            return false;
        }
        if(email == '') {
            this.displayValError('sys_shop_email', 'Địa chỉ email liên hệ không được trống.');
            return false;
        }
        if(address == '') {
            this.displayValError('sys_shop_address', 'Địa chỉ nhà cung cấp không được trống.');
            return false;
        }
        if(business == '') {
            this.displayValError('sys_shop_business', 'Ngành hàng kinh doanh không được trống.');
            return false;
        }
        return true;
    },

    //check rong
    checkEmpty:function(value){
        if($.trim(value) === ''){
            return false
        }
        return true;
    },

    is_email:function(str){return (/^[a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(this.util_trim(str))},

    util_trim:function(str) {return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : ""},

    //value :gt can kiem tra;positive: kiem tra no la so duong hay am(1:kiem tra,0:ko kiem tra)
    checkNumber:function(value,positive){
        if(!isNaN(value)){
            if(positive === 1){
                if(value < 0){
                    return 0;
                }
            }
        }else{
            return 1;
        }
        return 2;
    }
}

