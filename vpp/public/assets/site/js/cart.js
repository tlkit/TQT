/**
 * Created by tuanna on 27/06/2016.
 */
var cart = {
    conf: {
        ajax_sending: false
    },
    addCart: function (product_id, product_num) {
        if (cart.conf.ajax_sending == false) {
            $.ajax({
                url: '/cart/add',
                data: {
                    product_id: product_id,
                    product_num: product_num,
                },
                dataType: 'json',
                type: 'POST',
                beforeSend: function () {
                    cart.conf.ajax_sending == true;
                },
                error: function () {
                    cart.conf.ajax_sending == false;
                    alert('Lỗi hệ thống');
                },
                success: function (res) {
                    cart.conf.ajax_sending == false;
                    if (res.success == 1) {
                        $(".cart-hover-content").html(res.html);
                        $('.cart-hover').fadeIn();
                        setTimeout(function() {
                            $('.cart-hover').fadeOut();
                        }, 2000);
                        $(".number-cart").html(res.num_total);
                        /*var timer;
                        $(".sys_number_cart").keyup(function(){
                            var _$this = $(this);
                            clearTimeout(timer);  //clear any running timeout on key up
                            timer = setTimeout(function() { //then give it a second to see if the user is finished
                                var product_num = _$this.val();
                                var product_id = _$this.data('id');
                                cart.updateNumber(product_id,product_num);
                            }, 500);
                        });*/
                        $(".sys_remove").on('click',function(){
                            var product_id = $(this).data('id');
                            cart.removeProduct(product_id);
                        });
                    } else {
/*                        var html = '<div style="" class="warning">Lỗi: ' + res.mess + '!<img class="close" alt="" src="assets/site/image/close.png"></div>'
                        $("#notification").html(html);
                        $(".close").on('click',function(){
                            $("#notification").html('');
                        });*/
                    }
                    $("html, body").animate({scrollTop: 0}, 1000);
                    return false;
                }
            });
        }
    },
    updateNumber: function (product_id, product_num) {
        if (cart.conf.ajax_sending == false) {
            $.ajax({
                url: '/cart/update',
                data: {
                    product_id: product_id,
                    product_num: product_num,
                },
                dataType: 'json',
                type: 'POST',
                beforeSend: function () {
                    cart.conf.ajax_sending == true;
                },
                error: function () {
                    cart.conf.ajax_sending == false;
                    alert('Lỗi hệ thống');
                },
                success: function (res) {
                    cart.conf.ajax_sending == false;
                    if (res.success == 1) {
                        $("#cart_view_number_"+product_id).val(product_num);
                        $("#cart_number_"+product_id).val(product_num);
                        $(".sys_total_item_"+product_id).html((res.price_item).format(0, 3, '.'));
                        $(".sys_total_order").html((res.price_total).format(0, 3, '.'));
                    }
                }
            });
        }
    },
    removeProduct: function (product_id) {
        if (cart.conf.ajax_sending == false) {
            $.ajax({
                url: '/cart/remove',
                data: {
                    product_id: product_id,
                },
                dataType: 'json',
                type: 'POST',
                beforeSend: function () {
                    cart.conf.ajax_sending == true;
                },
                error: function () {
                    cart.conf.ajax_sending == false;
                    alert('Lỗi hệ thống');
                },
                success: function (res) {
                    cart.conf.ajax_sending == false;
                    if (res.success == 1) {
                        $(".row_"+product_id).remove();
                        $(".sys_total_order").html((res.price_total).format(0, 3, '.') + '<span>đ</span>');
                        $(".number-cart").html(res.num_total);
                        if(res.num_total == 0){
                            $(".cart-hover-content").html('<div>Không có sản phẩm nào trong giỏ hàng !!!</div>');
                        }
                    }
                }
            });
        }
    },
}
$(document).ready(function () {
/*
    $('.sys_number_cart').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
*/
    $(".btn_add_cart").on('click', function () {
        var product_id = parseInt($(this).data('id'));
        var product_num = 1;//$('input[name=\'quantity['+product_id+']\']').val();
        cart.addCart(product_id,product_num);
    });

/*    var timer;
    $(".sys_number_cart").keyup(function(){
        var _$this = $(this);
        clearTimeout(timer);  //clear any running timeout on key up
        timer = setTimeout(function() { //then give it a second to see if the user is finished
            var product_num = _$this.val();
            var product_id = _$this.data('id');
            cart.updateNumber(product_id,product_num);
        }, 500);
    });*/
    $(".sys_remove").on('click',function(){
        var product_id = $(this).data('id');
        cart.removeProduct(product_id);
    });


});
Number.prototype.format = function (n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};