var dataStep1 = null;
var dataStep2_1 = null;
var dataStep2_2 = null;
var dataStep2_3 = null;
var dataStep3 = null;
var dataStep4 = null;
var frameStep1 = null;
var frameStep2_1 = null;
var frameStep2_2 = null;
var frameStep2_3 = null;
var frameStep3 = null;
var frameStep4 = null;
var settingPopupOrderId = null;

$(function () {
    $("#sys_btn_order").on('click', function () {
        var $this = $(this);
        var product_id = $(this).attr('data-id');
        if (!sendingAjax) {
            $.ajax({
                url: WEB_ROOT + 'home/detailPopupProduct',
                data: {
                    id: product_id
                    //supplier_id: supplier_id
                },
                dataType: 'json',
                beforeSend: function () {
                    sendingAjax = true;
                    $this.addClass("disabled");
                    $(".sys_log_error_begin_order").remove();
                },
                error: function () {
                    sendingAjax = false;
                    $this.removeClass("disabled").parents(".grp-action-order").next().remove().end().after('<p class="sys_log_error_begin_order rs fc-red ta-c pt-15">Quá trình xử lý không thành công, liên hệ quản trị để được hỗ trợ ngay.</p>').fadeIn();
                },
                success: function (res) {
                    if (res.intIsOK == 1) {
                        sendingAjax = false;
                        frameStep1 = res.data.step_1;
                        frameStep2_1 = res.data.step_2_1;
                        frameStep2_2 = res.data.step_2_2;
                        frameStep2_3 = res.data.step_2_3;
                        frameStep3 = res.data.step_3;
                        frameStep4 = res.data.step_4;
                    }
                    Order.start();
                }
            });
        }
        return false;
    })

    var open_order = jQuery.cookie('open_orders');
    if(open_order == 1){
        jQuery.cookie('open_orders',0, {path: '/', domain: COOKIE_DOMAIN});
        $("#sys_btn_order").trigger("click");
    }

})
var Order = {
    config: {
        orders_id:0,
        payment_type: 0,
        orders_delivery:0,
        orders_note: '',
        store_supplier_id:0,
        fee:0,
        amount: 0,
        email: '',
        phone: '',
        fullname: '',
        address: '',
        city: 0,
        districts: 0,
        wards: 0,
        city_name: '',
        district_name: '',
        ward_name: '',
        street: 0,
        street_name: ''
    },
    start: function () {
        this.order_step_1();
    },
    order_step_1: function (isBack, isInsideAPopup, popupInsideId) {
        // popupInsideId: Popup in other page
        if (settingPopupOrderId == null)
            settingPopupOrderId = "sys_popup_shop_order";
        if (isBack == undefined || isBack == false)
            $.popupCommon2({
                attrId: settingPopupOrderId,
                widthPop: "914px",
                successOpen: function () {
                    $("#sys_btn_order").removeClass("disabled");
                },
                preClose: function () {
                    settingPopupOrderId = null;

                }
            });
        var _$this = $("#" + settingPopupOrderId);
        if (isBack)
            _$this.find(".main-content").html(dataStep1);
        else
            _$this.find(".main-content").html(frameStep1);
        $(".xxxDropdown").xxxDropdown();
        $(".sys_option_payment").on("click", function () {
            $(".sys_option_payment").removeClass("active");
            $(this).addClass("active");
        });
        $("#sys_order_step_2").on("click", function () {
            Order.config.payment_type = parseInt($("input:radio[name='payment_type']:checked").val());

            Order.config.amount = $('#buy_number').val();
            //if (Order.config.amount == 0 || Order.config.amount == undefined || Order.config.amount == 'undefined') {
            //    Order.config.amount = $.cookie('ck_amount_buy_slide');
            //}
            //var campaign_product_id = $('#campaign_product_id_' + product_id).val();
            //if (campaign_product_id == 0 || campaign_product_id == undefined || campaign_product_id == 'undefined') {
            //    campaign_product_id = $.cookie('ck_campaign_products_id');
            //}

            var store_supplier_id = $('input[name=store_supplier_id]:checked').val();
            if (!sendingAjax) {
                if (Order.config.payment_type > 0) {
                    $('#sys_get_supplier').css('display', 'block');
                    $('#sys_get_office').css('display', 'none');
                    $.ajax({
                        url: WEB_ROOT + 'createOrders',
                        data: {
                            id: product_id,
                            amount: Order.config.amount,
                            payment_type: Order.config.payment_type
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            sendingAjax = true;
                            _$this.find(".sys_over_loading").addClass("active");
                        },
                        success: function (res) {
                            sendingAjax = false;
                            _$this.find(".sys_over_loading").removeClass("active");
                            if (res.intIsOK == 1) {
                                Order.config.orders_id = res.order_id;
                                dataStep1 = _$this.find(".sys_popup_order");
                                if(Order.config.payment_type == 1){
                                    Order.order_step_2_1();
                                }else if(Order.config.payment_type == 2){
                                    Order.order_step_2_2();
                                }else if(Order.config.payment_type == 3){
                                    Order.order_step_2_3();
                                } else if(Order.config.payment_type == 4){
                                    Order.order_step_2_1();
                                }

                                /*}*/
                            } else {
                                if (res.msg) {
                                    alert(res.msg);
                                }
                                else {
                                    alert('Deal chưa chạy, bạn không thể tiếp tục đặt hàng');
                                }
                                return false;
                            }
                        },
                        error: function () {
                            sendingAjax = false;
                            _$this.find(".sys_over_loading").removeClass("active");
                            _$this.find(".sys_form_log_total").removeClass("hide-elem");
                            console.log("Co loi xay ra");
                        }
                    });
                }
            } else {
                console.log("dang xu ly");
            }
        });

        /* init popup's position */
        if (isBack == undefined || isBack == false) {
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
    order_step_2_1: function (isBack) {
        var _$this = $("#" + settingPopupOrderId);
        if (isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataStep2_1);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameStep2_1);

        $("#sys_order_back_1").on("click", function () {
            Order.order_step_1(true);
        });
        $("#sys_order_step_3").on("click", function () {
            Order.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            if(Order.config.orders_delivery == 3){
                Order.config.fee = 15000;
            }else{
                Order.config.fee = 0;
            }
            dataStep2_1 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            if (Order.config.orders_delivery == 1) {
                Order.config.store_supplier_id = parseInt($("input:radio[name='store_supplier_id']:checked").val());
                var orders_id = Order.config.orders_id; //$('#sys_orders_id_' + product_id).val();
                $.ajax({
                    url: WEB_ROOT + 'ordersStep4',
                    data: {
                        orders_id: orders_id,
                        store_supplier_id: Order.config.store_supplier_id
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        sendingAjax = true;
                        _$this.find(".sys_over_loading").addClass("active");
                    },
                    success: function (res) {
                        sendingAjax = false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        if (res.intIsOK == 1) {
                            dataStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                            Order.order_step_3();
                        } else {
                            alert('Số lượng hàng trong kho không đủ, bạn vui lòng chọn kho khác');
                            return false;
                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        _$this.find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            } else {
                Order.config.orders_note = $("#sys_request_customer").val();
                Order.order_step_3();
            }

        });
        $(".sys_orders_delivery").on('change', function () {
            if ($("input:radio[name=orders_delivery]:checked").val() == 2 || $("input:radio[name=orders_delivery]:checked").val() == 3) {
                $("#sys_address_home").removeClass('hidden');
                $("#sys_address_shop").addClass('hidden');
            } else {
                $("#sys_address_home").addClass('hidden');
                $("#sys_address_shop").removeClass('hidden');
            }
        });
    },
    order_step_2_2: function (isBack) {
        if (isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataStep2_2);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameStep2_2);

        $("#sys_order_back_1").on("click", function () {
            Order.order_step_1(true);
        });
        $(" #sys_order_step_3").on("click", function () {
            Order.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            Order.config.fee = 0;
            Order.config.orders_note = $("#sys_request_customer").val();
            dataStep2_2 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            Order.order_step_3();
        });
    },
    order_step_2_3: function (isBack) {
        var _$this = $("#" + settingPopupOrderId);
        if (isBack)
            $("#" + settingPopupOrderId).find(".main-content").html(dataStep2_3);
        else
            $("#" + settingPopupOrderId).find(".main-content").html(frameStep2_3);

        $("#sys_order_back_1").on("click", function () {
            Order.order_step_1(true);
        });
        $(" #sys_order_step_3").on("click", function () {
            Order.config.orders_delivery = parseInt($("input:radio[name='orders_delivery']:checked").val());
            Order.config.fee = 0;
            Order.config.store_supplier_id = parseInt($("input:radio[name='store_supplier_id']:checked").val());
            Order.config.orders_note = $("#sys_request_customer").val();
            dataStep2_3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
            var orders_id = Order.config.orders_id; //$('#sys_orders_id_' + product_id).val();
            $.ajax({
                url: WEB_ROOT + 'ordersStep4',
                data: {
                    orders_id: orders_id,
                    store_supplier_id: Order.config.store_supplier_id
                },
                dataType: 'json',
                beforeSend: function () {
                    sendingAjax = true;
                    _$this.find(".sys_over_loading").addClass("active");
                },
                success: function (res) {
                    sendingAjax = false;
                    _$this.find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        dataStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                        Order.order_step_3();
                    } else {
                        alert('Số lượng hàng trong kho không đủ, bạn vui lòng chọn kho khác');
                        return false;
                    }
                },
                error: function () {
                    sendingAjax = false;
                    _$this.find(".sys_over_loading").removeClass("active");
                    _$this.find(".sys_form_log_total").removeClass("hide-elem");
                    console.log("Co loi xay ra");
                }
            });
        });
    },
    order_step_3: function (isBack) {
        // popupInsideId: Popup in other page

        var _$this = $("#" + settingPopupOrderId);

        if (isBack) {
            $("#" + settingPopupOrderId).find(".main-content").html(dataStep3);
        } else
            $("#" + settingPopupOrderId).find(".main-content").html(frameStep3);


        if (Order.config.orders_delivery != 2 && Order.config.orders_delivery != 3) {
            $(".sys_customer_home_info").addClass('hidden');
        }
        $(".xxxDropdown").xxxDropdown();
        $("#sys_order_back_2").on("click", function () {
            if (Order.config.payment_type == 1) {
                Order.order_step_2_1(true);
            } else if (Order.config.payment_type == 2) {
                Order.order_step_2_2(true);
            } else if (Order.config.payment_type == 3) {
                Order.order_step_2_3(true);
            } else if(Order.config.payment_type == 4){
                Order.order_step_2_1(true);
            }
        });
        $("#sys_order_step_4").on("click", function () {
            $("#sys_customer_pass").addClass('hidden');
            if(Order.config.payment_type == 2 || (Order.config.payment_type == 1 && Order.config.orders_delivery == 2) || (Order.config.payment_type == 1 && Order.config.orders_delivery == 3)){
                Order.config.store_supplier_id = 0;
            }
            if (Order.valid_step_3()) {
                var orders_id = Order.config.orders_id; //$('#sys_orders_id_' + product_id).val();
                $.ajax({
                    url: WEB_ROOT + 'ordersStep3',
                    data: {
                        orders_id: orders_id,
                        orders_delivery: Order.config.orders_delivery,
                        orders_note: Order.config.orders_note,
                        store_supplier_id: Order.config.store_supplier_id,
                        amount: Order.config.amount,
                        email: Order.config.email,
                        phone: Order.config.phone,
                        fullname: Order.config.fullname,
                        address: Order.config.address,
                        city: Order.config.city,
                        districts: Order.config.districts,
                        wards: Order.config.wards,
                        city_name: Order.config.city_name,
                        district_name: Order.config.district_name,
                        ward_name: Order.config.ward_name,
                        street: Order.config.street,
                        street_name: Order.config.street_name
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        sendingAjax = true;
                        _$this.find(".sys_over_loading").addClass("active");
                    },
                    success: function (res) {
                        sendingAjax = false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        var customer_order  = {
                            key: customer_key,
                            email: $("#email").val(),
                            phone: $("#phone").val(),
                            fullname: $("#fullname").val(),
                            address: $("#address").val(),
                            city: $("#city").val(),
                            districts: $("#districts").val(),
                            wards: $("#wards").val(),
                            street: $("#street").val()
                        };
                        var arrData = [customer_order];
                        jQuery.cookie('customer_order',JSON.stringify(customer_order),{expires: 365,path: '/', domain: COOKIE_DOMAIN});
                        if (res.intIsOK == 1) {
                            dataStep3 = $("#" + settingPopupOrderId).find(".sys_popup_order");
                            Order.order_step_4();
                        } else {
                            alert(res.error);
                            return false;
                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        _$this.find(".sys_over_loading").removeClass("active");
                        _$this.find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
    },

    order_step_4: function (isBack) {
        //if (isBack)
        //    $("#" + settingPopupOrderId).find(".main-content").html(dataProductStep3);
        //else
            $("#" + settingPopupOrderId).find(".main-content").html(frameStep4);

        if (Order.config.orders_delivery == 2) {
            $('#sys_delivery_type').html('Giao hàng tận nơi');
        } else {
            if(product_type == 1)
                $('#sys_delivery_type').html('Đến nhận hàng tại cửa hàng');
            else
                $('#sys_delivery_type').html('Nhận mã số phiếu qua sms');
        }

        if (Order.config.payment_type == 1) {
            $('#sys_payment_type').html('Thanh toán online qua thẻ ATM/Visa/Master hoặc Internet Banking');
        } else if (Order.config.payment_type == 4) {
            $('#sys_payment_type').html('Thanh toán bằng ví điện tử muachung');
            $("#sys_customer_pass").removeClass('hidden');
        } else if (Order.config.payment_type == 2) {
            $('#sys_payment_type').html('Thu tiền tận nơi (COD)');
        } else {
            $('#sys_payment_type').html('Thanh toán trực tiếp tại cửa hàng');
        }

        var orders_id = Order.config.orders_id;//$('#sys_orders_id_' + product_id).val();
        $(".xxxDropdown").xxxDropdown();
        $('#sys_fullname_orders').html(Order.config.fullname);
        $('#sys_phone_orders_2').html(Order.config.phone);
        $('#sys_email_orders').html(Order.config.email);
        var htm = Order.config.address;
        if(Order.config.street != ''){
            htm += ', ' + Order.config.street_name;
        }
        if (Order.config.ward_name != '') {
            htm += ', ' + Order.config.ward_name;
        }
        if (Order.config.district_name != '') {
            htm += ', ' + Order.config.district_name;
        }
        if (Order.config.street != '') {
            htm += ', ' + Order.config.city_name;
        }
        $('#sys_address_orders').html(htm);
        if (Order.config.orders_delivery != 2) {
            $('.sys_address_customer').hide();
        }
        $("#sys_buy_supplier").hide();
        $("#sys_buy_office").show();
        //}
        $("#sys_product_name_buy").html(product_name);
        $("#sys_product_img_buy").prop('src', product_img);
        var price_buy = parseInt($("#sys_price").val());
        $("#sys_price_buy").html(price_buy.format(0, 3, '.', ',') + ' đ');
        $("#sys_amount_buy").html(Order.config.amount);
        var total_fee = parseInt(Order.config.fee);
        var total_price_buy = parseInt(price_buy) * parseInt(Order.config.amount) + parseInt(Order.config.fee);
        $("#total_price_sale").html(total_price_buy.format(0, 3, '.', ',') + ' đ');
        $("#total_fee").html(total_fee.format(0, 3, '.', ',') + ' đ');

        $('#sys_order_step_4').on('click', function () {
            if (Order.config.payment_type == 1) {
                $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                window.location = WEB_ROOT + 'requestSohaPay/' + orders_id + '/' + Order.config.phone + '/' + Order.config.email;
            } else {
                var pass = $("#password_customer_mc").val()
                $.ajax({
                    url: WEB_ROOT + 'ordersStep2',
                    data: {orders_id: orders_id, payment_type: Order.config.payment_type, password: pass},
                    dataType: 'json',
                    beforeSend: function () {
                        sendingAjax = true;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                    },
                    success: function (res) {
                        sendingAjax = false;
                        if(res.intIsOK == 1) {
                            window.location = res.url;
                        } else if(res.intIsOK == -1) {
                            if(res.mess){
                                alert(res.mess);
                            }else{
                                alert('Tài khoản của bạn không đủ Tiền để thực hiện đơn hàng này.');
                            }
                            $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                            return false;
                        }
                    },
                    error: function () {
                        sendingAjax = false;
                        $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                        $("#" + settingPopupOrderId).find(".sys_form_log_total").removeClass("hide-elem");
                        console.log("Co loi xay ra");
                    }
                });
            }
        });
        $('#sys_order_back_3').on('click', function () {
            Order.order_step_3(true);
        });
    },

    loadDistricts: function (id) {
        if (id > 0) {
            $.ajax({
                url: WEB_ROOT + 'loadDistricts',
                data: {id: id},
                dataType: 'json',
                beforeSend: function () {
                    sendingAjax = true;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                },
                complete: function () {
                    //Hoàn thành
                },
                success: function (res) {
                    sendingAjax = false;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        $('#districts_default').html('--- Chọn quận huyện ---');
                        if (id == 29) {
                            $("#sys_wards").css('display', 'block');
                            $("#sys_street").css('display', 'none');
                            $('#districts').attr('onchange', 'Order.loadWards(this.value)');
                        } else if (id == 22) {
                            $("#sys_wards").css('display', 'none');
                            $("#sys_street").css('display', 'block');
                            $('#districts').attr('onchange', 'Order.loadStreet(this.value)');
                        }
                        $('#districts').html(res.html);
                    }
                }
            });
        } else {
            $("#sys_wards").css('display', 'none');
            alert('Mã tỉnh/thành phố không đúng');
        }
    },

    loadWards: function (id) {
        if (id > 0) {
            $.ajax({
                url: WEB_ROOT + 'loadWards',
                data: {id: id},
                dataType: 'json',
                beforeSend: function () {
                    sendingAjax = true;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                },
                complete: function () {
                    //Hoàn thành
                },
                success: function (res) {
                    sendingAjax = false;
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
    },

    loadStreet: function (id) {
        if (id > 0) {
            $.ajax({
                url: WEB_ROOT + 'loadStreet',
                data: {id: id},
                dataType: 'json',
                beforeSend: function () {
                    sendingAjax = true;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").addClass("active");
                },
                complete: function () {
                    //Hoàn thành
                },
                success: function (res) {
                    sendingAjax = false;
                    $("#" + settingPopupOrderId).find(".sys_over_loading").removeClass("active");
                    if (res.intIsOK == 1) {
                        $('#street_default').html('--- Chọn đường phố ---');
                        $('#sys_street').show();
                        $('#street').html(res.html);
                    }
                }
            });
        } else {
            alert('Mã quận/huyện không đúng');
        }
    },

    valid_step_3: function () {
        var isValid = true;
        //Valid họ, tên
        var fullname = $('#fullname').val();
        if (fullname == '') {
            $('#fullname').focus().siblings().hide().fadeIn();
            return false;
        } else
            $('#fullname').siblings().hide();
        this.config.fullname = fullname;
        //Valid số điện thoại
        var phone = $('#phone').val();
        if (!LibJS.is_phone(phone)) {
            $('#phone').focus().siblings().hide().fadeIn();
            return false;
        } else
            $('#phone').siblings().hide();
        this.config.phone = phone;
        //Valid số điện thoại
        var email = $('#email').val();
        if (email == '' || !LibJS.is_email(email)) {
            $('#email').focus().siblings().hide().fadeIn();
            return false;
        } else
            $('#email').siblings().hide();

        this.config.email = email;
        if (Order.config.orders_delivery == 2 || Order.config.orders_delivery == 3) {

            //Valid thành phố
            var city = $('#city').val();
            if (city <= 0) {
                $('#city').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                return false;
            } else
                $('#city').parents(".xxxDropdown").siblings().hide();

            this.config.city = city;
            this.config.city_name = $('#city').children(":selected").text();
            //Valid quận huyện
            var districts = $('#districts').val();
            if (districts <= 0) {
                $('#districts').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                return false;
            } else
                $('#districts').parents(".xxxDropdown").siblings().hide();

            this.config.district_name = $('#districts').children(":selected").text();
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
                this.config.ward_name = $('#wards').children(":selected").text();
            }
            //Valid duong pho
            //Valid phường xã
            if (this.config.city == 22) {
                var street = $('#street').val();
                if (street <= 0) {
                    $('#street').focus().parents(".xxxDropdown").siblings().hide().fadeIn();
                    return false;
                } else
                    $('#street').parents(".xxxDropdown").siblings().hide();
                this.config.street = street;
                this.config.street_name = $('#street').children(":selected").text();
            }
            //var street = $('#street').val();
            //if (street == '') {
            //    $('#street').focus().siblings().hide().fadeIn();
            //    return false;
            //} else
            //    $('#street').siblings().hide();
            //this.config.street = street;
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
    }
}
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
