/**
 * Created by MT844 on 8/20/14.
 */
$(document).ready(function(){
    $("#sys_recharge").on("keyup",function(){
        var sys_recharge =  wallet.convertStringInt('sys_recharge'),
            sys_old_recharge_hidden =  parseInt($('#sys_old_recharge_hidden').val());
        if(wallet.checkNumber(sys_recharge,1) == 2){
                var sys_new_recharge = sys_old_recharge_hidden + sys_recharge;
                jQuery('#sys_new_recharge_hidden').val(sys_new_recharge);
                number.numberFormatNew(sys_new_recharge, 'sys_new_recharge');
                wallet.fomatNumber('sys_recharge');
        }else{
            alert('Nhập số tiền không hợp lệ');
            $("#sys_recharge").val(0);
            $("#sys_recharge_hidden").val(0);
            $("#sys_new_recharge_hidden").val(0);
            $("#sys_new_recharge").val(0);
            return false;
        }
    });
});
var wallet = {
    fomatNumber:function(id) {
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        if (re > 1000000000) {
            re = 1000000000;
        }
        jQuery('#' + id +'_hidden').val(re);
        number.numberFormatNew(re, id);
    },

    convertStringInt:function(id){
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        return re;
    },

    //value :gt can kiem tra;positive: kiem tra no la so duong hay am(1:kiem tra,0:ko kiem tra)
    checkNumber:function(value,positive){
        if(!isNaN(value)){
            if(positive === 1){
                if(value <= 0){
                    return 0;
                }
            }
        }else{
            return 1;
        }
        return 2;
    },

    saveWalletSupplier:function(){
        var sys_recharge_hidden =  parseInt($('#sys_recharge_hidden').val()),
            submit_freeze = document.getElementById('submit_freeze'),
            rs = 0;
        $('#submit_group').attr('disabled', true);
        if(submit_freeze != null){
            $('#submit_freeze').attr('disabled', true);
        }
        if(wallet.checkNumber(sys_recharge_hidden,1) == 0){
            alert('Số tiền nạp phải lớn hơn 0');
            rs = 0;
        }else if(wallet.checkNumber(sys_recharge_hidden,1) == 1){
            alert('Số tiền nạp phải là số');
            rs = 0;
        }else{
            rs = 1;
        }
        if(rs == 1){
            document.getElementById("recharge").submit();
        }else{
            $('#submit_group').attr('disabled', false);
            if(submit_freeze != null){
                $('#submit_freeze').attr('disabled', false);
            }
        }
    },

    freezeWallet:function(){
        $('#submit_freeze').attr('disabled', true);
        $('#submit_group').attr('disabled', true);
        document.getElementById("freezeWallet").submit();
    }
}