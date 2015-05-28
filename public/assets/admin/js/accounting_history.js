/**
 * User: tuanna
 * Date: 1/8/2015
 * Time: 2:33 PM
 */
var pay_id = 0;
$(document).ready(function () {
    var receive_date = $('#receive_date').datepicker().on('changeDate', function (ev) {
        receive_date.hide();
    }).data('datepicker');

    $(".sys_confirm_pay").on('click', function () {
        $('#bank_fee').val(0);
        $('#receive_date').val(showDateNow());
        pay_id = parseInt($(this).attr('data-pay-id'));
    });

    $("#sys_finish_pay").on('click',function(){
        var receive_date = $('#receive_date').val();
        var bank_fee = $('#bank_fee').val();
        if(pay_id == 0){
            alert('Bạn chưa chọn một thanh toán để thực hiện');
            return false;
        }
        //console.log(pay_id,receive_date,bank_fee);
        var r = confirm("Bạn chắc chắn muốn xác nhận khách nhận tiền cho thanh toán này");
        if (r == true) {
            $("#sys_finish_pay").prop('disabled',true)
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/accounting/confirm_pay',
                data: {
                    pay_id: pay_id,
                    receive_date: receive_date,
                    bank_fee: bank_fee
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (res) {
                    $("#sys_finish_pay").prop('disabled',false)
                    $('#myModalConfirm').modal('hide');
                    alert(res.mess);
                    if(res.intIsOK == 1){
                        location.reload();
                    }
                },
                error: function () {
                    $("#sys_finish_pay").prop('disabled',false)
                    $('#myModalConfirm').modal('hide');
                    alert('Có lỗi xảy ra');
                }
            });
        } else {
            return false;
        }
    })
})
function showDateNow(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    }

    if(mm<10) {
        mm='0'+mm
    }

    today = dd+'-'+mm+'-'+yyyy;
    return today;
}
