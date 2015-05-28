/**
 * User: tuanna
 * Date: 1/5/2015
 * Time: 11:31 AM
 */
var sendingAjax = false;
$(document).ready(function () {
    accounting.ajaxGetDataWarning();
    $("#sys_get_data_warning").on('click', function () {
        accounting.ajaxGetDataWarning();
    });
    $("#supplier_name").on("keypress", function (e) {
        if (e.which == 10 || e.which == 13) {
            accounting.ajaxGetDataWarning();
        }
    })
});
var accounting = {
    config: {},
    ajaxGetDataWarning: function () {
        var supplier_name = ($('#supplier_name').val() != undefined) ? $('#supplier_name').val() : '';
        if (!sendingAjax) {
            $.ajax({
                url: WEB_ROOT + 'admin/accounting/ajax_warning?supplier_name='+supplier_name,
                //data: {
                //    supplier_name: supplier_name
                //},
                dataType: 'json',
                beforeSend: function () {
                    $("#sys_load").removeClass('hidden');
                    $("#sys_content").addClass('hidden');
                    sendingAjax = true;
                },
                error: function () {
                    $("#sys_load").addClass('hidden');
                    sendingAjax = false;
                },
                success: function (res) {
                    $("#sys_load").addClass('hidden');
                    $("#sys_content").removeClass('hidden');
                    sendingAjax = false;
                    //console.log(res);
                    if (res.intIsOK == 1) {
                        $("#sys_content").html(res.html);
                    }else{
                        $("#sys_content").html("Không tìm thấy cảnh báo thanh toán nào");
                    }
                }
            });
        }
        return false;
    }
}
