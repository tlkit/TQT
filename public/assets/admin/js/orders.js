/**
 * Created by Administrator on 10/14/14.
 */
var ajax = 0;
orders = {
    cfg: {},
    cancelOrders: function(id) {
        var id = parseInt(id);
        if(id > 0 && confirm('Bạn có muốn hủy đơn hàng này không?')) {
            $('#img_loading_ajax_delete_'+id).show();
            $('#show_infor_delete_order_'+id).hide();
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxCancelOrders',
                data: {
                    id : id
                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(res) {
                    $('#img_loading_ajax_delete_'+id).hide();
                    if(res.isIntOk == 1) {
                        $('#show_status_'+id).html('<a class="tooltip" title="4 - Hủy" href="javascript:;"><img class="img_icons_order" src="'+ WEB_ROOT +'assets/admin/img/order/huy.png"></a><div class="clear"></div><i class="font_11">Đã hủy</i>');
                        alert('Bạn đã hủy đơn hàng thành công.');
                        $('#show_infor_delete_order_'+id).hmtl('');
                    } else {
                        alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                        $('#show_infor_delete_order_'+id).show();
                    }
                }
            });
        }
    },

    checkSohapay: function(orders_id) {
        var orders_id = parseInt(orders_id);
        if(orders_id > 0 && confirm('Bạn có muốn check lại đơn hàng này không?')) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/updateOrderOnline',
                data: {
                    orders_id : orders_id
                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(res) {
                    //$('#img_loading_ajax_delete_'+id).hide();
                    if(res.isIntOk == 1) {
                        alert('Check lại đơn hàng thành công.');
                    } else {
                        alert('Check lại sohapay không thành công.');
                    }
                }
            });
        }
    },
    viewInforCouponOrderId: function(order_id) {
        $('#sys_PopupShowCouponOrder').modal('show');
        $('#sys_table_view_note').hide();
        $('#sys_view_msg_note').html('');
        $('#img_loading_view_note').show();
        $('#myModalLabelShowCouponOrder').html('Thông tin Coupon của đơn hàng - '+order_id );
        if (order_id > 0) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/adminOrder/viewInforCouponOrderId',
                data: {order_id : order_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_note').hide();
                    if(res.intReturn === 1){
                        var html = "";
                        html += "<tr>";
                        html += "<td width='20%'>Mã đơn hàng</td>";
                        html += "<td width='80%'>" + res.orders_id + "</td>";
                        html += "</tr>";
                        html += "<tr>";
                        html += "<td>Tên sản phẩm</td>";
                        html += "<td>" + res.product_name + "</td>";
                        html += "</tr>";
                        html += "<tr>";
                        html += "<td>Số lượng</td>";
                        html += "<td>" + res.so_luong + "</td>";
                        html += "</tr>";
                        html += "<tr>";
                        html += "<td>Tổng tiền</td>";
                        html += "<td>" + res.orders_total + "</td>";
                        html += "</tr>";
                        html += "<tr>";
                        html += "<td>Email khách</td>";
                        html += "<td>" + res.customer_email + "</td>";
                        html += "</tr>";
                        html += "<tr>";
                        html += "<td>Điện thoại</td>";
                        html += "<td>" + res.customer_phone + "</td>";
                        html += "</tr>";

                        if(res.inforCoupon){
                            html += "<tr>";
                            html += "<td>Mã Coupon</td>";
                            html += "<td>" + res.inforCoupon + "</td>";
                            html += "</tr>"
                            html += "<tr>";
                            html += "<td>Hạn sử dụng</td>";
                            html += "<td>" + res.timeCoupon + "</td>";
                            html += "</tr>";
                        }

                        $('#sys_table_view_note').show();
                        $('#sys_tr_infor_view_note').html(html);
                    }else{
                        $('#sys_view_msg_note').html(res.msg);
                    }
                }
            });
        }
    },
    showAddNoteDelivery: function(order_id, type) {
        $('#img_loading').show();
        $.ajax({
            type: "get",
            url: WEB_ROOT + 'admin/adminOrder/ajaxShowAddNoteDelivery',
            data: {order_id : order_id, type: type},
            dataType: 'json',
            success: function(res) {
                $('#img_loading').hide();
                if(res.isIntOk === 1){
                    $('#sys_PopupAddNoteOrder').html(res.html);
                    $('#sys_PopupAddNoteOrder').modal('show');
                }else{

                }
            }
        });
    },

    addNoteAndStatusDelivery: function(order_id) {
        var status_delivery = $('input[name=status_delivery]:radio:checked').val();
        var note = $('#sys_add_note').val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + 'admin/adminOrder/ajaxAddNoteAndStatusDelivery',
            data: {order_id : order_id, status_delivery: status_delivery, note: note},
            dataType: 'json',
            success: function(res) {
                if(res.isIntOk === 1){
                    alert('Thêm note thành công.');
                    window.location.reload();
                }else{
                    alert('Thêm note không thành công.');
                }
            }
        });
    },

    getOrderSohapay: function(order_code) {
        $('#sys_PopupShowOrderSohapay').modal('show');
        if(order_code != '') {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + 'admin/adminOrder/getOrderSohapay',
                data: {
                    order_code : order_code
                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(res) {
                    if(res.isIntOk == 1) {
                        $('#sys_block_popup_order_sohapay').html(res.data);
                    } else {
                        $('#sys_block_popup_order_sohapay').html('Không có dữ liệu.');
                    }
                    $('#sys_PopupShowOrderSohapay').show();
                }
            });
        }
    }
}

$(document).ready(function(){
    var order_id = 0;
    var payment_method = 0;
    $("#sys_btb_send_sms").on('click',function(){
        var order_id = $(this).attr('data-id');
        if(ajax == 1){
            // $(this).attr('disabled',true);
            alert('Hệ thống đang thực hiện yêu cầu của bạn');
            return false;
        }else{
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxSendSMSOrders',
                data: {
                    order_id: order_id
                },
                beforeSend: function () {
                    ajax = 1;
                    $(this).attr('disabled',true);
                },
                complete: function () {
                    ajax = 0;
                    $(this).attr('disabled',false);
                },
                success: function (res) {
                    if(res.isIntOK == 1){
                      alert(res.message);
                    }else{
                        alert('Không thực hiện được. Vui lòng thử lại sau')
                    }
                },
                error: function () {
                    ajax = 0;
                    $(this).attr('disabled',false);
                }
            });
        }
    });

    $("#sys_return_order").on('click', function () {
        var order_id = parseInt($(this).attr('data-order-id'));
        var r = confirm("Bạn chắc chắn muốn khai thác lại đơn hàng này");
        if (r == true) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/return_order',
                data: {
                    order_id: order_id
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    alert('Có lỗi xảy ra');
                    location.reload();
                }
            });
        } else {
            return false;
        }
    });
    $(".sys_request_refund").on('click', function () {
        order_id = parseInt($(this).attr('data-order-id'));
        payment_method = parseInt($(this).attr('data-payment-method'));
        if(payment_method == 1){
            var html = '<option value="1">Online</option><option value="2">Chuyển khoản</option><option value="3">Tiền mặt</option>';
        }else{
            var html = '<option value="2">Chuyển khoản</option><option value="3">Tiền mặt</option>'
        }
        $("#refund_type").html(html);
    })
    $("#sys_confirm_refund").on('click',function(){
        var r = confirm("Bạn chắc chắn muốn gửi yêu cầu hoàn tiền cho đơn hàng " + order_id);
        if (r == true) {
            var refund_type = $("#refund_type").val();
            var note = $("#refund_note").val();
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxRequestRefundOrder',
                data: {
                    order_id: order_id,
                    refund_type: refund_type,
                    note: note
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    $('#myRefundModal').modal('hide')
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    $('#myRefundModal').modal('hide')
                    alert('Có lỗi xảy ra');
                    location.reload();
                }
            });
        } else {
            $('#myRefundModal').modal('hide')
            return false;
        }
    });
    $(".sys_refund_confirm").on('click', function () {
        var order_id = parseInt($(this).attr('data-order-id'));
        var refund_id = parseInt($(this).attr('data-id'));
        var r = confirm("Bạn chắc chắn muốn xác nhận hoàn tiền cho đơn hàng " + order_id);
        if (r == true) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxConfirmRefundOrder',
                data: {
                    id: refund_id
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    alert('Có lỗi xảy ra');
                    location.reload();
                }
            });
        } else {
            return false;
        }
    });
    $(".sys_refund_accept").on('click', function () {
        var order_id = parseInt($(this).attr('data-order-id'));
        var refund_id = parseInt($(this).attr('data-id'));
        var r = confirm("Bạn chắc chắn muốn duyệt hoàn tiền cho đơn hàng " + order_id);
        if (r == true) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxAcceptRefundOrder',
                data: {
                    id: refund_id
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    alert('Có lỗi xảy ra');
                    location.reload();
                }
            });
        } else {
            return false;
        }
    });

    $(".sys_refund_finish").on('click', function () {
        var order_id = parseInt($(this).attr('data-order-id'));
        var refund_id = parseInt($(this).attr('data-id'));
        var r = confirm("Bạn chắc chắn muốn xác nhận khách đã nhân tiền cho đơn hàng " + order_id);
        if (r == true) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxFinishRefundOrder',
                data: {
                    id: refund_id
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    alert('Có lỗi xảy ra');
                    location.reload();
                }
            });
        } else {
            return false;
        }
    });
    var cancel_order_id = 0;
    var cancel_refund_id = 0;
    $(".sys_refund_cancel").on('click', function () {
        cancel_order_id = parseInt($(this).attr('data-order-id'));
        cancel_refund_id = parseInt($(this).attr('data-id'));
        $("#refund_cancel_note").val('');
        $("#sys_error_refund").addClass('hidden');
    });
    $(".sys_cancel_refund").on('click', function () {
        $("#sys_error_refund").addClass('hidden');
        var cancel_note = $("#refund_cancel_note").val();
        cancel_note = cancel_note.trim();
        if(cancel_note == ''){
            $("#sys_error_refund").removeClass('hidden');
            return false;
        }
        var r = confirm("Bạn chắc chắn muốn hủy hoàn tiền cho đơn hàng " + cancel_order_id);
        if (r == true) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminOrder/ajaxCancelRefundOrder',
                data: {
                    id: cancel_refund_id,
                    note: cancel_note
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    $('#myCancelRefundModal').modal('hide');
                    alert(res.message);
                    location.reload();
                },
                error: function () {
                    $('#myCancelRefundModal').modal('hide');
                    alert('Có lỗi xảy ra');
                    //location.reload();
                }
            });
        } else {
            return false;
        }
    });
});
