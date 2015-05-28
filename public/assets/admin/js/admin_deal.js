/**
 * Created by Administrator on 9/4/14.
 */

/*********************************************************************************************************
 *********************************** WINDOW ONLOAD *******************************************************
 *********************************************************************************************************/

$(document).ready(function(){
    if($('#campaign_start_time_hour').length>0) {
        $('#campaign_start_time_hour, #apply_service_start_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
    }
    if($('#campaign_end_time_hour').length>0) {
        $('#campaign_end_time_hour, #apply_service_end_hour').timepicker({minuteStep: 1, showSeconds: true, showMeridian: false});
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


    var checkinService = $('#apply_service_start_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            if (ev.date.valueOf() > checkoutService.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate());
                checkoutService.setValue(newDate);
            }
            checkinService.hide();
            $('#apply_service_end_time')[0].focus();
        }).data('datepicker');
    var checkoutService = $('#apply_service_end_time').datepicker({
        onRender: function (date) {
            return date.valueOf() < checkinService.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
            checkoutService.hide();
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

    $("#sys_show_add_product").click(function() {
        $('#sys_add_product').slideToggle();
    });

    $('#sys_products_prices, #sys_products_prices_sale, #sys_products_percent_discount').autoNumeric('init');
});
var productSearch = [];
var statusLoadProduct = 0;
var deals = {
    cfg: {
        arrProduct: [],
        arrProductID: [],
        arrProductLoad: [],
        arrProductStore: [],
        arrProductAmount: [],
        arrProductSelect: [],
        arrDataProductSelect: [],
        arrDataPercentDiscount: [],
        arrDataProductPriceSale: [],
        countProduct: 0
    },

    displayValError: function(id, mess){
        this.disableValError(id);
        $('#'+id).css({'background-color':'#ffc1c1'});
        $('#'+id).parent().append('<span id="show-error" style="color:#888;font-size:11px">' + mess + '</span>');
        var top = $('#'+id).offset().top;
        $("html, body").animate({ scrollTop: top-80 }, 500);
    },

    disableValError: function(id){
        $('#'+id).css({'background-color':''});
        $('#show-error').remove();
    },
    valid_finish: function() {
        $('#sys_update').attr('disabled', true);
        var sys_box_product = $('#sys_box_product').val();
        if(sys_box_product == '' || sys_box_product == '[]') {
            this.displayValError('sys_box_product', 'Bạn hãy nhập sản phẩm khuyến mại cho deal.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        $('#sys_update').attr('disabled', true);
        $('#create_deal_step_2').submit();
        return true;
    },

    addProduct: function() {
        var products_name = $('#sys_product_name').val();
        var products_prices = $('#sys_products_prices').val();
        products_prices = parseInt(products_prices.replace(/[., đ]/g, ''));
        var products_prices_sale = $('#sys_products_prices_sale').val();
        products_prices_sale = parseInt(products_prices_sale.replace(/[., đ]/g, ''));
        var products_percent_discount = parseInt($('#sys_products_percent_discount').val());
        var supplier_id = parseInt($('#sys_supplier_id').val());
        var product_type = parseInt($('#sys_product_type').val());
        var product_description = CKEDITOR.instances['sys_product_description'].getData();

        //Validate
        $('#sys_update').attr('disabled', true);
        if(products_name == '') {
            this.displayValError('sys_product_name', 'Bạn hãy nhập tên sản phẩm.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        var img_other = [];
        var i = 0;
        $("input[name^='img_other']").each(function () {
            img_other[i] = $(this).val();
            i++;
        });
        if(img_other.length == 0) {
            alert('Bạn chưa chọn ảnh sản phẩm để upload.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(products_prices == '') {
            this.displayValError('sys_products_prices', 'Bạn hãy nhập giá niêm yết sản phẩm.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(products_prices_sale == '') {
            this.displayValError('products_prices_sale', 'Bạn hãy nhập giá bán sản phẩm.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(products_percent_discount == '') {
            this.displayValError('sys_products_percent_discount', 'Bạn hãy nhập % giám giá sản phẩm.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(product_type == '') {
            this.displayValError('product_type', 'Bạn hãy chọn loại sản phẩm.');
            $('#sys_update').attr('disabled', false);
            return false;
        }

        $('#sys_update').attr('disabled', false);
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: WEB_ROOT + 'admin/campaign/ajaxUploadProduct',
            data: {
                supplier_id : supplier_id,
                products_name : products_name,
                products_prices : products_prices,
                product_description : product_description,
                product_type : product_type,
                img_other: img_other
            },
            beforeSend: function() {
                $('#sys_add_product, #sys_update').attr('disabled', true);
            },
            complete: function() {
                $('#sys_add_product, #sys_update').attr('disabled', false);
            },
            success: function(res) {
                if(res.intIsOK == 1) {
                    var data = res.data;
                    deals.cfg.arrProduct[data.products_id] = {
                        products_name: data.products_name,
                        supplier_id: data.supplier_id,
                        products_prices: data.products_prices,
                        product_price_sale: products_prices_sale,
                        percent_discount: products_percent_discount,
                        products_id: data.products_id
                    }
                    deals.cfg.arrProductID[deals.cfg.arrProductID.length] = data.products_id;
                    var html = '<tr id="sys_row_product_'+ data.products_id +'">';
                    html += '<td>'+ data.products_name +'</td>';
                    html += '<td><span id="sys_show_product_price_sale_'+ data.products_id +'">'+ products_prices_sale +'</span><input type="text" id="sys_product_price_sale_'+ data.products_id +'" value="'+ products_prices_sale +'" onkeyup="deals.detectPercentDiscount('+data.products_id+', '+data.products_prices+', this.value);" size="5" style="display:none"></td>';
                    html += '<td><span id="sys_show_percent_discount_'+ data.products_id +'">'+ products_percent_discount +'</span><input type="text" id="sys_percent_discount_'+ data.products_id +'" value="'+ products_percent_discount +'" onkeyup="deals.detectPriceSale('+data.products_id+', '+data.products_prices+', this.value);" size="5" style="display:none"></td>';
                    html += '<td>';
                    for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                        var store_amount = $('#sys_store_of_supplier_'+ deals.cfg.arrProductStore[j].store_supplier_id).val();
                        html += '<span>tại '+ deals.cfg.arrProductStore[j].store_supplier_name +': <strong id="sys_show_campaign_number_init_'+deals.cfg.arrProductStore[j].store_supplier_id+'_'+ data.products_id +'" class="show_campaign_number_init_'+ data.products_id +'">'+ store_amount +'</strong><input type="text" id="sys_campaign_number_init_'+deals.cfg.arrProductStore[j].store_supplier_id+'_'+ data.products_id +'" class="sys_campaign_number_init_'+ data.products_id +'" value="'+ store_amount +'" size="5" style="display:none"></span><br/>';
                    }
                    html += '</td>';
                    html += '<td><a id="sys_label_edit_'+data.products_id+'" href="javascript:void(0);" onclick="deals.editProductBox('+ data.products_id +');">Sửa</a> &nbsp;|&nbsp; <a href="javascript:void(0);" onclick="deals.deleteProductBox('+ data.products_id +');">Xóa</a></td></tr>';
                    $('#dataTable').find('tbody').append(html);
                    deals.cfg.countProduct++;
                    $('#sys_product_name, #sys_products_prices, #sys_products_prices_sale, #sys_products_percent_discount').val('');
                    $('#div_image_input').html('')
                    var itmStore = [];
                    for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                        itmStore[j] = {
                            store_supplier_id: deals.cfg.arrProductStore[j].store_supplier_id,
                            store_supplier_name: deals.cfg.arrProductStore[j].store_supplier_name,
                            store_supplier_campaign_number_init:$('#sys_store_of_supplier_'+ deals.cfg.arrProductStore[j].store_supplier_id).val()
                        }
                        $('#sys_store_of_supplier_'+ deals.cfg.arrProductStore[j].store_supplier_id).val('')
                    }
                    CKEDITOR.instances['sys_product_description'].setData('');
                    deals.cfg.arrProductAmount[data.products_id] = itmStore;
                    $('#sys_box_store').val(JSON.stringify(deals.cfg.arrProductAmount));
                    $('#sys_box_product').val(JSON.stringify(deals.cfg.arrProduct));
                }
                $('#sys_add_product').hide();
            }
        });
    },

    deleteProductBox: function(id) {
        //delete deals.cfg.arrProduct[id];
        deals.cfg.arrProduct[id].campaign_products_del_flag = 1;
        for(var i=0; i<deals.cfg.arrProductID.length; i++) {
            if(deals.cfg.arrProductID[i] == id) {
                delete deals.cfg.arrProductID[i];
            }
        }
        console.log(deals.cfg.arrProductID);
        $('#sys_row_product_'+ id).remove();
        $('#sys_box_product').val(JSON.stringify(deals.cfg.arrProduct));
    },

    editProductBox: function(id) {
        $('#sys_show_product_price_sale_'+ id +',#sys_show_percent_discount_'+ id +',.show_campaign_number_init_'+ id).hide();
        $('#sys_product_price_sale_'+ id +',#sys_percent_discount_'+ id +',.sys_campaign_number_init_'+id).show();
        $('#sys_label_edit_'+id).html('Lưu lại');
        $('#sys_label_edit_'+id).attr('onclick', 'deals.saveProductBox('+id+')');
    },

    saveProductBox: function(id) {
        var products_prices_sale = $('#sys_product_price_sale_'+id).val();
        var products_percent_discount = $('#sys_percent_discount_'+id).val();

        deals.cfg.arrProduct[id].product_price_sale = products_prices_sale;
        deals.cfg.arrProduct[id].percent_discount = products_percent_discount;
        console.log(deals.cfg.arrProductAmount);
        for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
            deals.cfg.arrProductAmount[id][j].store_supplier_campaign_number_init = $('#sys_campaign_number_init_'+ deals.cfg.arrProductStore[j].store_supplier_id+'_'+id).val();
            $('#sys_show_campaign_number_init_'+deals.cfg.arrProductStore[j].store_supplier_id+'_'+id).html(deals.cfg.arrProductAmount[id][j].store_supplier_campaign_number_init);
        }
        $('#sys_box_product').html(JSON.stringify(deals.cfg.arrProduct));
        $('#sys_box_store').html(JSON.stringify(deals.cfg.arrProductAmount));
        $('#sys_show_product_price_sale_'+ id).html(products_prices_sale);
        $('#sys_show_percent_discount_'+ id).html(products_percent_discount);
        $('#sys_show_product_price_sale_'+ id +',#sys_show_percent_discount_'+ id+',.show_campaign_number_init_'+id).show();
        $('#sys_product_price_sale_'+ id +',#sys_percent_discount_'+ id +',.sys_campaign_number_init_'+id).hide();


        $('#sys_label_edit_'+id).html('Sửa');
        $('#sys_label_edit_'+id).attr('onclick', 'deals.editProductBox('+id+')');
    },

    showListProduct: function() {
        var data = '',
            supplier_id = $.trim($('#sys_supplier_id').val()),
            from_time = $.trim($('#campaign_start_time').val()),
            to_time = $.trim($('#campaign_end_time').val());
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: WEB_ROOT + 'admin/campaign/getListDataSupplier',
            data: {
                supplier_id : supplier_id,
                from_date : from_time,
                to_date : to_time
            },
            beforeSend: function() {
                $('#sys_show_list_product').removeAttr('onclick');
            },
            complete: function() {
                $('#sys_show_list_product').attr('onclick', 'deals.showListProduct();');
            },
            success: function(res) {
                if(res.status){
                    if(res.status == 2){
                        window.location = linkAdmin+'logout';
                    }else{
                        deals.cfg.arrProductLoad = res.dataProduct;
                        productSearch = res.dataProduct;
                        if(deals.cfg.arrProductLoad.length <= 0) {
                            alert('Không có sản phẩm nào của nhà cung cấp thỏa mãn thời gian áp dụng.');
                        }

                        for(var i=0; i<deals.cfg.arrProductLoad.length; i++) {
                            var flagProduct = 0;
                            var pid = deals.cfg.arrProductLoad[i].products_id;
                            for(var p=0; p<deals.cfg.arrProductID.length; p++) {
                                if(deals.cfg.arrProductID[p] == pid) {
                                    flagProduct = 1;
                                }
                            }
                            if(flagProduct == 1) {
                                data += '<tr id="sys_data_row_'+ pid +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ deals.cfg.arrProductLoad[i].products_name +'</td><td><input type="checkbox" checked="checked" disabled="disabled" class="checkRows" name="product_'+ pid +'" id="product_'+ pid +'" value="'+ pid +'"></td></tr>';
                            } else {
                                data += '<tr id="sys_data_row_'+ pid +'" class="sys-row-data"><td>'+ (i+1) +'</td><td>'+ deals.cfg.arrProductLoad[i].products_name +'</td><td><input type="checkbox" class="checkRows" name="product_'+ pid +'" id="product_'+ pid +'" value="'+ pid +'"></td></tr>';
                            }
                        }
                        $('#sys_popup_list_product').find('tbody').html(data);
                    }
                }
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

    saveProduct: function() {
        $("#sys_popup_common").find(".closePopup").trigger("click");
        var j = 0;
        for(var i=0; i<deals.cfg.arrProductLoad.length; i++) {
            if($("#product_"+deals.cfg.arrProductLoad[i].products_id).is(":checked")) {
//                var statusExitst = 0;
//                for(var k=0; k<deals.cfg.arrProduct.length; k++) {
//                    if(deals.cfg.arrProduct[k].products_id == deals.cfg.arrProductLoad[i].products_id) {
//                        statusExitst = 1;
//                    }
//                }
                deals.cfg.arrProductSelect[j] = parseInt($('#product_' + deals.cfg.arrProductLoad[i].products_id).val());
                deals.cfg.arrDataProductSelect[deals.cfg.arrProductSelect[j]] = deals.cfg.arrProductLoad[i];

                deals.cfg.arrProduct[deals.cfg.arrProductLoad[i].products_id] = {
                    products_name: deals.cfg.arrProductLoad[i].products_name,
                    supplier_id: deals.cfg.arrProductLoad[i].supplier_id,
                    products_prices: deals.cfg.arrProductLoad[i].products_prices,
                    product_price_sale: 0,
                    percent_discount: 0,
                    products_id: deals.cfg.arrProductLoad[i].products_id
            }
            var itmStore = [];
            for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                itmStore[j] = {
                    store_supplier_name: deals.cfg.arrProductStore[j].store_supplier_name,
                    store_supplier_id: deals.cfg.arrProductStore[j].store_supplier_id,
                    store_supplier_campaign_number_init:$('#sys_store_of_supplier_'+ deals.cfg.arrProductStore[j].store_supplier_id).val()
                }
                $('#sys_store_of_supplier_'+ deals.cfg.arrProductStore[j].store_supplier_id).val('')
            }
            deals.cfg.arrProductAmount[deals.cfg.arrProductLoad[i].products_id] = itmStore;
            console.log(deals.cfg.arrProductID);
            var statusExitst = 0;
            for(var p=0; p<deals.cfg.arrProductID.length; p++) {
                if(deals.cfg.arrProductID[p] == deals.cfg.arrProductLoad[i].products_id) {
                    statusExitst = 1;
                }
            }
            deals.cfg.arrProductID[deals.cfg.arrProductID.length] = parseInt(deals.cfg.arrProductLoad[i].products_id);
            if(statusExitst == 0) {
                var proID = deals.cfg.arrProductLoad[i].products_id;
                var proPrices = deals.cfg.arrProductLoad[i].products_prices;

                var html = '<tr id="sys_row_product_'+ deals.cfg.arrProductLoad[i].products_id +'">';
                html += '<td>'+ deals.cfg.arrProductLoad[i].products_name +'</td>';
                html += '<td><span id="sys_show_product_price_sale_'+deals.cfg.arrProductLoad[i].products_id+'" style="display:none">'+ deals.cfg.arrProductLoad[i].products_prices +'</span><input type="text" id="sys_product_price_sale_'+proID+'" onkeyup="deals.detectPercentDiscount('+proID+', '+proPrices+', this.value);" value="'+ deals.cfg.arrProductLoad[i].products_prices +'" size="5"></td>';
                html += '<td><span id="sys_show_percent_discount_'+deals.cfg.arrProductLoad[i].products_id+'" style="display:none">0</span><input type="text" id="sys_percent_discount_'+deals.cfg.arrProductLoad[i].products_id+'" onkeyup="deals.detectPriceSale('+proID+', '+proPrices+', this.value);" value="0" size="5"></td>';
                html += '<td>';
                for(var j=0; j<deals.cfg.arrProductStore.length; j++) {
                    html += '<span>tại '+deals.cfg.arrProductStore[j].store_supplier_name+': <strong  style="display:none" id="sys_show_campaign_number_init_'+ deals.cfg.arrProductStore[j].store_supplier_id + '_'+deals.cfg.arrProductLoad[i].products_id+'" class="show_campaign_number_init_'+ deals.cfg.arrProductLoad[i].products_id + '">0</strong><input type="text" id="sys_campaign_number_init_'+ deals.cfg.arrProductStore[j].store_supplier_id + '_'+ deals.cfg.arrProductLoad[i].products_id + '" class="sys_campaign_number_init_'+ deals.cfg.arrProductLoad[i].products_id + '" value="0" size="5"></span><br/>';
                }
                html += '</td>';
                html += '<td><a id="sys_label_edit_'+deals.cfg.arrProductLoad[i].products_id+'" href="javascript:void(0);" onclick="deals.saveProductBox('+ deals.cfg.arrProductLoad[i].products_id +');">Lưu lại</a> &nbsp;|&nbsp; <a href="javascript:void(0);" onclick="deals.deleteProductBox('+ deals.cfg.arrProductLoad[i].products_id +');">Xóa</a></td></tr>';
                $('#dataTable').find('tbody').append(html);
                deals.cfg.countProduct++;
            }
            j++;
        }
    }
    },

    detectPercentDiscount: function(id, price, price_sale) {
        if (isNaN(price_sale))
        {
            alert("Giá bán phải là kiểu số.");
            $('#sys_product_price_sale_'+id).val(0);
            $('#sys_percent_discount_'+id).val(100);
        } else if(price_sale < 0) {
            alert("Giá bán không được nhỏ hơn 0.");
            $('#sys_product_price_sale_'+id).val(0);
            $('#sys_percent_discount_'+id).val(100);
        } else {
            if(price > 0 && price_sale > 0 && price > price_sale) {
                var percent_discount = ( Math.round(100 - ((price_sale/price)*100)) );
                $('#sys_percent_discount_' + id).val(percent_discount);
            } else {
                $('#sys_product_price_sale_' + id).val(0);
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
    },

    validPercent: function(price_discount) {
        if (isNaN(price_discount))
        {
            alert("Giá trị % giảm phải là kiểu số.");
            $('#sys_products_percent_discount').val(0);
        } else if(price_discount < 0) {
            alert("Giá trị % giảm không được nhỏ hơn 0.");
            $('#sys_products_percent_discount').val(0);
        }else if(price_discount > 100) {
            alert("Giá trị % giảm không được lớn hơn 100.");
            $('#sys_products_percent_discount').val(0);
        }
    },

    validPrices: function(price) {
        if (isNaN(price))
        {
            alert("Giá niêm yết phải là kiểu số.");
            $('#sys_products_prices').val(0);
        } else if(price < 0) {
            alert("Giá niêm yết không được nhỏ hơn 0.");
            $('#sys_products_prices').val(0);
        }
    },

    detectPercentDiscount_2: function(price_sale) {
        price = $('#sys_products_prices').val();
        price_sale = parseInt(price_sale.replace(/[., đ]/g, ''));
        price = parseInt(price.replace(/[., đ]/g, ''));

        if(price > 0 && price_sale > 0 && price > price_sale) {
            var percent_discount = ( Math.round(100 - ((price_sale/price)*100)) );
            $('#sys_products_percent_discount').val(percent_discount);
        } else {
            alert('Giá bán không được lớn hơn giá niêm yết.')
            $('#sys_products_prices_sale').val(0);
            $('#sys_products_percent_discount').val(100);
        }
    },

    deleteImg: function() {
        if(confirm('Bạn có muốn xóa ảnh này không?')) {
            $('#campaign_images_old').val('');
            $('#sys_show_image').remove();
        }
    },

    showCampaignType: function(value) {
        if(value == 2) {
            $('#sys_apply_service_time').show();
        } else {
            $('#sys_apply_service_time').hide();
        }
    },

    approveDeal: function(id) {
        if(confirm('Bạn có muốn duyệt deal này không?')) {
            if(id > 0) {
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: WEB_ROOT + 'admin/campaign/approveDeal',
                    data: {
                        id : id
                    },
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(res) {
                        if(res.isIntOk == 1) {
                            $('#show_approve_deal_'+id).html('<a href="javascript:void(0);" class="btn btn-primary approve_deal" onclick="">Đã duyệt</a>');
                        } else if(res.isIntOk == -1) {
                            alert('Bạn không có quyền duyệt deal này.');
                        } else {
                            alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                        }
                    }
                });
            } else {
                alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
            }
        }
    },
    actionTypeDeal: function(type) {
        var list_id_deal = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_id_deal += this.value + ',';
            }
        });
        if(list_id_deal == ''){
            alert('Bạn chưa chọn deal để thiết lập');
        }else{
            if(confirm('Bạn có muốn thiết lập deal này?')) {
                if(type > 0) {
                    $('#img_loading_action_type_deal').show();
                    $.ajax({
                        dataType: 'json',
                        type: 'post',
                        url: WEB_ROOT + 'admin/campaign/ajaxActionTypeDeal',
                        data: {
                            list_id_deal : list_id_deal,type : type
                        },
                        beforeSend: function() {

                        },
                        complete: function() {

                        },
                        success: function(res) {
                            $('#img_loading_action_type_deal').hide();
                            if(res.isIntOk == 1) {
                                alert(res.msg);
                                window.location.reload();
                            } else {
                                alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                            }
                        }
                    });
                } else {
                    alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                }
            }
        }
    }

}

