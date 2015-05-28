/**
 * Created by Administrator on 9/4/14.
 */

/*********************************************************************************************************
 *********************************** WINDOW ONLOAD *******************************************************
 *********************************************************************************************************/
var objStorage = localStorage.getItem("objDataProductSales");
$(document).ready(function(){
    if($('#sales_start_time_hour').length>0) {
        $('#sales_start_time_hour, #apply_service_start_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
    }
    if($('#sales_end_time_hour').length>0) {
        $('#sales_end_time_hour, #apply_service_end_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
    }
    //lấy ngày hiện tại cho lịch
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#product_start_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? '' : ''; //disabled
        }
    }).on('changeDate',function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate());
                checkout.setValue(newDate);
            }
            delaySomethings(function(){
                objStorage.product_start_time=$('#product_start_time').val();
                localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
            },0);
            checkin.hide();
            $('#product_end_time')[0].focus();
        }).data('datepicker');
    var checkout = $('#product_end_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            delaySomethings(function(){
                objStorage.product_end_time=$('#product_end_time').val();
                localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
            },0);
            checkout.hide();
        }).data('datepicker');


    var checkinService = $('#apply_service_start_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? '' : ''; //disabled
        }
    }).on('changeDate',function (ev) {
            if (ev.date.valueOf() > checkoutService.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate());
                checkoutService.setValue(newDate);
            }
            delaySomethings(function(){
                objStorage.apply_service_start_time=$('#apply_service_start_time').val();
                localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
            },0);
            checkinService.hide();
            $('#apply_service_end_time')[0].focus();
        }).data('datepicker');
    var checkoutService = $('#apply_service_end_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < checkinService.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            delaySomethings(function(){
                objStorage.apply_service_start_time=$('#apply_service_end_time').val();
                localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
            },0);
            checkoutService.hide();
        }).data('datepicker');

    $('#sales_start_time_hour').timepicker({stepMinute: 0}).on('changeTime.timepicker', function(e) {
        delaySomethings(function(){
            objStorage.sales_start_time_hour = e.time.value;
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $('#sales_end_time_hour').timepicker({stepMinute: 0}).on('changeTime.timepicker', function(e) {
        delaySomethings(function(){
            objStorage.sales_end_time_hour = e.time.value;
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });

    var checkinDateNotApplyFrom = $('#date_not_apply_from').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? '' : ''; //disabled
        }
    }).on('changeDate',function (ev) {
            if (ev.date.valueOf() > checkoutDateNotApplyFrom.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate());
                checkoutDateNotApplyFrom.setValue(newDate);
            }
            checkinDateNotApplyFrom.hide();
            $('#date_not_apply_to')[0].focus();
        }).data('datepicker');
    var checkoutDateNotApplyFrom = $('#date_not_apply_to').datepicker({
        onRender: function (date) {
            return date.valueOf() < checkinDateNotApplyFrom.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            checkoutDateNotApplyFrom.hide();
        }).data('datepicker');


    var datePickerDisable = $('.date_picker_disable').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            datePickerDisable.hide();
        }).data('datepicker');

    $("body").on("click",".closePopup", function () {
        $('#sys_popup_list_product').find('#sys_txt_search_product_tmp').attr('id', 'sys_txt_search_product');
    });

    $("body").on("keyup","#sys_txt_search_product", function () {
        delaySomethings(function () {
            var sys_txt_search_product = $("#sys_txt_search_product");
            var keyword = VietnameseWithoutAccent(sys_txt_search_product.val());
            $(".sys-row-data").addClass("hide-elem");
            for (var i = 0; i < productSearch.length; i++) {
                if (productSearch[i].slug.indexOf(keyword) >= 0) {
                    $("#sys_data_row_" + productSearch[i].products_id).removeClass("hide-elem");
                }
            }
        }, 300);
    });

    $("#add_date_not_apply").on("click", function() {
        $("#add_text_date_not_apply").append('<input type="text" name="disable_apply[]" class="date_picker_disable form-control" style="margin-bottom: 10px;" data-date-format="dd-mm-yyyy">');
        $('.date_picker_disable').datepicker({
                onRender: function (date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            })
            .on('changeDate', function(ev){
                $('.date_picker_disable').datepicker('hide');
            });
    });
});
var sales = {
    cfg: {
        arrProduct: [],
        arrStoredAmount: [],
        arrProductAll: null,
        arrStored: null,
        arrProductLoad: null,
        arrProductSelect: [],
        productGroupName: null,
        productSaleGroup: null
    },
    showListProductSale: function() {
        if($('#sys_product_group_create').is(":checked")) {
            var data = '',
                supplier_id = $.trim($('#supplier_id').val())
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/AdminProduct/getListProductSale',
                data: {
                    supplier_id : supplier_id
                },
                beforeSend: function() {
                    $('#sys_product_group_create').removeAttr('onclick');
                },
                complete: function() {
                    $('#sys_product_group_create').attr('onclick', 'sales.showListProductSale();');
                },
                success: function(res) {
                    if(res.isIntOk == 1){
                        sales.cfg.arrProductLoad = res.data;
                        productSearch = res.dataProduct;
                        if(sales.cfg.arrProductLoad.length <= 0) {
                            alert('Không có sản phẩm nào đã đăng bán của nhà cung cấp.');
                            return false;
                        }
                        for(var i=0; i<sales.cfg.arrProductLoad.length; i++) {
                            var flagProduct = 0;
                            var product_sale_id = sales.cfg.arrProductLoad[i].product_sale_id;
                            console.log(sales.cfg.arrProductSelect);

                            for(var j=0; j<sales.cfg.arrProductSelect.length; j++) {
                                if(sales.cfg.arrProductSelect[j] == product_sale_id) {
                                    flagProduct = 1;
                                }
                            }
                            var product_sale_id = sales.cfg.arrProductLoad[i].product_sale_id;
                            var province_name = (sales.cfg.arrProductLoad[i].province_id == 22) ? "Hà Nội" : "TP.Hồ Chí Minh";
                            if(flagProduct == 1) {
                                data += '<tr id="sys_data_row_'+ product_sale_id +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ sales.cfg.arrProductLoad[i].product_name +'</td><td>'+ province_name +'</td><td><input type="checkbox" class="checkRows" checked="checked" name="sys_product_sale_'+ product_sale_id +'" id="sys_product_sale_'+ product_sale_id +'" value="'+ product_sale_id +'"></td></tr>';
                            } else {
                                data += '<tr id="sys_data_row_'+ product_sale_id +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ sales.cfg.arrProductLoad[i].product_name +'</td><td>'+ province_name +'</td><td><input type="checkbox" class="checkRows" name="sys_product_sale_'+ product_sale_id +'" id="sys_product_sale_'+ product_sale_id +'" value="'+ product_sale_id +'"></td></tr>';
                            }
                            $('#sys_popup_list_product').find('tbody').html(data);
                        }
                        $.popupCommon({
                            overlayClickHide:false,
                            htmlContent: $('#sys_popup_list_product').html(),
                            successOpen: function() {
                                $('#sys_popup_list_product').find('tbody').html('');
                            }
                        });
                        $('#sys_popup_list_product').find('tbody').html(data);
                        $('#sys_popup_list_product').find('#sys_product_group_name').attr('id', 'sys_product_group_name_tmp');
                    }
                }
            });
        }
    },

    saveProduct: function() {
        sales.cfg.arrProductSelect = [];
        sales.cfg.productGroupName = $('#sys_popup_common').find('#sys_product_group_name').val();
        if(sales.cfg.productGroupName == null || sales.cfg.productGroupName == '') {
            alert('Tên nhóm sản phẩm không được trống');
            return false;
        }
        for(var i=0; i<sales.cfg.arrProductLoad.length; i++) {
            var product_sale_id = sales.cfg.arrProductLoad[i].product_sale_id;
            if($('#sys_popup_common').find("#sys_product_sale_"+product_sale_id).is(":checked")) {
                sales.cfg.arrProductSelect[product_sale_id] = parseInt($('#sys_product_sale_' + product_sale_id).val());
            }
        }
        sales.cfg.productSaleGroup = {
            'productGroupName': sales.cfg.productGroupName,
            'arrProductSelect': sales.cfg.arrProductSelect
        }
        $('#sys_data_product_group').val(JSON.stringify(sales.cfg.productSaleGroup));
        $('#sys_add_group').html();
        $('#sys_show_edit').show();
        $('#sys_show_create').hide();
        $('#show_product_group_name_label').html(sales.cfg.productGroupName);
        $('#sys_popup_list_product').find('#sys_product_group_name_tmp').attr({'id':'sys_product_group_name', 'value':sales.cfg.productGroupName});
        $("#sys_popup_common").find(".closePopup").trigger("click");
    },

    deleteGroup: function(id) {
        if(confirm('Bạn có muốn xóa nhóm sản phẩm này không?')) {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminProduct/deleteProductGroup',
                data: {
                    id : id
                },
                beforeSend: function() {
                    //$('#sys_show_list_product').removeAttr('onclick');
                },
                complete: function() {
                    //$('#sys_show_list_product').attr('onclick', 'deals.showListProduct();');
                },
                success: function(res) {
                    if(res.isIntOk == 1){
                        location.reload();
                    }
                }
            });
        }
    },

    deleteInputDate: function(id) {
        $(id).val('');
    }
}


