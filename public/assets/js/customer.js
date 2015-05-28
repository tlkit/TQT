//var BASE_URL = window.location.origin;
var popupContent = "";
var popupLoginContent = "";
var popupRattingContent = "";
var popupForgetContent = "";
var popupInfoContent = "";
var popupRegisterContent = "";
var popupVerifyContent = "";
var settingPopupForgetId = null;
var settingPopupRegisterId = null;
var settingPopupLoginId = null;
var settingPopupInfoId = null;
var settingPopupVerifyId = null;
var settingPopupRattingID = null;
var data_order = false;
$(document).ready(function () {
    //Check auto login
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: WEB_ROOT + "customer/checkAutoLogin",
        beforeSend: function () {
        },
        success: function (res) {
            if(res.isIntOk == 1) {
                location.reload();
            } else if(res.isIntOk == 2) {
                customer.logout();
            }
        },
        error: function () {
        }
    });
    $("#sys_panel_login").on("keypress",".input-txt",function(e){
        if(e.which == 10 || e.which == 13) {
            customer.login();
        }
    }).on("click",function(e){
        if(!$(this).parents(".user-panel").hasClass("active")){
            $(this).parents(".user-panel").addClass("active");
            $("body").on("click.hideLogin",function(){
                $("#sys_panel_login").parents(".user-panel").removeClass("active");
                $("body").off("click.hideLogin");
            });
        }
        e.stopPropagation();
    });
    $("#sys_btn_login").on('click',function(){
        return customer.login();;
    });
    $("#sys_btn_register").on('click',function(){
        return customer.openPopupRegister();
    });

});
var customer = {
    conf: {
        objRattingCustomer: null
    },

    register: function () {
        var fullname = $("input#sys_reg_name").val();
        var phone = $("input#sys_reg_phone").val();
        var email = $("#sys_reg_email").val();
        if( From_Validate.valid_register(fullname, email, phone) ) {
            if(!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "customer/create",
                    data: 'fullname=' + fullname + '&phone=' + phone + '&email=' + email,
                    beforeSend: function () {
                        sendingAjax = true;
                        $(".form-popup-login").find(".sys_over_loading").addClass("active");
                    },
                    success: function (res) {
                        sendingAjax = false;
                        $(".form-popup-login").find(".sys_over_loading").removeClass("active");
                        if (res.error != '') {
                            $("#sys_error_register").html(res.error);
                            return false;
                        } else {
                            customer.openPopupVerify(true);
                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        $(".form-popup-login").find(".sys_over_loading").removeClass("active");
                    }
                }, "json");
            }
        }
    },

    forget: function () {
        var email = $("#sys_forget_email").val();
        if (From_Validate.valid_forget(email)) {
            if (!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "customer/forget",
                    data: '&email=' + email,
                    beforeSend: function () {
                        sendingAjax = true;
                        $("#frm-forget").siblings(".sys_over_loading").addClass("active");
                    },
                    success: function (res) {
                        $("#frm-forget").siblings(".sys_over_loading").removeClass("active");
                        sendingAjax = false;
                        if (res.err != 0) {
                            $("#sys_error_forget").html(res.msg);
                            return false;
                        } else {
                                $(".popup-common,.overlay-bl-bg").remove();
                                alert('Kiểm tra email ' + email + ' và làm theo hướng dẫn để lấy lại mật khẩu.');
                            //$("#sys_error_forget").css("color","green").html("Gửi yêu cầu cập nhật thành công thành công.");
                            //$("#frm-forget").find(".sys_close_forger").removeClass("hidden ")
                            //                .siblings(".btn").addClass("hidden ").end()
                            //                .on("click",function(){
                            //
                            //                });

                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        $("#frm-forget").siblings(".sys_over_loading").removeClass("active");
                    }
                }, "json");
            }
        }
        return false;
    },


    account_verify: function () {
        var email = $("input#sys_reg_email_verify").val();
        var password = $("input#sys_reg_password").val();
        if( From_Validate.valid_verify_account(email, password) ) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "customer/verifyAccount",
                data: 'email=' + email + '&password=' + password,
                success: function (res) {
                    if (res.error != '') {
                        $("#sys_error_account_verify").html(res.error);
                        $("#frm-verify-account").siblings(".sys_over_loading").removeClass("active");
                    } else {
                        alert('Xác minh tài khoản thành công, bạn vui lòng vào email để kích hoạt tài khoản');
                        location.reload();
                    }
                },
                beforeSend: function () {
                    $("#frm-verify-account").siblings(".sys_over_loading").addClass("active");
                },
                error: function () {
                    $("#sys_error_account_verify").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
                    $("#frm-verify-account").siblings(".sys_over_loading").removeClass("active");
                }
            }, "json");
        }
    },
    login: function () {
        var username = $("input#sys_email").val();
        var password = $("input#sys_pass").val();
        var remember_me = ($("#sys_remember_me").is(":checked")) ? 1 : 0;
        if(remember_me == 1) {
            $.cookie('username', username, {path:'/', domain:COOKIE_DOMAIN});
        }
        if (From_Validate.customer_login(username, password)) {
            $("#show-error").remove();
            $("#sys_email,#sys_pass").removeAttr("style");
            var password_hash = $().crypt({method:"b64enc",source:password});
            var dataString = 'username=' + username + '&password=' + password_hash;
            if(!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "customer/login",
                    data: dataString,
                    dataType:'json',
                    success: function (data) {
                        sendingAjax = false;
                        if (data.error != "") {
                            $("#sys_panel_login").find(".sys_over_loading").removeClass("active");
                            $("#sys_msg_error").html(data.error);
                        }
                        else {
                            if(data.check && data.name != ''){
                                console.log(remember_me);
                                if(remember_me == 1){
                                    var remember = 'plaza_' + data.name;
                                    jQuery.cookie(remember, data.value , {expires:30,path: '/', domain: data.domain});
                                }
                                jQuery.cookie(data.name, data.value , {path: '/', domain: data.domain});
                            } 
							location.reload();
                        }
                    },
                    beforeSend: function () {
                        sendingAjax = true;
                        $("#sys_panel_login").find(".sys_over_loading").addClass("active");
                    },
                    error: function () {
                        sendingAjax = false;
                        $("#sys_panel_login").find(".sys_over_loading").removeClass("active");
                        $("#sys_msg_error").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
                    }
                }, "json");
            }
        }
        return false;
    },
    /**
     * QuynhTm copy cho dang nhập của Customer
     * @returns {boolean}
     */
    login_page_customer: function () {
        var username = $("input#sys_customer_login_email").val();
        var password = $("input#sys_password_customer_login").val();
        var url_load = $("input#url_load").val();
        if (From_Validate.customer_page_login(username, password)) {
            $("#show-error").remove();
            var password_hash = $().crypt({method:"b64enc",source:password});
            $('#pass_hass').val(password_hash);
            var dataString = 'username=' + username + '&password=' + password_hash + '&url_load=' + url_load;
            if(!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "customer/loginForm",
                    data: dataString,
                    dataType:'json',
                    success: function (data) {
                        sendingAjax = false;
                        $('#img_loading_login_customer').hide();
                        if (data.error != "") {
                            $("#sys_msg_login_customer").html(data.error);
                        }
                        else {
                            if(data.check && data.name != ''){
                                jQuery.cookie(data.name, data.value , {path: '/', domain: data.domain});
                            }

                            if(data.url_load !='')
                            {
                                window.location = data.url_load;
                            }else{
                                location.reload();
                            }
                        }
                    },
                    beforeSend: function () {
                        sendingAjax = true;
                        $('#img_loading_login_customer').show();
                    },
                    error: function () {
                        sendingAjax = false;
                        $('#img_loading_login_customer').hide();
                        $("#sys_msg_login_customer").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
                    }
                }, "json");
                return true;
            }
        }
        return false;
    },

    register_page_customer: function () {
        var fullname = $("input#sys_customer_name").val();
        var phone = $("input#sys_customer_phone").val();
        var email = $("#sys_customer_email").val();
        if( From_Validate.valid_register_page_customer(fullname, email, phone) ) {
            if(!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "/customer/create",
                    data: 'fullname=' + fullname + '&phone=' + phone + '&email=' + email,
                    beforeSend: function () {
                        sendingAjax = true;
                        $('#img_loading_register_customer').show();
                    },
                    success: function (res) {
                        sendingAjax = false;
                        $('#img_loading_register_customer').hide();
                        if (res.error != '') {
                            $("#sys_error_register_customer").html(res.error);
                            return false;
                        } else {
                            $('#sys_step_register_1').hide();
                            $('#sys_step_register_2').show();
                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        $('#img_loading_register_customer').hide();
                    }
                }, "json");
            }
        }
    },

    account_page_customer_verify: function () {
        var email = $("input#sys_reg_email_customer_verify").val();
        var password = $("input#sys_reg_password_customer_verify").val();
        if( From_Validate.valid_verify_account_page_customer(email, password) ) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "/customer/verifyAccount",
                data: 'email=' + email + '&password=' + password,
                success: function (res) {
                    if (res.error != '') {
                        $("#sys_error_verify_account_page_customer").html(res.error);
                    } else {
                        alert('Xác minh tài khoản thành công, bạn vui lòng vào email để kích hoạt tài khoản');
                       // location.reload();
                    }
                }
            }, "json");
        }
    },
    /**
     * End QuynhTM
     */
    loginPopup: function ($order) {
            var username = $("input#sys_email_popup").val();
            var password = $("input#sys_pass_popup").val();
            var remember_me = ($("#sys_popup_remember_me").is(":checked")) ? 1 : 0;
            if (remember_me == 1) {
                $.cookie('username', username, {path: '/', domain: COOKIE_DOMAIN});
            }
        if( From_Validate.customer_login_popup(username, password) ) {
            var password_hash = $().crypt({method:"b64enc",source:password});
            var dataString = 'username=' + username + '&password=' + password_hash;
            if(!sendingAjax) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + "/customer/login",
                    data: dataString,
                    dataType:'json',
                    success: function (data) {
                        sendingAjax = false;
                        if (data.error != "") {
                            $("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
                            $("#sys_error_login").html(data.error);
                        }
                        else {
                            if(data.check && data.name != ''){
                                if (remember_me == 1) {
                                    var remember = 'plaza_' + data.name;
                                    jQuery.cookie(remember, data.value, {expires: 30, path: '/', domain: data.domain});
                                }
                                    jQuery.cookie(data.name, data.value, {path: '/', domain: data.domain});
                                //}
                                if($order){
                                    jQuery.cookie('open_orders', 1 , {path: '/', domain: data.domain});
                                    var open_order = jQuery.cookie('open_orders');
                                }
                            }
                            location.reload();
                        }
                    },
                    beforeSend: function () {
                        sendingAjax = true;
                        //$("#sys_panel_login").find(".sys_over_loading").addClass("active");
                        $("#frm-login-popup").siblings(".sys_over_loading").addClass("active");
                    },
                    error: function () {
                        sendingAjax = false;
                        $("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
                        $("#sys_error_login").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
                    }
                }, "json");
            }else{

            }
        }
    },

    //loginOrder: function () {
    //    var username = $("input#sys_email_popup").val();
    //    var password = $("input#sys_pass_popup").val();
    //    if( From_Validate.customer_login_popup(username, password) ) {
    //        $("#show-error").remove();
    //        $("#sys_email_popup,#sys_pass_popup").removeAttr("style");
    //        var password_hash = $().crypt({method:"b64enc",source:password});
    //        var dataString = 'username=' + username + '&password=' + password_hash;
    //        if(!sendingAjax) {
    //            $.ajax({
    //                type: "POST",
    //                url: WEB_ROOT + "customer/login",
    //                data: dataString,
    //                dataType:'json',
    //                success: function (data) {
    //                    sendingAjax = false;
    //                    if (data.error != "") {
    //                        $("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
    //                        $("#sys_msg_error_popup").html(data.error);
    //                    }
    //                    else {
    //                        if(data.check && data.name != ''){
    //                            jQuery.cookie(data.name, data.value , {path: '/', domain: data.domain});
    //                        }
    //                        location.reload();
    //                    }
    //                },
    //                beforeSend: function () {
    //                    sendingAjax = true;
    //                    $("#frm-login-popup").siblings(".sys_over_loading").addClass("active");
    //                },
    //                error: function () {
    //                    sendingAjax = false;
    //                    $("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
    //                    $("#sys_msg_error_popup").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
    //                }
    //            }, "json");
    //        }else{
    //
    //        }
    //    }
    //},

    logout : function() {
        if(!sendingAjax) {
            $.ajax({
                type: "POST",
                url: WEB_ROOT + "customer/logout",
                dataType:'json',
                success: function (data) {
                    sendingAjax = false;
                    if (data.error != "") {
                        $("#sys_msg_error").html(data.error);
                    } else {
                        if(data.check && data.name != '') {
                            jQuery.removeCookie(data.name, {path: '/', domain: data.domain});
                            var remember = 'plaza_' + data.name;
                            jQuery.removeCookie(remember, {path: '/', domain: data.domain});
                        }
                        location.reload();
                    }
                },
                beforeSend: function () {
                    sendingAjax = true;
                    $("#sys_panel_login").find(".sys_over_loading").addClass("active");
                },
                error: function () {
                    sendingAjax = false;
                }
            }, "json");
        }else{

        }
    },

    openPopupRegister: function (isInsidePopup,popupInsideId) {

        if (popupRegisterContent == "") {
            popupRegisterContent = $("#sys_popup_register_content").html();
        }
        $("#sys_popup_register_content").html("");
        if (settingPopupRegisterId == null)
            settingPopupRegisterId = (popupInsideId) ? popupInsideId : "sys_popup_register";
        if (isInsidePopup == undefined) {
            $.popupCommon2({
                attrId: settingPopupRegisterId,
                widthPop: "400px",
                extendClass: "popup-style-mc",
                successOpen: function () {
                },
                preClose: function () {
                    settingPopupRegisterId = null;
                }
            });
        } else {
            if (isInsidePopup) {
                $(".popup-common").find(".main-content").html(popupRegisterContent);
            }
        }

        var _$this = $("#" + settingPopupRegisterId);
        _$this.find(".main-content").html(popupRegisterContent);
        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        _$this.fadeIn();
        $("#sys_reg_name").focus();

        $("#frm-register").on("keypress", ".txt", function (e) {
            if (e.which == 10 || e.which == 13) {
                customer.register();
            }
        });

    },

    openPopupForget: function (isInsidePopup, popupInsideId) {

        if (popupForgetContent == "") {
            popupForgetContent = $("#sys_popup_content_forget").html();
        }
        $("#sys_popup_content_forget").html("");
        if (settingPopupForgetId == null)
            //settingPopupForgetId = "sys_popup_forget";
            settingPopupForgetId = (popupInsideId) ? popupInsideId : "sys_popup_forget";
        if (isInsidePopup == undefined) {
            $.popupCommon2({
                attrId: settingPopupForgetId,
                widthPop: "530px",
                extendClass: "popup-style-mc",
                successOpen: function () {
                },
                preClose: function () {
                    settingPopupForgetId = null;
                }
            });
        } else {
            if (isInsidePopup) {
                $(".popup-common").find(".main-content").html(popupForgetContent);
            }
        }

        var _$this = $("#" + settingPopupForgetId);
            _$this.find(".main-content").html(popupForgetContent);
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        _$this.fadeIn();

        $("#sys_forget_email").focus();
        $("#sys_forget_email").on('keypress', function () {
            $(this).css('background','none');
            $(this).siblings("#show-error").html("");
        })
        $("#frm-forget").on("keypress", ".txt", function (e) {
            if (e.which == 10 || e.which == 13) {
                customer.forget();
            }
        });
    },

    openPopupInfo: function (title,isInsidePopup, popupInsideId) {

        if (popupInfoContent == "") {
            popupInfoContent = $("#sys_popup_info_content").html();
        }
        $("#sys_popup_info_content").html("");
        if (settingPopupInfoId == null)
            settingPopupInfoId = "sys_popup_info";
        if (isInsidePopup == undefined) {
            $.popupCommon2({
                attrId: settingPopupInfoId,
                widthPop: "400px",
                extendClass: "popup-style-mc",
                successOpen: function () {
                },
                preClose: function () {
                    settingPopupInfoId = null;
                }
            });
        } else {
            if (isInsidePopup) {
                $(".popup-common").find(".main-content").html(popupInfoContent);
            }
        }

        var _$this = $("#" + settingPopupInfoId);
        _$this.find(".main-content").html(popupInfoContent);
        $(".popup-common").find(".classic-popup-subtitleBig").html(title)
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        _$this.fadeIn();

    },

    openPopupVerify: function (isInsidePopup) {
        if (popupVerifyContent == "") {
            popupVerifyContent = $("#sys_popup_verify_account").html();
        }
        $("#sys_popup_verify_account").html("");
        $(".popup-common").find(".main-content").html(popupVerifyContent);
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        $("#sys_reg_email_verify").focus();
        $("#frm-verify-account").on("keypress", ".txt", function (e) {
            if (e.which == 10 || e.which == 13) {
                customer.account_verify();
            }
        });

    },
    openPopupLogin: function ($order,isInsidePopup,popupInsideId) {
        $("#sys_popup_ratting").find(".closePopup").trigger("click");
        if (popupLoginContent == "") {
            popupLoginContent = $("#sys_popup_login_content").html();
        }
        $("#sys_popup_login_content").html("");
        if (settingPopupLoginId == null)
           // settingPopupLoginId = "sys_popup_login";
            settingPopupLoginId = (popupInsideId) ? popupInsideId : "sys_popup_login";


        if (isInsidePopup == undefined) {
            $.popupCommon2({
                attrId: settingPopupLoginId,
                widthPop: "400px",
                extendClass: "popup-style-mc",
                successOpen: function () {
                },
                preClose: function () {
                    settingPopupLoginId = null;
                }
            });
        } else {
            if (isInsidePopup) {
                $(".popup-common").find(".main-content").html(popupLoginContent);
            }
        }

        var _$this = $("#" + settingPopupLoginId);
            _$this.find(".main-content").html(popupLoginContent);

        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        _$this.fadeIn();

        $("#sys_email_popup").focus();
        $("#frm-login-popup").on("keypress", ".txt", function (e) {
            if (e.which == 10 || e.which == 13) {
                if(data_order)
                customer.loginPopup(true);
                else
                customer.loginPopup()
            }
        });

        $("#sys_btn_submit_login").on('click', function () {
            if (data_order)
                return customer.loginPopup(true);
            else
                return customer.loginPopup()
            //return customer.loginPopup();
        });
        return false;
    },


    //openPopupLogin2: function (id, isInsidePopup,popupID) {
    //    var campaign_products_id = $('#' + id).attr('data-campaign-product-id');
    //    var supplier_id = $('#' + id).attr('data-supplier-id');
    //    var product_id = $('#' + id).attr('data-value');
    //    var campaign_type = $('#' + id).attr('data-campaign-type');
    //    var amount = $('#buy_number_in_popup').val();
    //    var product_price = $("#sys_price_" + product_id).val();
    //    var product_name = $("#sys_product_name_" + product_id).val();
    //
    //    $.cookie('ck_campaign_products_id', campaign_products_id , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_supplier_id', supplier_id , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_product_id', product_id , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_campaign_type', campaign_type , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_status_buy', 1 , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_amount_buy', amount , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_product_price', product_price , {path: '/', domain: COOKIE_DOMAIN});
    //    $.cookie('ck_product_name', product_name , {path: '/', domain: COOKIE_DOMAIN});
    //
    //    if (popupLoginContent == "") {
    //        popupLoginContent = $("#sys_popup_login_content").html();
    //    }
    //    $("#sys_popup_login_content").html("");
    //    if(isInsidePopup == undefined) {
    //        $.popupCommon({
    //            widthPop: "700px",
    //            htmlContent: popupLoginContent
    //        });
    //    }else{
    //        if(isInsidePopup) {
    //            if(popupID)
    //                $("#" + popupID).find(".main-content").html(popupLoginContent);
    //            else
    //                $("#sys_popup_common").find(".main-content").html(popupLoginContent);
    //        }
    //    }
    //    $("#sys_email_popup").focus();
    //    $("#frm-login-popup").on("keypress",".txt",function(e){
    //        if(e.which == 10 || e.which == 13) {
    //            customer.loginOrder();
    //        }
    //    });
    //    return false;
    //},

    is_phone: function (num) {
        return (/^(01([0-9]{1})|09)(\d{8})$/i).test(num);
    },
    is_mail: function (str) {
        return  (/^[a-z][a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(this.util_trim(str));
    },
    util_trim: function (str) {
        return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : "";
    },

    inputEmailSubcrice: function (){
        var email = $('#sys_email_subcrice').val();
        if(email == '') {
            alert('Bạn vui lòng nhập email');
            $('#sys_email_subcrice').focus();
        } else if(!LibJS.is_email(email)) {
            alert('Định dạng email không đúng');
            $('#sys_email_subcrice').focus();
        } else {
            customer.registerCity();
        }
    },
    submitEmailSubcrice: function(){
        var email = $('#sys_email_subcrice').val();
        var ids = '';
        jQuery('.popupSubCity').each(function(){
            if(jQuery(this).hasClass('btSubcityCheck')){
                ids += this.id+',';
            }
        });
        if(ids == ''){
            alert('Xin Quý khách vui lòng chọn tỉnh thành!');
        }else {
            $.ajax({
                url: WEB_ROOT + 'createSubcrice',
                data: {email: email,id_province: ids},
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    $('#sys_email_subcrice').css('background-color', '#ccc');
                },
                complete: function () {
                    $('#sys_email_subcrice').css('background-color', '#fff');
                },
                success: function (res) {
                    if (res.intIsOK == 1) {
                        alert('Bạn đã đăng ký thành công để nhận thông tin khuyến mãi mỗi ngày!');
                        $('#sys_email_subcrice').val('');
                    } else if (res.intIsOK == 0) {
                        alert('Email của bạn đã được đăng ký để nhận thông tin khuyến mãi mỗi ngày!');
                        $('#sys_email_subcrice').val('');
                        $('#sys_email_subcrice').focus();
                    } else {
                        alert('Địa chỉ email không hợp lệ.');
                        $('#sys_email_subcrice').focus();
                    }
                    $("#sys_popup_email_subcrice").find(".closePopup").trigger("click");
                }
            });
        }
    },
    /*
    popup dang ky tinh thanh nhan mail
     */
    registerCity:function(id) {
        var popupLocationContent = $("#sys_EmailSubcrice").html();
        //$("#sys_EmailSubcrice").html("");
        var settingPopupEmailSubcrice = "sys_popup_email_subcrice";
        //$.popupCommon({
        //    attrId: settingPopupEmailSubcrice,
        //    widthPop: 431,
        //    extendClass: "popup-choose-multi-location",
        //    htmlContent: popupLocationContent,
        //    successOpen: function () {
        //    },
        //    preClose: function () {
        //        settingPopupEmailSubcrice = null;
        //    }
        //});
        $.popupCommon2({
            attrId: settingPopupEmailSubcrice,
            widthPop: "414px",
            extendClass: "popup-style-mc",
            successOpen: function () {
            },
            preClose: function () {
                settingPopupEmailSubcrice = null;
            }
        });
        var _$this = $("#" + settingPopupEmailSubcrice);
        _$this.find(".main-content").html(popupLocationContent);
        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        $(".popup-common").find('.classic-popup-close').on("click",function(){
            $(".popup-common").find(".closePopup").trigger("click");
        });
        _$this.fadeIn();
    },
    clickButton:function(obj){
        obj = jQuery(obj);
        if(obj.hasClass('btSubcityCheck')){
            obj.removeClass('btSubcityCheck');
        }else{
            obj.addClass('btSubcityCheck');
        }
    },

    //Xu ly popup ratting.
    openPopupRatting: function () {
        if (popupRattingContent == "") {
            popupRattingContent = $("#sys_popup_ratting_content").html();
        }
        $("#sys_popup_ratting_content").html("");
        if (settingPopupRattingID == null)
            settingPopupRattingID = "sys_popup_ratting";
        $.popupCommon({
            attrId: settingPopupRattingID,
            htmlContent: popupRattingContent,
            //extendClass: "popup-choose-location",
            widthPop: "700px",
            overlayClickHide:false,
            successOpen: function () {
                //rate star on popup
                $("#" + settingPopupRattingID).find(".opacity-border").hide().end().find(".closePopup").hide();
                var sys_star_em_for_rate = $(".sys_star_em_for_rate");
                sys_star_em_for_rate.on("click", function(){
                    var idx = $(this).index();
                    $(this).addClass("active").parent().attr("data-score", idx);
                    $(this).siblings().each(function(){
                        if($(this).index()<idx) {
                            $(this).addClass("active");
                        }else{
                            $(this).removeClass("active checked");
                        }
                    });
                    $(this).removeClass("checked").siblings().removeClass("checked");
                    $(this).parents(".sys_rate_option").find("input").val(idx+1).end().find(".sys_rate_option_score").removeClass("active checked").eq(idx).addClass("active");
                });
                sys_star_em_for_rate.on("mouseenter", function(){
                    var idx = $(this).index();
                    $(this).parents(".sys_rate_option").find(".sys_rate_option_score").removeClass("checked active").eq(idx).addClass("checked");
                    $(this).addClass("checked");
                    $(this).siblings().each(function(){
                        if($(this).index()<idx) {
                            $(this).addClass("checked");
                        }else{
                            $(this).removeClass("checked active");
                        }
                    });
                });
                sys_star_em_for_rate.on("mouseleave", function(){
                    $(this).removeClass("checked active").siblings().removeClass("checked active");
                    $(this).parents(".sys_rate_option").find(".sys_rate_option_score").removeClass("checked");
                });
                $(".sys_wrap_option_stars").on("mouseleave", function(){
                    var getScoreRate = $(this).attr("data-score");
                    if(getScoreRate>=0) {
                        $(this).children().each(function(){
                            if($(this).index()<=getScoreRate) {
                                $(this).addClass("active");
                            }else{
                                $(this).removeClass("active checked");
                            }
                        });
                        $(this).parents(".sys_rate_option").find(".sys_rate_option_score").eq(getScoreRate).addClass("active");
                    }
                });
                $(".popup-common").find('.classic-popup-close').on("click",function(){
                    $(".popup-common").find(".closePopup").trigger("click");
                });
            },
            preClose: function () {
                settingPopupRattingID = null;
            }
        });



       /* var _$this = $("#" + settingPopupRattingID);
        _$this.find(".main-content").html(popupRattingContent);

        var popContent = _$this.find(".pop-content");
        var setLeftCSS;
        setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
        popContent.css({
            "left": setLeftCSS
        });
        _$this.css({
            "display": "none",
            "visibility": "visible"
        });
        _$this.fadeIn();
        $("#sys_email_popup").focus();*/
        $(".btn-submit-rate-content").on('click', function () {
            return customer.voteRating();
        });
        return false;
    },

    voteRating: function () {
        var idProduct = parseInt($("input#sys_product_id").val());
        var content = $("#sys_rate_content").val();
        var dataSave = {};
        if(customer.conf.objRattingCustomer != '') {
            var count = 0;
            $.each( customer.conf.objRattingCustomer, function( i, vallue ) {
                var value = parseInt($('#sys_rate_for_' + vallue.category_ratting_id).val());
                i = parseInt(i);
                count = parseInt(count);
                dataSave[count] = {cattegory_ratting_id: vallue.category_ratting_id, product_ratting_point: value};
                count++;
            });
        } else {
            var value = parseInt($('#sys_rate_for_0').val());
            dataSave[0] = {cattegory_ratting_id: -1, product_ratting_point: value};
        }
        var data = JSON.stringify(dataSave);
        if(content == '' || content == undefined) {
            alert('Nội dung không được trống.');
            return false;
        }
        $.ajax({
            type: "POST",
            url: WEB_ROOT + "setDataRatting",
            data: {idProduct: idProduct, content: content, data: data},
            dataType:'json',
            success: function (res) {
                if(res.isIntOk == 1) {
                    alert(res.msg);
                    window.location.reload();
                } else {
                    alert(res.msg);
                }
            },
            beforeSend: function () {
                //sendingAjax = true;
                //$("#sys_panel_login").find(".sys_over_loading").addClass("active");
                //$("#frm-login-popup").siblings(".sys_over_loading").addClass("active");
            },
            error: function () {
                //sendingAjax = false;
                //$("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
                //$("#sys_msg_error_popup").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
            }
        }, "json");
    },

    loadRatting: function() {
        var page_num = $('#sys_page_num').val();
        var product_id = parseInt($("input#sys_product_id").val());
        $.ajax({
            type: "POST",
            url: WEB_ROOT + "loadRatting",
            data: {page_num: page_num, product_id: product_id},
            dataType:'json',
            success: function (res) {
                if(res.isIntOk == 1) {
                    $('#show_box_ratting_customer').show();
                    $('#sys_page_num').val(res.page_num);
                    var html = '';
                    $.each( res.data, function( i, value ) {
                        html += '<div class="rate-cm-item">'+
                            '<div class="option-rated-val">'+
                                '<i class="icon-star star-sm1-yl" style="float:left; margin-right: 5px;"><i style="width: '+ ((value.product_ratting_point/5)*100) +'%"></i></i>'+
                                '<div class="rci-username">' + value.customer_full_name + '</div>'+
                            '</div>'+
                            '<span class="rci-is-bought">' + ((value.num > 0) ? 'Đã mua sản phẩm này' : 'Chưa mua sản phẩm này') + '</span>'+
                            '<div class="rci-text-content">' + value.product_ratting_content + '</div>'+
                        '</div>';
                    });
                    $('#show_ratting_customer').append(html);
                    if(res.count <= 3) {
                        $('.btn-create-a-rate').remove();
                    }
                } else {
                    //alert(res.msg);
                }
            },
            beforeSend: function () {
                //sendingAjax = true;
                //$("#sys_panel_login").find(".sys_over_loading").addClass("active");
                //$("#frm-login-popup").siblings(".sys_over_loading").addClass("active");
            },
            error: function () {
                //sendingAjax = false;
                //$("#frm-login-popup").siblings(".sys_over_loading").removeClass("active");
                //$("#sys_msg_error_popup").html("Có sự cố xảy ra, bạn vui lòng liên hệ quản trị.");
            }
        });
    }
};