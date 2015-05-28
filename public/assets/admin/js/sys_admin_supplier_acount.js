var supplierAcount = {
    generateRandomPassword:function(type){
        var pass = this.buildPassword(),
            html = '';
        html += '<span style="color: dodgerblue">'+pass+'</span>';
        //gán lại mk mới
        $('#password').val(pass);
        $('#show_pass').html('');
        $('#show_pass').html(html);
        $('#show_pass').show();
        if(type == 2){
            $('#cancel_pass').show();
        }
    },

    cancelPass:function(){
        $('#password').val('');
        $('#cancel_pass').hide();
        $('#show_pass').html('');
        $('#show_pass').hide();
    },

    //ramdom mat khau
    buildPassword:function(){
        var chars = "0123456789",
            string_length = 6,
            randomstring = '';
        for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
        }
        return randomstring;
    },

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START CREATE ACOUNT-------------------------------------------------------
    createAcount:function(){
        var username = $('#username').val(),
            email = $('#textEmail').val(),
            phone = $('#textPhone').val(),
            password = $('#password').val(),
            acount_id = $('#acount_id').val(),
            mess = this.validateAcount(username,email,phone,password,acount_id);

        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
        }else{
            //alert('done');
            document.getElementById("create_acount").submit();
        }
    },

    validateAcount:function(username,email,phone,password,acount_id){
        var mess = '';
        if(!this.is_email(email)){
            mess +='- Email nhập không hợp lệ</br>';
        }

        if($.trim(username) == ''){
            mess+= '- Không bỏ trống tên đăng nhập</br>';
        }

        if($.trim(acount_id) == ''){
            if($.trim(password) == ''){
                mess+= '- Hãy khởi tạo mật khẩu</br>';
            }
        }

        if($.trim(phone) == ''){
            mess+= '- Không bỏ trống SDT</br>';
        }

        if(this.checkNumber(phone,1) != 2){
            mess +='- SDT nhập không hợp lệ</br>';
        }

        if(this.hasWhiteSpace(username)){
            mess += '- Không để khoảng trống khi nhập tên tài khoản';
        }
        return mess;
    },

    is_email:function(str){return (/^[a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(this.util_trim(str))},

    util_trim:function(str) {return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : ""},

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
    },

    hasWhiteSpace:function(s){
        return /\s/g.test(s);
    }


}