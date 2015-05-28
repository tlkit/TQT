settingPopupOrderId = null;
frameStep1 = null;
frameStep2_1 = null;
frameStep2_2 = null;
frameStep3 = null;

frameCouponStep1 = null;
frameCouponStep2 = null;
frameCouponStep3 = null;
frameCouponStep4 = null;

frameCouponStep2_1 = null;

frameProductStep1 = null;
frameProductStep2_1 = null;
frameProductStep2_2 = null;
frameProductStep2_3 = null;
frameProductStep3 = null;
frameProductStep4 = null;



dataCouponStep1 = null;
dataCouponStep2_1 = null;
dataCouponStep2_2 = null;
dataCouponStep3 = null;

product_id = 0;
product_name = '';
product_img = '';
var Cart = {
    config: {
        fullname: '',
        phone: '',
        email: 'chungndhy@gmail.com',
        price: 0,
        amount: 0,
        total_price: 0,
        city: 0,
        wards:0,
        street: '',
        address: '',
        cart_id: 0,
        orders_id: 0,
        orders_delivery: 0,
        payment_id: 0,
        store_supplier_id: 0,
        payment_type: 0,
        orders_type: 0
   },
    valid_infoPayment: function() {
        var price = $('#sys_price_' + product_id).val();
        var amount = $('#buy_number_' + product_id).val();
        if (price <= 0 || amount <= 0) {
            alert('Sản phẩm đẫ hết hạn, bạn vui lòng chọn sản phẩm khác.');
            window.location.reload();
            return false;
        }
        return true;
    },
    valid_step_1:function(){
        var isValid = true;
        var getTypeDelivery = parseInt($("input:radio[name='delivery_type']:checked").val());
        switch (getTypeDelivery) {
            case 1:
                var sys_mobile = $('#sys_mobile');
                if (!LibJS.is_phone(sys_mobile.val())) {
                    sys_mobile.focus().siblings().hide().fadeIn();
                    isValid = false;
                }else{
                    sys_mobile.siblings().fadeOut();
                    this.config.phone = sys_mobile.val();
                }
                //Valid kho hàng của nhà cung cấp
                var store_supplier_id = $('input[name=store_supplier_id]:checked').val();
                Cart.config.store_supplier_id = store_supplier_id;
                break;
            case 2:
                //Valid họ, tên
                var fullname = $('#fullname').val();
                if (fullname == '') {
                    $('#fullname').focus().siblings().hide().fadeIn();
                    return false;
                }else
                    $('#fullname').siblings().hide();
                this.config.fullname = fullname;
                //Valid số điện thoại
                var phone = $('#phone').val();
                if (!LibJS.is_phone(phone)) {
                    $('#phone').focus().siblings().hide().fadeIn();
                    return false;
                }else
                    $('#phone').siblings().hide();
                this.config.phone = phone;
                //Valid số điện thoại
                var email = $('#email').val();
                if (email == '' || !LibJS.is_email(email)) {
                    $('#email').focus().siblings().hide().fadeIn();
                    return false;
                }else
                    $('#email').siblings().hide();

                this.config.email = email;
                //Valid thành phố
                var city = $('#city').val();
                if (city <= 0) {
                    $('#city').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                    return false;
                }else
                    $('#city').parents(".xxxDropdown").siblings().hide();

                this.config.city = city;
                //Valid quận huyện
                var districts = $('#districts').val();
                if (districts <= 0) {
                    $('#districts').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                    return false;
                }else
                    $('#districts').parents(".xxxDropdown").siblings().hide();

                this.config.districts = districts;

                //Valid phường xã
                if(this.config.city == 29) {
                    var wards = $('#wards').val();
                    if (wards <= 0) {
                        $('#wards').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                        return false;
                    }else
                        $('#wards').parents(".xxxDropdown").siblings().hide();
                    this.config.wards = wards;
                }
                //Valid địa chỉ
                var address = $('#address').val();
                if (address == '') {
                    $('#address').focus().siblings().hide().fadeIn();
                    return false;
                }else
                    $('#address').siblings().hide();
                this.config.address = address;
                break;
        }
        return isValid;
    },

    valid_step_3:function(){
        var isValid = true;
        //Valid họ, tên
        var fullname = $('#fullname').val();
        if (fullname == '') {
            $('#fullname').focus().siblings().hide().fadeIn();
            return false;
        }else
            $('#fullname').siblings().hide();
        this.config.fullname = fullname;
        //Valid số điện thoại
        var phone = $('#phone').val();
        if (!LibJS.is_phone(phone)) {
            $('#phone').focus().siblings().hide().fadeIn();
            return false;
        }else
            $('#phone').siblings().hide();
        this.config.phone = phone;
        //Valid số điện thoại
        var email = $('#email').val();
        if (email == '' || !LibJS.is_email(email)) {
            $('#email').focus().siblings().hide().fadeIn();
            return false;
        }else
            $('#email').siblings().hide();

        this.config.email = email;
        if(Cart.config.orders_delivery == 2){

            //Valid thành phố
            var city = $('#city').val();
            if (city <= 0) {
                $('#city').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                return false;
            } else
                $('#city').parents(".xxxDropdown").siblings().hide();

            this.config.city = city;
            //Valid quận huyện
            var districts = $('#districts').val();
            if (districts <= 0) {
                $('#districts').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                return false;
            } else
                $('#districts').parents(".xxxDropdown").siblings().hide();

            this.config.districts = districts;

            //Valid phường xã
            if (this.config.city == 29) {
                var wards = $('#wards').val();
                if (wards <= 0) {
                    $('#wards').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                    return false;
                } else
                    $('#wards').parents(".xxxDropdown").siblings().hide();
                this.config.wards = wards;
            }
            //Valid duong pho
            var street = $('#street').val();
            if (street == '') {
                $('#street').focus().siblings().hide().fadeIn();
                return false;
            } else
                $('#street').siblings().hide();
            this.config.street = street;
            //Valid địa chỉ
            var address = $('#address').val();
            if (address == '') {
                $('#address').focus().siblings().hide().fadeIn();
                return false;
            } else
                $('#address').siblings().hide();
            this.config.address = address;
        }

        return isValid;
    },


    start: function(buy_type) {
        if(this.valid_infoPayment()) {
            if(buy_type == 1) {
                Cart.config.orders_type = 2;
                this.order_step_product_1();
            } else {
                Cart.config.orders_type = 1;
                this.order_step_1();
            }
        }
    },

    order_step_1: function(isBack,isInsideAPopup, popupInsideId) {
        Cart.config.orders_type = 1;
        // popupInsideId: Popup in other page
        if (settingPopupOrderId == null)
            settingPopupOrderId = (popupInsideId) ? popupInsideId : "sys_popup_shop_order";
        if(isInsideAPopup == undefined || isInsideAPopup == false) {
            if(isBack == undefined || isBack == false)
                $.popupCommon2({
                    attrId: settingPopupOrderId,
                    widthPop: "914px",
                    successOpen: function () {},
                    preClose: function () {
                        settingPopupOrderId = null;
                    }
                });
        }
        var _$this = $("#" + settingPopupOrderId);
        if(isBack)
            _$this.find(".main-content").html(dataCouponStep1);
        else
            _$this.find(".main-content").html(frameCouponStep1);

        $(".xxxDropdown").xxxDropdown();
        $(".sys_option_payment").on("click",function(){
            $(".sys_option_payment").removeClass("active");
            $(this).addClass("active");
        });
        $("#sys_order_step_2").on("click", function () {
            Cart.config.payment_type = parseInt($("input:radio[name='payment_type']:checked").val());
            Cart.config.phone = '0977511928'; //$('#sys_mobile').val();
            Cart.config.amount = $('#buy_number_' + product_id).val();
            if(Cart.config.amount == 0 || Cart.config.amount == undefined || Cart.config.amount == 'undefined') {
                Cart.config.amount = $.cookie('ck_amount_buy_slide');
            }
            var campaign_product_id = $('#campaign_product_id_' + product_id).val();
            if(campaign_product_id == 0 || campaign_product_id == undefined || campaign_product_id == 'undefined') {
                campaign_product_id = $.cookie('ck_campaign_products_id');
            }

            var store_supplier_id = $('input[name=store_supplier_id]:checked').val();
            if(Cart.valid_step_1()) {
                if(!sendingAjax) {
                    if(Cart.config.payment_type == 1) {
                        $('#sys_get_supplier').css('display', 'block');
                        $('#sys_get_office').css('display', 'none');
                        $.ajax({
                            url: WEB_ROOT + 'createOrders',
                            data: {
                                id: campaign_product_id,
                                amount: Cart.config.amount,
                                phone: Cart.config.phone,
                                payment_type: Cart.config.payment_type,
                                orders_type: Cart.config.orders_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                sendingAjax = true;
                                _$this.find(".sys_over_loading").addClass("active");
                            },
                            success: function(res) {
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                if (res.intIsOK == 1) {
                                    /*if(Cart.config.orders_delivery == 1 && (parseInt(res.numOfStore) < Cart.config.amount)) {
                                        $("#sys_lbl_store_"+ store_supplier_id).addClass("disabled").children(".log-error").fadeIn().end().children("input").attr({
                                            checked:false,
                                            disabled:true
                                        });
                                    } else {*/
                                        Cart.config.orders_id = res.order_id;
                                        $('#sys_orders_id_' + product_id).val(res.order_id);
                                        dataCouponStep1 = _$this.find(".sys_popup_order");
                                        Cart.order_step_2_1();
                                    /*}*/
                                }else{
                                    if(res.msg) {
                                        alert(res.msg);
                                        return false;
                                    }
                                    else {
                                        alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                    }
                                    return false;
                                }
                            },
                            error:function(){
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                _$this.find(".sys_form_log_total").removeClass("hide-elem");
                                console.log("Co loi xay ra");
                            }
                        });
                    } else {
                        $('#sys_get_supplier').css('display', 'none');
                        $('#sys_get_office').css('display', 'block');
                        $.ajax({
                            url: WEB_ROOT + 'createOrders',
                            data: {
                                id: campaign_product_id,
                                amount: Cart.config.amount,
                                phone: Cart.config.phone,
                                payment_type: Cart.config.payment_type,
                                orders_type: Cart.config.orders_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                sendingAjax=true;
                                _$this.find(".sys_over_loading").addClass("active");
                            },
                            success: function(res) {
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                if (res.intIsOK == 1) {
                                    Cart.config.orders_id = res.order_id;
                                    $('#sys_orders_id_' + product_id).val(res.order_id);
                                    dataCouponStep1 = _$this.find(".sys_popup_order");
                                    Cart.order_step_2_2();
                                } else{
                                    if(res.msg) {
                                        alert(res.msg);
                                    }
                                    else {
                                        alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                    }
                                    return false;
                                }
                            },
                            error:function(){
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                _$this.find(".sys_form_log_total").removeClass("hide-elem");
                                console.log("Co loi xay ra");
                            }
                        });
                    }
                }else{
                    console.log("dang xu ly");
                }
            }else{
                console.log("Có lỗi xảy ra, vui lòng kiểm tra lại code.");
            }
        });

        /* init popup's position */
        if(isBack==undefined || isBack == false) {
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
        }
    },
    order_step_2_1:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep2_1);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameCouponStep2_1);

        $("#sys_order_back_1").on("click", function () {
            Cart.order_step_1(true);
        });
        $("#sys_order_step_3").on("click", function () {
            Cart.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            dataCouponStep2_1 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            Cart.order_step_3();
        });
        $(".sys_orders_delivery").on('change', function () {
            if($("input:radio[name=orders_delivery]:checked").val() == 2){
                $("#sys_address_home").removeClass('hidden');
                $("#sys_address_shop").addClass('hidden');
            }else{
                $("#sys_address_home").addClass('hidden');
                $("#sys_address_shop").removeClass('hidden');
            }
        });
    },
    order_step_2_2:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep2_2);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameCouponStep2_2);

        $("#sys_order_back_1").on("click", function () {
            Cart.order_step_1(true);
        });
        $(" #sys_order_step_3").on("click", function () {
            Cart.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            dataCouponStep2_2 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            Cart.order_step_3();
        });
    },
    order_step_3:function(isBack,isInsideAPopup, popupInsideId){
        // popupInsideId: Popup in other page
        //if (settingPopupOrderId == null)
        //    settingPopupOrderId = (popupInsideId) ? popupInsideId : "sys_popup_shop_order";
        //if(isInsideAPopup == undefined || isInsideAPopup == false) {
        //    if(isBack == undefined || isBack == false)
        //        $.popupCommon2({
        //            attrId: settingPopupOrderId,
        //            widthPop: "914px",
        //            successOpen: function () {},
        //            preClose: function () {
        //                settingPopupOrderId = null;
        //            }
        //        });
        //}
        var _$this = $("#" + settingPopupOrderId);

        if(isBack) {
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep3);
        } else
            $("#" + settingPopupOrderId).find(".main-content").html(frameCouponStep3);

        if (Cart.config.orders_delivery != 2) {
            $(".sys_customer_home_info").addClass('hidden');
        }
        $(".xxxDropdown").xxxDropdown();
        $("#sys_order_back_2").on("click", function () {
            if(Cart.config.payment_type == 1) {
                Cart.order_step_2_1(true);
            } else {
                Cart.order_step_2_2(true);
            }
        });
        $(" #sys_order_step_4").on("click", function () {
            //alert('123');
            if(Cart.valid_step_3()) {
                var orders_id = Cart.config.orders_id; //$('#sys_orders_id_' + product_id).val();

                $.ajax({
                    url: WEB_ROOT + 'ordersStep3',
                    data: {
                        orders_id: orders_id,
                        orders_delivery: Cart.config.orders_delivery,
                        amount: Cart.config.amount,
                        email: Cart.config.email,
                        phone: Cart.config.phone,
                        fullname: Cart.config.fullname,
                        orders_delivery: Cart.config.orders_delivery,
                        address: Cart.config.address,
                        city: Cart.config.city,
                        districts: Cart.config.districts,
                        wards: Cart.config.wards,
                        street: Cart.config.street
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        sendingAjax=true;
                        _$this.find(".sys_over_loading").addClass("active");
                    },
                    success: function(res) {
                        sendingAjax=false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        if (res.intIsOK == 1) {
                            dataCouponStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                            Cart.order_step_4();
                        } else {
                            alert(res.error);
                            return false;
                        }
                    },
                    error:function(){
                        sendingAjax=false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        _$this.find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
    },
    order_step_4:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep3);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameCouponStep4);

        if(Cart.config.orders_delivery == 2) {
            $('#sys_delivery_type').html('Giao hàng tận nơi');
        } else {
            $('#sys_delivery_type').html('Nhận mã số phiếu qua sms');
        }

        if(Cart.config.payment_type == 1) {
            $('#sys_payment_type').html('Thanh toán online qua thẻ ATM/Visa/Master hoặc Internet Banking');
        } else if(Cart.config.payment_type == 2) {
            $('#sys_payment_type').html('Thu tiền tận nơi (COD)');
        } else {
            $('#sys_payment_type').html('Thanh toán trực tiếp tại cửa hàng');
        }

        var orders_id = Cart.config.orders_id; //$('#sys_orders_id_' + product_id).val();
        $(".xxxDropdown").xxxDropdown();

        //if(Cart.config.orders_delivery == 1) {
        //    $('#sys_phone_info').html(Cart.config.phone);
        //    $("#sys_buy_supplier").show();
        //    $("#sys_buy_office").hide();
        //} else {
            $('#sys_fullname_orders').html(Cart.config.fullname);
            $('#sys_phone_orders_2').html(Cart.config.phone);
            $('#sys_email_orders').html(Cart.config.email);
            $('#sys_address_orders').html(Cart.config.address);
            if (Cart.config.orders_delivery != 2) {
                $('.sys_address_customer').hide();
            }
            $("#sys_buy_supplier").hide();
            $("#sys_buy_office").show();
        //}
        $("#sys_product_name_buy").html(product_name);
        $("#sys_product_img_buy").prop('src',product_img);

        var price_buy = parseInt(Cart.config.price);
        $("#sys_price_buy").html(price_buy.format(0, 3, '.', ',') +' đ');
        $("#sys_amount_buy").html(Cart.config.amount);
        var total_price_buy = parseInt(Cart.config.price) * parseInt(Cart.config.amount);
        $("#total_price_sale").html(total_price_buy.format(0, 3, '.', ',') + ' đ');

        $('#sys_order_step_4').on('click', function() {
            if(Cart.config.payment_type == 1) {
                $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                window.location = WEB_ROOT + 'requestSohaPay/' + orders_id + '/' + Cart.config.phone + '/' + Cart.config.email;
            } else {
                $.ajax({
                    url: WEB_ROOT + 'ordersStep2',
                    data: {orders_id: orders_id, payment_type:Cart.config.payment_type},
                    dataType: 'json',
                    beforeSend: function() {
                        sendingAjax=true;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                    },
                    success: function(res) {
                        sendingAjax=false;
                        window.location = res.url;
                    },
                    error:function(){
                        sendingAjax=false;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                        $("#" + settingPopupOrderId).find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
        $('#sys_order_back_3').on('click', function() {
            Cart.order_step_3(true);
        });
    },


    order_step_product_1: function(isBack,isInsideAPopup, popupInsideId) {
        Cart.config.orders_type = 2;
        // popupInsideId: Popup in other page
        if (settingPopupOrderId == null)
            settingPopupOrderId = (popupInsideId) ? popupInsideId : "sys_popup_shop_order";
        if(isInsideAPopup == undefined || isInsideAPopup == false) {
            if(isBack == undefined || isBack == false)
                $.popupCommon2({
                    attrId: settingPopupOrderId,
                    widthPop: "914px",
                    successOpen: function () {},
                    preClose: function () {
                        settingPopupOrderId = null;
                    }
                });
        }
        var _$this = $("#" + settingPopupOrderId);
        if(isBack)
            _$this.find(".main-content").html(dataCouponStep1);
        else
            _$this.find(".main-content").html(frameProductStep1);
        $(".xxxDropdown").xxxDropdown();
        $(".sys_option_payment").on("click",function(){
            $(".sys_option_payment").removeClass("active");
            $(this).addClass("active");
        });
        $("#sys_order_step_2").on("click", function () {
            Cart.config.payment_type = parseInt($("input:radio[name='payment_type']:checked").val());
            //Cart.config.amount = $('#buy_number_' + product_id).val();
            Cart.config.phone = '0977511928'; //$('#sys_mobile').val();
            //var campaign_product_id = $('#campaign_product_id_' + product_id).val();

            Cart.config.amount = $('#buy_number_' + product_id).val();
            if(Cart.config.amount == 0 || Cart.config.amount == undefined || Cart.config.amount == 'undefined') {
                Cart.config.amount = $.cookie('ck_amount_buy_slide');
            }
            var campaign_product_id = $('#campaign_product_id_' + product_id).val();
            if(campaign_product_id == 0 || campaign_product_id == undefined || campaign_product_id == 'undefined') {
                campaign_product_id = $.cookie('ck_campaign_products_id');
            }


            var store_supplier_id = $('input[name=store_supplier_id]:checked').val();
            if(Cart.valid_step_1()) {
                if(!sendingAjax) {
                    if(Cart.config.payment_type == 1) {
                        $('#sys_get_supplier').css('display', 'block');
                        $('#sys_get_office').css('display', 'none');
                        $.ajax({
                            url: WEB_ROOT + 'createOrders',
                            data: {
                                id: campaign_product_id,
                                amount: Cart.config.amount,
                                phone: Cart.config.phone,
                                payment_type: Cart.config.payment_type,
                                orders_type: Cart.config.orders_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                sendingAjax = true;
                                _$this.find(".sys_over_loading").addClass("active");
                            },
                            success: function(res) {
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                if (res.intIsOK == 1) {
                                    /*if(Cart.config.orders_delivery == 1 && (parseInt(res.numOfStore) < Cart.config.amount)) {
                                     $("#sys_lbl_store_"+ store_supplier_id).addClass("disabled").children(".log-error").fadeIn().end().children("input").attr({
                                     checked:false,
                                     disabled:true
                                     });
                                     } else {*/
                                    Cart.config.orders_id = res.order_id;
                                    //$('#sys_orders_id_' + product_id).val(res.order_id);
                                    dataCouponStep1 = _$this.find(".sys_popup_order");
                                    Cart.order_product_step_2_1();
                                    /*}*/
                                }else{
                                    if(res.msg) {
                                        alert(res.msg);
                                    }
                                    else {
                                        alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                    }
                                    return false;
                                }
                            },
                            error:function(){
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                _$this.find(".sys_form_log_total").removeClass("hide-elem");
                                console.log("Co loi xay ra");
                            }
                        });
                    } else if(Cart.config.payment_type == 2) {
                        $('#sys_get_supplier').css('display', 'none');
                        $('#sys_get_office').css('display', 'block');
                        $.ajax({
                            url: WEB_ROOT + 'createOrders',
                            data: {
                                id: campaign_product_id,
                                amount: Cart.config.amount,
                                phone: Cart.config.phone,
                                payment_type: Cart.config.payment_type,
                                orders_type: Cart.config.orders_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                sendingAjax=true;
                                _$this.find(".sys_over_loading").addClass("active");
                            },
                            success: function(res) {
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                if (res.intIsOK == 1) {
                                    Cart.config.orders_id = res.order_id;
                                    dataCouponStep1 = _$this.find(".sys_popup_order");
                                    Cart.order_product_step_2_2();
                                } else{
                                    if(res.msg) {
                                        alert(res.msg);
                                    }
                                    else {
                                        alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                    }
                                    return false;
                                }
                            },
                            error:function(){
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                _$this.find(".sys_form_log_total").removeClass("hide-elem");
                                console.log("Co loi xay ra");
                            }
                        });
                    } else {
                        $('#sys_get_supplier').css('display', 'none');
                        $('#sys_get_office').css('display', 'block');
                        $.ajax({
                            url: WEB_ROOT + 'createOrders',
                            data: {
                                id: campaign_product_id,
                                amount: Cart.config.amount,
                                phone: Cart.config.phone,
                                payment_type: Cart.config.payment_type,
                                orders_type: Cart.config.orders_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                sendingAjax=true;
                                _$this.find(".sys_over_loading").addClass("active");
                            },
                            success: function(res) {
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                if (res.intIsOK == 1) {
                                    Cart.config.orders_id = res.order_id;

                                    //$('#sys_orders_id_' + product_id).val(res.order_id);
                                    dataCouponStep1 = _$this.find(".sys_popup_order");
                                    Cart.order_product_step_2_3();
                                } else{
                                    if(res.msg) {
                                        alert(res.msg);
                                    }
                                    else {
                                        alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                    }
                                    return false;
                                }
                            },
                            error:function(){
                                sendingAjax=false;
                                _$this.find(".sys_over_loading").removeClass("active");
                                _$this.find(".sys_form_log_total").removeClass("hide-elem");
                                console.log("Co loi xay ra");
                            }
                        });
                    }
                }else{
                    console.log("dang xu ly");
                }
            }else{
                console.log("Có lỗi xảy ra, vui lòng kiểm tra lại code.");
            }
        });

        /* init popup's position */
        if(isBack==undefined || isBack == false) {
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
        }
    },
    order_product_step_2_1:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep2_1);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameProductStep2_1);

        $("#sys_order_back_1").on("click", function () {
            Cart.order_step_product_1(true);
        });
        $("#sys_order_step_3").on("click", function () {
            Cart.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            if(Cart.config.orders_delivery == 1){
                Cart.config.store_supplier_id = parseInt($("input:radio[name='store_supplier_id']:checked").val());
            }
            dataCouponStep2_1 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            Cart.order_step_product_3();
        });
        $(".sys_orders_delivery").on('change', function () {
            if($("input:radio[name=orders_delivery]:checked").val() == 2){
                $("#sys_address_home").removeClass('hidden');
                $("#sys_address_shop").addClass('hidden');
            }else{
                $("#sys_address_home").addClass('hidden');
                $("#sys_address_shop").removeClass('hidden');
            }
        });
    },
    order_product_step_2_2:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep2_2);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameProductStep2_2);

        $("#sys_order_back_1").on("click", function () {
            Cart.order_step_product_1(true);
        });
        $(" #sys_order_step_3").on("click", function () {
            Cart.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            dataCouponStep2_2 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            Cart.order_step_product_3();
        });
    },
    order_product_step_2_3:function(isBack){
        var _$this = $("#" + settingPopupOrderId);
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep2_3);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameProductStep2_3);

        $("#sys_order_back_1").on("click", function () {
            Cart.order_step_product_1(true);
        });
        $(" #sys_order_step_3").on("click", function () {
            Cart.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            Cart.config.store_supplier_id = parseInt($("input:radio[name='store_supplier_id']:checked").val());
            dataCouponStep2_3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            var orders_id = Cart.config.orders_id; //$('#sys_orders_id_' + product_id).val();
            $.ajax({
                url: WEB_ROOT + 'ordersStep4',
                data: {
                    orders_id: orders_id,
                    store_supplier_id: Cart.config.store_supplier_id
                },
                dataType: 'json',
                beforeSend: function() {
                    sendingAjax=true;
                    _$this.find(".sys_over_loading").addClass("active");
                },
                success: function(res) {
                    sendingAjax=false;
                    _$this.find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        dataCouponStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                        Cart.order_step_product_3();
                    } else {
                        alert('Số lượng hàng trong kho không đủ, bạn vui lòng chọn kho khác');
                        return false;
                    }
                },
                error:function(){
                    sendingAjax=false;
                    _$this.find(".sys_over_loading").removeClass("active");
                    _$this.find(".sys_form_log_total").removeClass("hide-elem");
                    console.log("Co loi xay ra");
                }
            });
        });
    },
    order_step_product_3:function(isBack){
        // popupInsideId: Popup in other page

        var _$this = $("#" + settingPopupOrderId);

        if(isBack) {
            $("#" + settingPopupOrderId).find(".main-content").html(dataCouponStep3);
        } else
            $("#" + settingPopupOrderId).find(".main-content").html(frameProductStep3);


        if (Cart.config.orders_delivery != 2) {
            $(".sys_customer_home_info").addClass('hidden');
        }
        $(".xxxDropdown").xxxDropdown();
        $("#sys_order_back_2").on("click", function () {
            if(Cart.config.payment_type == 1) {
                Cart.order_product_step_2_1(true);
            } else if(Cart.config.payment_type == 2) {
                Cart.order_product_step_2_2(true);
            }else if(Cart.config.payment_type == 3){
                Cart.order_product_step_2_3(true);
            }
        });
        $(" #sys_order_step_4").on("click", function () {
            if(Cart.valid_step_3()) {
                var orders_id = Cart.config.orders_id; //$('#sys_orders_id_' + product_id).val();
                $.ajax({
                    url: WEB_ROOT + 'ordersStep3',
                    data: {
                        orders_id: orders_id,
                        orders_delivery: Cart.config.orders_delivery,
                        store_supplier_id: Cart.config.store_supplier_id,
                        amount: Cart.config.amount,
                        email: Cart.config.email,
                        phone: Cart.config.phone,
                        fullname: Cart.config.fullname,
                        orders_delivery: Cart.config.orders_delivery,
                        address: Cart.config.address,
                        city: Cart.config.city,
                        districts: Cart.config.districts,
                        wards: Cart.config.wards,
                        street: Cart.config.street
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        sendingAjax=true;
                        _$this.find(".sys_over_loading").addClass("active");
                    },
                    success: function(res) {
                        sendingAjax=false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        if (res.intIsOK == 1) {
                            dataCouponStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                            Cart.order_step_product_4();
                        } else {
                            alert(res.error);
                            return false;
                        }
                    },
                    error:function(){
                        sendingAjax=false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        _$this.find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
    },
    order_step_product_4:function(isBack){
        if(isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataProductStep3);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameProductStep4);

        if(Cart.config.orders_delivery == 2) {
            $('#sys_delivery_type').html('Giao hàng tận nơi');
        } else {
            $('#sys_delivery_type').html('Đến nhận hàng tại cửa hàng');
        }

        if(Cart.config.payment_type == 1) {
            $('#sys_payment_type').html('Thanh toán online qua thẻ ATM/Visa/Master hoặc Internet Banking');
        } else if(Cart.config.payment_type == 2) {
            $('#sys_payment_type').html('Thu tiền tận nơi (COD)');
        } else {
            $('#sys_payment_type').html('Thanh toán trực tiếp tại cửa hàng');
        }

        var orders_id = Cart.config.orders_id;//$('#sys_orders_id_' + product_id).val();
        $(".xxxDropdown").xxxDropdown();
        //if(Cart.config.orders_delivery == 1) {
        //    $('#sys_phone_info').html(Cart.config.phone);
        //    $("#sys_buy_supplier").show();
        //    $("#sys_buy_office").hide();
        //} else {
            $('#sys_fullname_orders').html(Cart.config.fullname);
            $('#sys_phone_orders_2').html(Cart.config.phone);
            $('#sys_email_orders').html(Cart.config.email);
            $('#sys_address_orders').html(Cart.config.address);
            if(Cart.config.orders_delivery != 2){
                $('.sys_address_customer').hide();
            }
            $("#sys_buy_supplier").hide();
            $("#sys_buy_office").show();
        //}
        $("#sys_product_name_buy").html(product_name);
        $("#sys_product_img_buy").prop('src',product_img);
        var price_buy = parseInt(Cart.config.price);
        $("#sys_price_buy").html(price_buy.format(0, 3, '.', ',') +' đ');
        $("#sys_amount_buy").html(Cart.config.amount);
        var total_price_buy = parseInt(Cart.config.price) * parseInt(Cart.config.amount);
        $("#total_price_sale").html(total_price_buy.format(0, 3, '.', ',') + ' đ');

        $('#sys_order_step_4').on('click', function() {
            if(Cart.config.payment_type == 1) {
                $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                window.location = WEB_ROOT + 'requestSohaPay/' + orders_id + '/' + Cart.config.phone + '/' + Cart.config.email;
            } else {
                $.ajax({
                    url: WEB_ROOT + 'ordersStep2',
                    data: {orders_id: orders_id, payment_type:Cart.config.payment_type},
                    dataType: 'json',
                    beforeSend: function() {
                        sendingAjax=true;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                    },
                    success: function(res) {
                        sendingAjax=false;
                        window.location = res.url;
                    },
                    error:function(){
                        sendingAjax=false;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                        $("#" + settingPopupOrderId).find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
        $('#sys_order_back_3').on('click', function() {
            Cart.order_step_product_3(true);
        });
    },

    loadDistricts: function(id) {
        if(id > 0) {
            $.ajax({
                url: WEB_ROOT + 'loadDistricts',
                data: {id: id},
                dataType: 'json',
                beforeSend: function() {
                    sendingAjax=true;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                },
                complete: function() {
                    //Hoàn thành
                },
                success: function(res) {
                    sendingAjax=false;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        $('#districts_default').html('--- Chọn quận huyện ---');
                        if(id == 29) {
                            $("#sys_wards").css('display','block');
                            $('#districts').attr('onchange','Cart.loadWards(this.value)');
                        }else{
                            $("#sys_wards").css('display','none');
                        }
                        $('#districts').html(res.html);
                    }
                }
            });
        } else {
            $("#sys_wards").css('display','none');
            alert('Mã tỉnh/thành phố không đúng');
        }
    },

    loadWards: function(id) {
        if(id > 0) {
            $.ajax({
                url: WEB_ROOT + 'loadWards',
                data: {id: id},
                dataType: 'json',
                beforeSend: function() {
                    sendingAjax=true;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                },
                complete: function() {
                    //Hoàn thành
                },
                success: function(res) {
                    sendingAjax=false;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        $('#wards_default').html('--- Chọn phường xã ---');
                        $('#sys_wards').show();
                        $('#wards').html(res.html);
                    }
                }
            });
        } else {
            alert('Mã quận/huyện không đúng');
        }
    }

};

/*ui*/
$(function(){

    var campaign_product_id = $.cookie('ck_campaign_products_id');
    var s_supplier_id = $.cookie('ck_supplier_id');
    var s_statusBuy = $.cookie('ck_status_buy');
    var s_buy_product = $.cookie('ck_campaign_type');
    var s_product_id = $.cookie('ck_product_id');

    if(s_statusBuy == 1) {
        $.cookie('ck_status_buy', 0 , {path: '/', domain: '.muachung.vn'});
        product_id = s_product_id;
        if(!sendingAjax) {
            Cart.config.price = $.cookie('ck_product_price');
            $.ajax({
                url: WEB_ROOT + 'home/detailPopupProduct',
                data: {
                    id: campaign_product_id,
                    supplier_id:s_supplier_id
                },
                dataType: 'json',
                beforeSend:function(){
                    sendingAjax = true;
                    $(".sys_log_error_begin_order").remove();
                },
                error: function () {
                    sendingAjax = false;
                },
                success: function (res) {
                    sendingAjax = false;
                    $("#sys_hidden_data_deal").html(res.hiddenData);
                    product_name = $("#sys_product_name_" + product_id).val();
                    product_img = $("#sys_product_img_" + product_id).val();
                    frameStep1 = res.step1;
                    frameStep2_1 = res.step21;
                    frameStep2_2 = res.step22;
                    frameStep3 = res.step3;

                    frameCouponStep1 = res.step_coupon_1;
                    frameCouponStep2_1 = res.step_coupon_2_1;
                    frameCouponStep2_2 = res.step_coupon_2_2;
                    frameCouponStep3 = res.step_coupon_3;
                    frameCouponStep4 = res.step_coupon_4;

                    frameProductStep1 = res.step_product_1;
                    frameProductStep2_1 = res.step_product_2_1;
                    frameProductStep2_2 = res.step_product_2_2;
                    frameProductStep2_3 = res.step_product_2_3;
                    frameProductStep3 = res.step_product_3;
                    frameProductStep4 = res.step_product_4;

                    if(s_buy_product == 1) {
                        Cart.start(1);
                    } else {
                        Cart.start();
                    }
                }
            });
        }
    }




    $("body").on("click",".sys_btn_order",function(){
        var $this= $(this);
        var campaign_product_id = $(this).attr('data-campaign-product-id');
        var supplier_id = $(this).attr('data-supplier-id');
        var buy_product = $("#sys_buy_product").val();
        product_id = $(this).attr('data-value');
        if(!sendingAjax) {
            $.ajax({
                url: WEB_ROOT + 'home/detailPopupProduct',
                data: {
                    id: campaign_product_id,
                    supplier_id:supplier_id
                },
                dataType: 'json',
                beforeSend:function(){
                    sendingAjax = true;
                    $this.addClass("disabled");
                    $(".sys_log_error_begin_order").remove();
                },
                error: function () {
                    sendingAjax = false;
                    $this.removeClass("disabled").parents(".grp-action-order").next().remove().end().after('<p class="sys_log_error_begin_order rs fc-red ta-c pt-15">Quá trình xử lý không thành công, liên hệ quản trị để được hỗ trợ ngay.</p>').fadeIn();
                },
                success: function (res) {
                    sendingAjax = false;
                    $this.removeClass("disabled");
                    $("#sys_hidden_data_deal").html(res.hiddenData);
                    product_name = $("#sys_product_name_" + product_id).val();
                    product_img = $("#sys_product_img_" + product_id).val();
                    Cart.config.price = $("#sys_price_" + product_id).val();
                    frameStep1 = res.step1;
                    frameStep2_1 = res.step21;
                    frameStep2_2 = res.step22;
                    frameStep3 = res.step3;

                    frameCouponStep1 = res.step_coupon_1;
                    frameCouponStep2_1 = res.step_coupon_2_1;
                    frameCouponStep2_2 = res.step_coupon_2_2;
                    frameCouponStep3 = res.step_coupon_3;
                    frameCouponStep4 = res.step_coupon_4;

                    frameProductStep1 = res.step_product_1;
                    frameProductStep2_1 = res.step_product_2_1;
                    frameProductStep2_2 = res.step_product_2_2;
                    frameProductStep2_3 = res.step_product_2_3;
                    frameProductStep3 = res.step_product_3;
                    frameProductStep4 = res.step_product_4;

                    var buy_product = $("#sys_product_campaign_type_" + product_id).val();
                    if(buy_product == 1) {
                        Cart.start(1);
                    } else {
                        Cart.start();
                    }
                }
            });
        }
        return false;
    });
});
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
