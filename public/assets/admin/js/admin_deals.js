/**
 * Created by Administrator on 9/4/14.
 */

/*********************************************************************************************************
 *********************************** WINDOW ONLOAD *******************************************************
 *********************************************************************************************************/

$(document).ready(function(){
    if($('#campaign_start_time_hour').length>0) {
        $('#campaign_start_time_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
    }
    if($('#campaign_end_time_hour').length>0) {
        $('#campaign_end_time_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
    }
    //lấy ngày hiện tại cho lịch
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#campaign_start_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate());
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#campaign_end_time')[0].focus();
        }).data('datepicker');
    var checkout = $('#campaign_end_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            checkout.hide();
    }).data('datepicker');

    $("body").on("click",".closePopup", function () {
        $('#sys_popup_list_product').find('#sys_txt_search_product_tmp').attr('id', 'sys_txt_search_product');
    });

    $("body").on("keyup","#sys_txt_search_product", function () {
        console.log(productSearch);
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

});
var productSearch = [];
var deals = {
    cfg: {
        arrStore: [],
        arrProduct: [],
        arrProductSelect: [],
        arrDataProductSelect: [],
        arrQuality: [],
        arrPercentDiscount: [],
        arrCampaignBox: [],
        arrDataProductChecked: [],
        statusValidate: 0
    },

    checkAll: function() {
        $('.checkRows').each(function() {
            if(this.checked) {  this.checked = false; }
            else { this.checked = true; }
        });
    },

    showPopup: function() {

    },

    showListProduct: function() {
        var data = '',
            supplier_id = $.trim($('#sys_supplier_id').val()),
            from_time = $.trim($('#campaign_start_time').val()),
            to_time = $.trim($('#campaign_end_time').val());
            from_hour = $.trim($('#campaign_start_time_hour').val()),
            to_hour = $.trim($('#campaign_end_time_hour').val());

        if(supplier_id == 0 || supplier_id == undefined) {
            alert('Bạn chưa chọn nhà cung cấp.');
            $('#sys_supplier_id').focus();
            return false;
        }

        if(from_time == '') {
            $("#campaign_start_time").focus();
            return false;
        }
        if(to_time == '') {
            $("#campaign_end_time").focus();
            return false;
        }
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: 'getListDataSupplier',
            data: {
                supplier : supplier_id,
                from_date : from_time,
                to_date : to_time,
                from_time: from_hour,
                to_time: to_hour
            },
            beforeSend: function() {
                $('#sys_add_product, #sys_update').attr('disabled', true);
            },
            complete: function() {
                $('#sys_add_product, #sys_update').attr('disabled', false);
            },
            success: function(res) {
                if(res.status){
                    if(res.status == 2){
                        window.location = linkAdmin+'logout';
                    }else{
                        deals.cfg.arrProduct = res.dataProduct;
                        for(var j in deals.cfg.arrProduct) {
                            productSearch[j] = {
                                slug: deals.cfg.arrProduct[j].slug,
                                products_name: deals.cfg.arrProduct[j].products_name,
                                products_id: deals.cfg.arrProduct[j].products_id
                            }
                        }
                        productAdd = res.dataProduct;
                        if(deals.cfg.arrProduct.length <= 0) {
                            alert('Không có sản phẩm nào của nhà cung cấp có thể áp dụng trong khoảng thời gian vừa chọn.');
                        } else {
                            deals.cfg.arrProductStore = res.arrStore;
                            if(deals.cfg.arrProductStore.length <= 0) {
                                alert('Nhà cung cấp chưa có kho nên không thể tạo được deal.');
                            }
                        }
                        for(var i=0; i<deals.cfg.arrProduct.length; i++) {
                            var pid = deals.cfg.arrProduct[i].products_id;
                            data += '<tr id="sys_data_row_'+ pid +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ deals.cfg.arrProduct[i].products_name +'</td><td><input type="checkbox" class="checkRows" name="product_'+ pid +'" id="product_'+ pid +'" value="'+ pid +'"></td></tr>';
                        }
                        $('#sys_popup_list_product').find('tbody').html(data);
                    }
                }
                console.log(data);
                $.popupCommon({
                        overlayClickHide:false,
                        htmlContent: $('#sys_popup_list_product').html(),
                        successOpen: function() {
                            $('#sys_popup_list_product').find('tbody').html('');
                        }
                });
                $('#sys_popup_list_product').find('#sys_txt_search_product').attr('id', 'sys_txt_search_product_tmp');
            }
        });
    },

    showListProductEdit: function() {
        deals.cfg.statusValidate = 0;
        for(var j=0; j<deals.cfg.arrProduct.length; j++) {
            productSearch[j] = {
                slug: deals.cfg.arrProduct[j].slug,
                products_name: deals.cfg.arrProduct[j].products_name,
                products_id: deals.cfg.arrProduct[j].products_id
            }
        }
        var data = '';
        for(var i=0; i<deals.cfg.arrProduct.length; i++) {
            var pid = deals.cfg.arrProduct[i].products_id;
            data += '<tr  id="sys_data_row_'+ pid +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ deals.cfg.arrProduct[i].products_name +'</td><td><input type="checkbox" class="checkRows" name="product_'+ pid +'" id="product_'+ pid +'" value="'+ pid +'" '+ (($.inArray(pid, deals.cfg.arrProductSelect)>=0) ? 'checked' : '') +'></td></tr>';
        }
        $('#sys_popup_list_product').find('tbody').html(data);
        $.popupCommon({
            overlayClickHide:false,
            htmlContent: $('#sys_popup_list_product').html(),
            successOpen: function() {
                $('#sys_popup_list_product').find('tbody').html('');
            }
        });
        $('#sys_popup_list_product').find('#sys_txt_search_product').attr('id', 'sys_txt_search_product_tmp');
    },

    saveProduct: function() {
        deals.cfg.statusValidate = 0;
        deals.cfg.arrProductSelect = [];
        var j = 0;
        for(var i=0; i<deals.cfg.arrProduct.length; i++) {
            if($("#product_"+deals.cfg.arrProduct[i].products_id).is(":checked")) {
                deals.cfg.arrProductSelect[j] = parseInt($('#product_' + deals.cfg.arrProduct[i].products_id).val());
                deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[j]] = deals.cfg.arrProduct[i];
                j++;
            }
        }
        if(deals.cfg.arrProductSelect.length > 0) {
            $("#sys_popup_common").find(".closePopup").trigger("click");
            var data = '';
            for(var i=0; i<deals.cfg.arrProductSelect.length; i++) {
                var products_prices = deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_prices;
                var products_id = deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_id;

                data += '<tr><td>'+ (i+1) +'</td>';
                data += '<td>'+ deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_name +'</td>';
                data += '<td><input type="text" id="sys_percent_discount_'+ products_id +'" onkeyup="deals.detectPriceSale('+products_id+', '+products_prices+', this.value);" value="0" size="5"/></td>';
                data += '<td><input type="text" id="sys_price_sale_'+ products_id +'" onkeyup="deals.detectPercentDiscount('+products_id+', '+products_prices+', this.value);" value="'+products_prices+'" size="10"/></td>';
                data += '<td align="right">';
                for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                    data += deals.cfg.arrProductStore[j].store_supplier_name + ' <input type="text" id="sys_product_store_'+deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_id+'_'+deals.cfg.arrProductStore[j].store_supplier_id+'" onkeyup="deals.validateQuanlity('+deals.cfg.arrProductStore[j].store_supplier_id+', '+deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_id+');" value="0" size="5" style="margin-bottom:5px"/><br>';
                }
                data += '</td></tr>';
                data += '';
            }
            $('#sys_list_product_checked').find('tbody').html(data);
            $('#sys_list_product_checked').show();
        } else {
            alert('Bạn chưa chọn sản phẩm nào.');
        }
    },

    saveProductChecked: function() {
        deals.cfg.statusValidate = 1;
        var itmProduct = [];
        $('#sys_table_list_product_checked').find('input')
            .attr('disabled', true)
            .css({'background-color':'#C1E0FF'});
        //$('#sys_btn_complete').html('<a href="javascript:void(0);" onclick="deals.saveProductCheckedEdit();">Sửa thông tin</a>');

        for(var i=0; i<deals.cfg.arrProductSelect.length; i++) {
            var itemStore = [];
            for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                itemStore[deals.cfg.arrProductStore[j].store_supplier_id] = {
                    'store_supplier_campaign_number_init' : $('#sys_product_store_' + deals.cfg.arrProductSelect[i] + '_' + deals.cfg.arrProductStore[j].store_supplier_id).val(),
                    'store_supplier_id' : deals.cfg.arrProductStore[j].store_supplier_id
                }
            }

            var percent_discount = parseInt($('#sys_percent_discount_'+deals.cfg.arrProductSelect[i]).val());
            var price_sale = parseInt($('#sys_price_sale_'+deals.cfg.arrProductSelect[i]).val());
            itmProduct[deals.cfg.arrProductSelect[i]] = {
                product_price: deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_prices,
                product_price_sale: price_sale, //Math.round(((100 - percent_discount)*deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_prices)/100),
                products_id: deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[i]].products_id,
                store_supplier_campaign: itemStore,
                product_is_default: 1,
                percent_discount: percent_discount
            }
        }
        deals.cfg.arrCampaignBox[0] = {
            'campaign_box_name' : 'box default',
            'campaign_products' : itmProduct
        }
        $('#sys_data_box').val(JSON.stringify(deals.cfg.arrCampaignBox));
        deals.cfg.arrPercentDiscount = [];
        for(var c in deals.cfg.arrProductSelect) {
            deals.cfg.arrPercentDiscount[c] = parseInt($('#sys_percent_discount_' + deals.cfg.arrProductSelect[c]).val());
        }
        $('#sys_product_percent_discount').val(JSON.stringify(deals.cfg.arrPercentDiscount));

        deals.cfg.arrPriceSale = [];
        for(var c in deals.cfg.arrProductSelect) {
            deals.cfg.arrPriceSale[c] = parseInt($('#sys_price_sale_' + deals.cfg.arrProductSelect[c]).val());
        }
        $('#sys_product_price_sale').val(JSON.stringify(deals.cfg.arrPriceSale));
    },

    saveProductCheckedEdit: function() {
        $('#sys_table_list_product_checked').find('input')
            .attr('disabled', false)
            .css({'background-color':'#FFD9EC'});
        //$('#sys_btn_complete').html('<a href="javascript:void(0);" onclick="deals.saveProductChecked();">Hoàn thành</a>');
    },

    validateQuanlity:function(store_id, product_id){
        var quanlity = $('#sys_product_store_'+product_id+'_'+store_id).val();
        if (isNaN(quanlity))
        {
            alert("Số lượng kho phải là kiểu số.");
            $('#sys_product_store_'+product_id+'_'+store_id).val(0);
            return false;
        } else if(quanlity < 0) {
            alert("Số lượng kho không được nhỏ hơn 0.");
            $('#sys_product_store_'+product_id+'_'+store_id).val(0);
            return false;
        }
        return true;
    },

    //check validate so luong nhap vao
    validatePercent:function(percent, id){
        if (isNaN(percent))
        {
            alert("Giá trị % giảm phải là kiểu số.");
            $('#'+id).val(0);
            return false;
        } else if(percent < 0) {
            alert("Giá trị % giảm không được nhỏ hơn 0.");
            $('#'+id).val(0);
            return false;
        } else if(percent > 100) {
            alert("Giá trị % giảm không được lớn hơn 100.");
            $('#'+id).val(100);
            return false;
        }
        return true;
    },

    detectPercentDiscount: function(id, price, price_sale) {
        if (isNaN(price_sale))
        {
            alert("Giá bán phải là kiểu số.");
            $('#sys_price_sale_'+id).val(0);
            $('#sys_percent_discount_'+id).val(100);
        } else if(price_sale < 0) {
            alert("Giá bán không được nhỏ hơn 0.");
            $('#sys_price_sale_'+id).val(0);
            $('#sys_percent_discount_'+id).val(100);
        } else {
            if(price > 0 && price_sale > 0 && price > price_sale) {
                var percent_discount = ( Math.round(100 - ((price_sale/price)*100)) );
                $('#sys_percent_discount_' + id).val(percent_discount);
            } else {
                $('#sys_price_sale_' + id).val(0);
                $('#sys_percent_discount_'+id).val(100);
            }
        }
    },

    detectPriceSale: function(id, price, price_discount) {
        if (isNaN(price_discount))
        {
            alert("Giá trị % giảm phải là kiểu số.");
            $('#sys_percent_discount_'+id).val(0);
        } else if(price_discount < 0) {
            alert("Giá trị % giảm không được nhỏ hơn 0.");
            $('#sys_percent_discount_'+id).val(0);
        }else if(price_discount > 100) {
            alert("Giá trị % giảm không được lớn hơn 100.");
            $('#sys_percent_discount_'+id).val(0);
        } else {
            if(price > 0 && price_discount > 0) {
                //var percent_discount = ( Math.round(price - (price * (price_discount/100))) );
                //$('#sys_price_sale_' + id).val(percent_discount);
            } else {
                $('#sys_percent_discount_'+id).val(0);
            }
        }
    }
}
