/**
 * User: tuanna
 * Date: 1/7/2015
 * Time: 9:12 AM
 */
$(document).ready(function () {

    var sum_pay = 0;
    $('.checkbox_items').each(function () {
        if (this.checked == true) {
            var _pay = parseInt($(this).attr('data-pay'));
            sum_pay = sum_pay + _pay;
        }
    });
    $("#sys_sum_pay").html(sum_pay.format(0, 3, '.', ','));

    $('.selecctall').click(function (event) {  //on click
        if (this.checked) {
            $('.checkbox_items').each(function () {
                this.checked = true;
            });
            $('.selecctall').each(function () {
                this.checked = true;
            });
            $("#sys_sum_pay").html($("#sys_sum_pay").attr('data-value'));
        } else {
            $('.checkbox_items').each(function () {
                this.checked = false;
            });
            $('.selecctall').each(function () {
                this.checked = false;
            });
            $("#sys_sum_pay").html(0);
        }
    });

    $('.checkbox_items').click(function (event) {
        var id = $(this).attr('id');
        var order = $(this).attr('data-order');
        var coupon_money = parseInt($(this).attr('data-coupon-money'));
        var coupon_fee = parseInt($(this).attr('data-fee-coupon'));
        var order_fee = parseInt($(this).attr('data-fee-order'));
        var flag = parseInt($(this).attr('data-flag'));
        if (this.checked == false) {
            if (flag == 1) {
                $('.checkbox_items').each(function () {
                    if (this.checked == true && $(this).attr('data-order') == order) {
                        $("#sys_money_fee_" + id).html(coupon_fee.format(0, 3, '.', ','));
                        $("#sys_money_pay_" + id).html((coupon_money - coupon_fee).format(0, 3, '.', ','));
                        $("#" + id).attr('data-pay', coupon_money - coupon_fee);
                        $("#" + id).attr('data-flag', 0);
                        var _id = $(this).attr('id');
                        var _coupon_money = parseInt($(this).attr('data-coupon-money'));
                        var _coupon_fee = parseInt($(this).attr('data-fee-coupon'));
                        var _order_fee = parseInt($(this).attr('data-fee-order'));
                        $("#sys_money_fee_" + _id).html((_coupon_fee + _order_fee).format(0, 3, '.', ','));
                        $("#sys_money_pay_" + _id).html((_coupon_money - _coupon_fee - _order_fee).format(0, 3, '.', ','));
                        $("#" + _id).attr('data-pay', _coupon_money - _coupon_fee - _order_fee);
                        $("#" + _id).attr('data-flag', 1);
                        return false;
                    }
                });
            }
        } else {
            $('.checkbox_items').each(function () {
                if ($(this).attr('data-order') == order) {
                    var _id = $(this).attr('id');
                    var _coupon_money = parseInt($(this).attr('data-coupon-money'));
                    var _coupon_fee = parseInt($(this).attr('data-fee-coupon'));
                    $("#sys_money_fee_" + _id).html(_coupon_fee.format(0, 3, '.', ','));
                    $("#sys_money_pay_" + _id).html((_coupon_money - _coupon_fee).format(0, 3, '.', ','));
                    $("#" + _id).attr('data-pay', _coupon_money - _coupon_fee);
                    $("#" + _id).attr('data-flag', 0);
                }
            });
            $("#sys_money_fee_" + id).html((coupon_fee + order_fee).format(0, 3, '.', ','));
            $("#sys_money_pay_" + id).html((coupon_money - coupon_fee - order_fee).format(0, 3, '.', ','));
            $("#" + id).attr('data-pay', coupon_money - coupon_fee - order_fee);
            $("#" + id).attr('data-flag', 1);
        }
        var sum_pay = 0;
        $('.checkbox_items').each(function () {
            if (this.checked == true) {
                var _pay = parseInt($(this).attr('data-pay'));
                sum_pay = sum_pay + _pay;
            }
        });
        $("#sys_sum_pay").html(sum_pay.format(0, 3, '.', ','))
    });

    $("#sys_pay_supplier").on('click',function(){
        $("#sys_pay_supplier").prop('disabled',true);
        var checkedValue = $('.checkbox_items:checked').val();
        if(checkedValue == undefined){
            alert('Bạn phải chọn ít nhất 1 giao dịch để thanh toán');
            $("#sys_pay_supplier").prop('disabled',false);
            return false;
        }
        $("#frm_pay_supplier").submit();
    });
});
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};