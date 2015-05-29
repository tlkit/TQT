/**
 * User: tuanna
 * Date: 8/21/14
 * Time: 10:11 AM
 */
var Gold = {
    config:{
        type_payment:0,
        type_buy_up:0,
        gold_step_1:null,
        gold_step_2:null,
        gold_step_3:null,
        gold_step_4:null,
        card_step_1:null,
        buy_up_step_1:null,
        buy_up_step_2:null,
        buy_up_step_3:null,
        buy_up_card_step_2:null,
        title_popup:'',
        payment_tran:'',
        payment_money:0,
        buy_up_tran:'',
        buy_up_money:0,
        campaign_id:0,
        linkShop:'',
        supplier_wallet:new Array()
    },
    getSupplierWallet:function () {
        Gold.show_step_1();
        var _$this = $("#sys_popup_supplier_gold");
        $.ajax({
            url:WEB_ROOT + 'getAjaxSupplierWallet',
            type:'POST',
            dataType:'json',
            beforeSend:function () {
                _$this.find(".sys_over_loading").addClass("active");
            },
            complete:function () {
            },
            success:function (res) {
                if (res.isIntOK == 1) {
                    Gold.config.supplier_wallet = res.data;
                    _$this.find("#sys_supplier_name").html('Tên shop : ' + res.data.supplier_name);
                    _$this.find("#sys_supplier_gold").html('Số gold trong tài khoản : ' + res.data.wallet_supplier_value + ' GOLD');
                    Gold.config.title_popup = "Nạp gold cho shop " + res.data.supplier_name + "(còn " + res.data.wallet_supplier_value + " gold)"
                    _$this.find(".sys_over_loading").removeClass("active");
                    Gold.config.gold_step_1 = $("#sys_popup_supplier_gold").find('.sys_supplier_gold');
                } else {
                    _$this.find(".sys_over_loading").removeClass("active");
                    _$this.find("#sys_pop_gold_content").html('Không có thông tin shop bạn cần tìm');
                    return false;
                }
            },
            error:function () {
                _$this.find(".sys_over_loading").removeClass("active");
                _$this.find("#sys_pop_gold_content").html('Không có thông tin shop bạn cần tìm');
                //return false;
            }
        });
    },
    openPopupBuyUp:function(campaign_id){
        Gold.config.campaign_id = (campaign_id) ? campaign_id : 0;
        Gold.show_buy_up_step_1();
        var _$this = $("#sys_popup_supplier_buy_up");
        $.ajax({
            url:WEB_ROOT + 'getAjaxSupplierWallet',
            type:'POST',
            dataType:'json',
            beforeSend:function () {
                _$this.find(".sys_over_loading").addClass("active");
            },
            complete:function () {
            },
            success:function (res) {

                if (res.isIntOK == 1) {
                    Gold.config.supplier_wallet = res.data;
                    if(Gold.config.campaign_id >0){
                        Gold.config.title_popup = "Mua lượt up cho Id: "+Gold.config.campaign_id;
                    }else{
                        Gold.config.title_popup = "Mua lượt up cho shop " + res.data.supplier_name + "(còn " + res.data.wallet_supplier_value + " gold)"
                    }

                    _$this.find(".sys_over_loading").removeClass("active");
                    _$this.find(".popup-title").html(Gold.config.title_popup);
                    Gold.config.buy_up_step_1 = _$this.find('.sys_supplier_buy_up');
                } else {
                    _$this.find(".sys_over_loading").removeClass("active");
                    _$this.find("#sys_pop_gold_content").html('Không có thông tin shop bạn cần tìm');
                    return false;
                }
            },
            error:function () {
                _$this.find(".sys_over_loading").removeClass("active");
                alert('Có lỗi xảy ra khi lấy dữ liệu');
                return false;
            }
        });
    },
    show_step_1:function (isBack) {
        $.popupCommon2({
            attrId:"sys_popup_supplier_gold",
            widthPop:"840px",
            successOpen:function () {
                var _$this = $("#sys_popup_supplier_gold");
                if (Gold.config.gold_step_1 == null) {
                    Gold.config.gold_step_1 = $("#supplier_gold_step_1").html();
                    _$this.find(".main-content").html(Gold.config.gold_step_1);
                    $("#supplier_gold_step_1").html("");
                } else {
                    _$this.find(".main-content").html(Gold.config.gold_step_1);
                }
                if (isBack == undefined) {
                    var popContent = _$this.find(".pop-content");
                    var setTopCSS, setLeftCSS;
                    setTopCSS = ($(window).height() - popContent.height()) / 2 - $(window).height() / 10;
                    if(setTopCSS <= 0){
                        _$this.css("position", "absolute");
                        var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
                        setTopCSS = pageOffetTop + 20;
                    }
                    setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
                    popContent.css({
                        "top":setTopCSS,
                        "left":setLeftCSS
                    });
                    _$this.css({
                        "display":"none",
                        "visibility":"visible"
                    });
                    _$this.fadeIn();
                }
            },
            preClose:function () {
            }
        });
    },
    show_step_2:function (isBack) {
        if (isBack == undefined) {
            Gold.config.payment_tran = $('input[name=opt_money]:checked').attr('data-type');
            Gold.config.payment_money = $('input[name=opt_money]:checked').val();
            if (!Gold.config.payment_tran || Gold.config.payment_tran == '') {
                alert('Bạn chưa chọn mệnh giá muốn nạp');
                return false;
            }
        }
        var _$this = $("#sys_popup_supplier_gold");
        if(Gold.config.payment_tran == 'transfer'){
            if (Gold.config.gold_step_2 == null) {
                Gold.config.gold_step_2 = $("#supplier_gold_step_2").html();
                _$this.find(".main-content").html(Gold.config.gold_step_2);
                $("#supplier_gold_step_2").html("");
            } else {
                _$this.find(".main-content").html(Gold.config.gold_step_2);
            }

        }
        if(Gold.config.payment_tran == 'card'){
            if (Gold.config.card_step_1 == null) {
                Gold.config.card_step_1 = $("#supplier_card_step_1").html();
                _$this.find(".main-content").html(Gold.config.card_step_1);
                $("#supplier_card_step_1").html("");
            } else {
                _$this.find(".main-content").html(Gold.config.card_step_1);
            }
        }
        _$this.find(".popup-title").html(Gold.config.title_popup);
    },
//    show_step_3:function (isBack) {
//        if (isBack == undefined) {
//            Gold.config.type_payment = $('input[name="payment_gold_type"]:checked').val();
//            Gold.config.gold_step_2 = $("#sys_popup_supplier_gold").find('.sys_supplier_gold');
//        }
//        var _$this = $("#sys_popup_supplier_gold");
//        if (Gold.config.gold_step_3 == null) {
//            Gold.config.gold_step_3 = $("#supplier_gold_step_3").html();
//            _$this.find(".main-content").html(Gold.config.gold_step_3);
//            $("#supplier_gold_step_3").html("");
//        } else {
//            _$this.find(".main-content").html(Gold.config.gold_step_3);
//        }
//        jQuery("#sys_payment_money").on('keyup', function (event) {
//            Gold.fomatNumber('sys_payment_money');
//        });
//    },
    show_step_4:function () {
        Gold.config.type_payment = $('input[name="payment_gold_type"]:checked').val();
        if (Gold.config.type_payment == 1) {
            window.location = WEB_ROOT + 'requestGoldSohaPay?sub_price=' + parseInt(Gold.config.payment_money) + '&supplier=' + JSON.stringify(Gold.config.supplier_wallet);
        } else {
            var _$this = $("#sys_popup_supplier_gold");
            var html = ""
            $.ajax({
                url:WEB_ROOT + 'shop/createWalletSupplierRequest',
                data:{sub_price:parseInt(Gold.config.payment_money)},
                type:'POST',
                dataType:'json',
                beforeSend:function () {
                    _$this.find(".sys_over_loading").addClass("active");
                },
                complete:function () {
                    _$this.find(".sys_over_loading").removeClass("active");
                },
                success:function (res) {
                    if (res.isIntOK == 1) {
                        if (Gold.config.gold_step_4 == null) {
                            Gold.config.gold_step_4 = $("#supplier_gold_step_finish").html();
                            _$this.find(".main-content").html(Gold.config.gold_step_4);
                            $("#supplier_gold_step_finish").html("");
                        } else {
                            _$this.find(".main-content").html(Gold.config.gold_step_4);
                        }
                        _$this.find(".popup-title").html(Gold.config.title_popup);
                        _$this.find("#sys_supplier_gold_notification").html(res.mess);
                    } else {
                        alert(res.mess);
                    }
                },
                error:function () {
                    alert("Yêu cầu nạp thẻ của bạn cho shop " + Gold.config.supplier_wallet.supplier_name + " thực hiện không thành công. Vui lòng thử lại sau");
                    _$this.find(".sys_over_loading").removeClass("active");
                }
            });
        }
    },
    show_card_step_2:function(){
        var card_seri = $('#card_seri').val();
        var card_code = $('#card_code').val();
        var card_type = $('input[name="opt_type_card"]:checked').val();
        if(card_seri == null || card_seri == ""){
            alert('Bạn chưa nhập seri thẻ cào');
            return false;
        }
        if(card_code == null || card_code == ""){
            alert('Bạn chưa nhập mã thẻ cào');
            return false;
        }
        if (card_type == null || card_type == "") {
            alert('Bạn chưa chọn loại thẻ cào');
            return false;
        }

        var html = ""
        $.ajax({
            url:WEB_ROOT + 'shop/payGoldByCard',
            data:{card_seri:card_seri, card_code:card_code,card_type:card_type},
            type:'POST',
            dataType:'json',
            beforeSend:function () {
                $("#sys_popup_supplier_gold").find(".sys_over_loading").addClass("active");
            },
            complete:function () {
            },
            success:function (res) {
               // console.log(res);
                if (res.isIntOK == 1) {
                    html += res.mess
                    var _$this = $("#sys_popup_supplier_gold");
                    if (Gold.config.gold_step_4 == null) {
                        Gold.config.gold_step_4 = $("#supplier_gold_step_finish").html();
                        _$this.find(".main-content").html(Gold.config.gold_step_4);
                        $("#supplier_gold_step_finish").html("");
                    } else {
                        _$this.find(".main-content").html(Gold.config.gold_step_4);
                    }
                    _$this.find(".popup-title").html(Gold.config.title_popup);
                } else {
                    alert(res.mess);
                    //return false;
                }

                $("#sys_popup_supplier_gold").find("#sys_supplier_gold_notification").html(html);
                $("#sys_popup_supplier_gold").find(".sys_over_loading").removeClass("active");
            },
            error:function () {
                alert('Có lỗi hệ thống nạp thẻ vui lòng thử lại');
                return false;
            }
        });

    },
    show_buy_up_step_1:function(isBack){
        $.popupCommon2({
            attrId:"sys_popup_supplier_buy_up",
            widthPop:"840px",
            successOpen:function () {
                var _$this = $("#sys_popup_supplier_buy_up");
                if (Gold.config.buy_up_step_1 == null) {
                    Gold.config.buy_up_step_1 = $("#buy_up_step_1").html();
                    _$this.find(".main-content").html(Gold.config.buy_up_step_1);
                    $("#buy_up_step_1").html("");
                } else {
                    _$this.find(".main-content").html(Gold.config.buy_up_step_1);
                }
                if (isBack == undefined) {
                    var popContent = _$this.find(".pop-content");
                    var setTopCSS, setLeftCSS;
                    setTopCSS = ($(window).height() - popContent.height()) / 2 - $(window).height() / 10;
                    if(setTopCSS <= 0){
                        _$this.css("position", "absolute");
                        var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
                        setTopCSS = pageOffetTop + 20;
                    }
                    setLeftCSS = Math.abs(($(window).width() - popContent.width()) / 2);
                    popContent.css({
                        "top":setTopCSS,
                        "left":setLeftCSS
                    });
                    _$this.css({
                        "display":"none",
                        "visibility":"visible"
                    });
                    _$this.fadeIn();
                }
            },
            preClose:function () {
            }
        });
    },
    show_buy_up_step_2:function (isBack) {
        if (isBack == undefined) {
            Gold.config.buy_up_tran = $('input[name=opt_num_up]:checked').attr('data-type');
            Gold.config.buy_up_money = $('input[name=opt_num_up]:checked').val();
            if (!Gold.config.buy_up_tran || Gold.config.buy_up_tran == '') {
                alert('Bạn chưa chọn mệnh giá muốn nạp');
                return false;
            }
        }
        var _$this = $("#sys_popup_supplier_buy_up");
        if (Gold.config.buy_up_tran == 'transfer') {
            if (Gold.config.buy_up_step_2 == null) {
                Gold.config.buy_up_step_2 = $("#buy_up_step_2").html();
                _$this.find(".main-content").html(Gold.config.buy_up_step_2);
                $("#buy_up_step_2").html("");
            } else {
                _$this.find(".main-content").html(Gold.config.buy_up_step_2);
            }

        }
        if (Gold.config.buy_up_tran == 'card') {
            if (Gold.config.buy_up_card_step_2 == null) {
                Gold.config.buy_up_card_step_2 = $("#buy_up_card_step_1").html();
                _$this.find(".main-content").html(Gold.config.buy_up_card_step_2);
                $("#buy_up_card_step_1").html("");
            } else {
                _$this.find(".main-content").html(Gold.config.buy_up_card_step_2);
            }
        }
        _$this.find(".popup-title").html(Gold.config.title_popup);
    },
    show_buy_up_step_3:function () {
        Gold.config.type_buy_up = $('input[name="payment_buy_up_type"]:checked').val();
        if (Gold.config.type_buy_up == 1) {
            window.location = WEB_ROOT + 'requestBuyUpSohaPay?sub_price=' + parseInt(Gold.config.buy_up_money) + '&supplier=' + JSON.stringify(Gold.config.supplier_wallet)+'&campaign_id=' + parseInt(Gold.config.campaign_id);
        } else {

            if(parseInt(Gold.config.buy_up_money) > parseInt(Gold.config.supplier_wallet.wallet_supplier_value_int)){
                alert("Số gold hiện tại không đủ xin vui lòng nạp thêm");
                return false;
            }

            var html = ""
            var _$this = $("#sys_popup_supplier_buy_up");
            $.ajax({
                url:WEB_ROOT + 'shop/buyUpByGold',
                data:{sub_price:parseInt(Gold.config.buy_up_money),campaign_id:parseInt(Gold.config.campaign_id)},
                type:'POST',
                dataType:'json',
                beforeSend:function () {
                    _$this.find(".sys_over_loading").addClass("active");
                },
                complete:function () {
                    _$this.find(".sys_over_loading").removeClass("active");
                },
                success:function (res) {
                    if (res.isIntOK == 1) {
                        html += res.mess;

                        if (Gold.config.buy_up_step_3 == null) {
                            Gold.config.buy_up_step_3 = $("#buy_up_step_3").html();
                            _$this.find(".main-content").html(Gold.config.buy_up_step_3);
                            $("#buy_up_step_3").html("");
                        } else {
                            _$this.find(".main-content").html(Gold.config.buy_up_step_3);
                        }
                        _$this.find(".popup-title").html(Gold.config.title_popup);
                    } else {
                        alert("Yêu cầu mua lượt up của bạn cho shop " + Gold.config.supplier_wallet.supplier_name + " thực hiện không thành công. Vui lòng thử lại");
                        //return false;
                    }
                    _$this.find("#sys_supplier_buy_up_notification").html(html);
                },
                error:function () {
                    alert("Yêu cầu mua lượt up của bạn cho shop " + Gold.config.supplier_wallet.supplier_name + " thực hiện không thành công. Vui lòng thử lại");
                    _$this.find(".sys_over_loading").removeClass("active");
                    //return false

                }
            });
        }
    },
    show_buy_up_card_step_2:function(){
            var card_seri = $('#buy_up_card_seri').val();
            var card_code = $('#buy_up_card_code').val();
            var card_type = $('input[name="opt_buy_up_type_card"]:checked').val();
            if(card_seri == null || card_seri == ""){
                alert('Bạn chưa nhập seri thẻ cào');
                return false;
            }
            if(card_code == null || card_code == ""){
                alert('Bạn chưa nhập mã thẻ cào');
                return false;
            }
            if (card_type == null || card_type == "") {
                alert('Bạn chưa chọn loại thẻ cào');
                return false;
            }

            var html = ""
            var _$this = $("#sys_popup_supplier_buy_up");
            $.ajax({
                url:WEB_ROOT + 'shop/buyUpByCard',
                data:{card_seri:card_seri, card_code:card_code,card_type:card_type,campaign_id:parseInt(Gold.config.campaign_id)},
                type:'POST',
                dataType:'json',
                beforeSend:function () {
                    _$this.find(".sys_over_loading").addClass("active");
                },
                complete:function () {
                    _$this.find(".sys_over_loading").removeClass("active");
                },
                success:function (res) {
                   // console.log(res);
                    if (res.isIntOK == 1) {
                        html += res.mess

                        if (Gold.config.buy_up_step_3 == null) {
                            Gold.config.buy_up_step_3 = $("#buy_up_step_3").html();
                            _$this.find(".main-content").html(Gold.config.buy_up_step_3);
                            $("#buy_up_step_3").html("");
                        } else {
                            _$this.find(".main-content").html(Gold.config.buy_up_step_3);
                        }
                        _$this.find(".popup-title").html(Gold.config.title_popup);

                    } else {
                        alert(res.mess);
                        //return false;
                    }

                    _$this.find("#sys_supplier_buy_up_notification").html(html);

                },
                error:function () {
                    alert('Có lỗi hệ thống nạp thẻ vui lòng thử lại');
                    _$this.find(".sys_over_loading").removeClass("active");
                }
            });

        },
    closePopup:function () {
        $("#sys_popup_supplier_gold").find(".closePopup").trigger("click")
        if(Gold.config.campaign_id >0){
            window.location.reload();
        }
    },
    closeBuyUpPopup:function () {
        $("#sys_popup_supplier_buy_up").find(".closePopup").trigger("click")
        if(Gold.config.campaign_id >0){
            window.location.reload();
        }
    },
    fomatNumber:function (id) {
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        if (re > 1000000000) {
            re = 1000000000;
        }
        jQuery('#input_' + id).val(re);
        number.numberFormatNew(re, id);
    }
}
$(function(){
    $("body").on("change",".opt_num_up",function(){
        $("#sys_box_payment_up").removeClass('hidden');
        var payment_tran = $('input[name=opt_num_up]:checked').attr('data-type');
        var payment_bonus = $('input[name=opt_num_up]:checked').attr('data-bonus');
        var payment_money = parseInt($('input[name=opt_num_up]:checked').val());
        var payment_num = Math.round(parseInt(payment_money)/5000);
        $("#sys_total_num_buy_up").html(payment_num + ' lượt'+ ' + '+ payment_bonus + ' lượt'+ ' = ' + (parseInt(payment_bonus)+parseInt(payment_num)) + ' lượt')
        $("#sys_total_money_buy_up").html(payment_money.format(0,3)+ ' đ')
    });

});
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

