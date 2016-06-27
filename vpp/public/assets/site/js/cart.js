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
                        $("#cart").html(res.html);
                    } else {
                        alert(res.mess);
                    }
                    $("html, body").animate({scrollTop: 0}, 1000);
                    return false;
                }
            });
        }
    },
}

$(document).ready(function () {
    $(".btn_add_cart").on('click', function () {
        var product_id = parseInt($(this).data('id'));
        var product_num = $('input[name=\'quantity['+product_id+']\']').val();
        cart.addCart(product_id,product_num);
    })
});