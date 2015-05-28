/**
 * Created by Vietlh89 on 6/20/14.
 */
var type = 1;
$(document).ready(function(){

    var divEditor = document.getElementById("ck_content");//div bao editor
    var editor = CKEDITOR.replace("textDescrip", { //id editor
        on : {
            'instanceReady' : function( evt ) {
                evt.editor.resize($(divEditor).height(),'500');
                evt.editor.resize($(divEditor).width(),'100%');
            }
        }
    });

    if($('#campaign_start_time_hour').length>0) {
        $('#campaign_start_time_hour').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
    }

    if($('#campaign_end_time_hour').length>0) {
        $('#campaign_end_time_hour').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
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
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('#campaign_end_time')[0].focus();
    }).data('datepicker');
    var checkout = $('#campaign_end_time').datepicker({
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
        checkout.hide();
    }).data('datepicker');

    //tinh % giam
    $("#sys_campaign_price").on("keyup",function(){
        var sys_campaign_price =  campaign.convertStringInt('sys_campaign_price'),
            price_product = parseInt($('#sys_price_product').val()),
            price_percent = 0;
        if(campaign.checkNumber(sys_campaign_price,1) == 2){
            if(sys_campaign_price > price_product){
                alert('Mức giảm không được lớn hơn giá gốc sản phẩm');
                $("#sys_campaign_price").val(price_product);
                campaign.fomatNumber('sys_campaign_price');
                return false;
            }else{
                price_percent = Math.round(100-((sys_campaign_price/price_product)*100));
                $('#sys_campaign_percent').val(price_percent);
                //truyen lai gia vao Box khi nhap gia ban vs th deal
                var type = $('#sys_hidden_campaign').val();
                if(type == 2){
                    if(!$.isEmptyObject(BOX)){
                        var sys_id_product = $('#sys_id_product').val();
                        BOX[-2].campaign_products[sys_id_product].product_price_sale = parseInt(sys_campaign_price);
                        var dataBox = JSON.stringify(BOX[-2]);
                        $('#sys_data_box').val(dataBox);
                    }
                }
                campaign.fomatNumber('sys_campaign_price');
            }
        }else{
            alert('Nhập giá giảm ko hợp lệ');
            $("#sys_campaign_price").val(price_product);
            campaign.fomatNumber('sys_campaign_price');
            return false;
        }
    });

    //tinh muc gia giam
    $("#sys_campaign_percent").on("keyup",function(){
        var sys_campaign_percent =  $("#sys_campaign_percent").val(),
            price_product = parseInt($('#sys_price_product').val()),
            price_campaign = 0;
        if(campaign.checkNumber(sys_campaign_percent,1) == 2){
            if(sys_campaign_percent > 100){
                alert('Mức giảm không được lớn hơn 100%');
                $("#sys_campaign_percent").val(0);
                return false;
            }else{
                price_campaign = Math.round((price_product/100)*(100-sys_campaign_percent));
                $('#sys_campaign_price').val(price_campaign);
                campaign.fomatNumber('sys_campaign_price');
                //truyen lai gia vao Box khi nhap gia ban
                var type = $('#sys_hidden_campaign').val();
                if(type == 1){
                    if(!$.isEmptyObject(BOX)){
                        for(var i in BOX){
                            var box_product = BOX[i].campaign_products;
                            for(var j in box_product){
                                var price = box_product[j].product_price,
                                    product_price_sale = campaign.caculatorPrice(price);
                                BOX[i].campaign_products[j].product_price_sale = parseInt(product_price_sale);
                            }
                        }
                        var dataBox = JSON.stringify(BOX);
                        $('#sys_data_box').val(dataBox);
                    }
                }else{
                    if(!$.isEmptyObject(BOX)){
                        var sys_id_product = $('#sys_id_product').val();
                        BOX[-2].campaign_products[sys_id_product].product_price_sale = parseInt(price_campaign);
                        var dataBox = JSON.stringify(BOX[-2]);
                        $('#sys_data_box').val(dataBox);
                    }
                }
            }
        }else{
            alert('Nhập mức giảm vào ko hợp lệ');
            $("#sys_campaign_price").val(0);
            return false;
        }
    });



    campaign.showDescription(type);
    campaign.showBoxPercent(type);
    campaign.checkedRadio(type);
    campaign.fomatNumber('sys_campaign_price');


    $("body").on("keyup","#sys_txt_search_product", function () {
        delaySomethings(function () {
            var sys_txt_search_product = $("#sys_txt_search_product");
            var keyword = VietnameseWithoutAccent(sys_txt_search_product.val());
            console.log(keyword);
            $(".sys-row-data").addClass("hide-elem");
            for (var i = 0; i < productAdd.length; i++) {
                if (productAdd[i].slug.indexOf(keyword) >= 0) {
                    $("#sys_data_row_" + productAdd[i].products_id).removeClass("hide-elem");
                }
            }
        }, 300);
    });
});
var flag = 0;
var campaignDescription1 = [];
var campaignDescription2 = [];
var productAdd = [];
var arrProductKey=[];
var arrProductPrice=[];
var storeAdd = [];
var arrProductChecked = [];
var arrProductForBox = [];
var BOX = [];
var supplier_name = '';
var linkPromotion = '';
var product_check = '';
var productIsDefault = 0;
var productOrigin = 0;//gia tri san pham ban dau cua deal 1 sp trc khi edit
var id = 1;
var arrProductEdit = [];
var cateParent = [];
var arrProductStore = [];
var campaign = {

    initilize :function(){
        //reset lại dữ liệu đã build trc đó
        arrProductChecked = [];
        arrProductForBox = [];
        BOX = [];
        flag = 0;
        //hien thi muc giam va gia giam de nhap vao
        $('#sys_mess').html('');
        $('#sys_campaign_price').attr('readonly', true);
        $('#sys_campaign_percent').attr('readonly', true);
        $('#sys_campaign_price').val('');
        $('#sys_campaign_percent').val('');
        $("#sys_campaign_percent").css( "background-color","");

        $("#sys_display_box").html('');
        $("#sys_display_box_title").html('');
        $('#sys_box_by_supplier').hide();
        $('#sys_button_edit').hide();
        $('#sys_display_box').hide();
        $('#sys_display_box_title').hide();
        $('#sys_button_edit_title').hide();
    },

    initilizeEdit :function(){
        //reset lại dữ liệu đã build trc đó
        flag = 0;
        //hien thi muc giam va gia giam de nhap vao
        $('#sys_mess').html('');
        $('#sys_campaign_price').val('');
        $('#sys_campaign_percent').val('');
        $("#sys_campaign_percent").css( "background-color","");

        $("#sys_display_box").html('');
        $('#sys_display_box').hide();
    },
    //checked radio
    checkedRadio :function(type){
        var radiobtn = (type == 1)? document.getElementById("sys_campaign_deal1"):document.getElementById("sys_campaign_deal2");
        //an muc mo ta
//        if(type == 2){
//            $('#sys_tool_description').hide();
//        }
        if(radiobtn != null)
            radiobtn.checked = true;
        /*if(product_check == '')
            if(typeof $('#sys_supplier_select').val() != 'undefined')
                document.getElementById('sys_supplier_select').getElementsByTagName('option')[0].selected = 'selected';*/
    },
    //show select box tương ứng
    showPromotionType : function(key){
        //reset lại dl
        this.initilize();
        if(key == 1){
            if(product_check != ''){
                window.location = WEB_ROOT + 'shop/campaign/create';
            }
            //$('#sys_tool_description').show();
            $('#sys_campaign1').show();
            $('#sys_campaign2').hide();
            $("#sys_label_percent").addClass("textleft");
        }else{
            //$('#sys_tool_description').hide();
            $('#sys_campaign2').show();
            $('#sys_campaign1').hide();
            $("#sys_label_percent").removeClass("textleft");
        }
        $('#sys_hidden_campaign').val(key);
        this.showDescription(key);
        this.showBoxPercent(key);
        if(product_check == '')
            if(typeof $('#sys_supplier_select').val() != 'undefined')
                document.getElementById('sys_supplier_select').getElementsByTagName('option')[0].selected = 'selected';
    },

    //show lời dẫn tương ứng với giá trị được chọn
    showDescription : function(type){
        //var type_name = (type == 1)?$('#sys_campaign_deal_or_promotion1').val():$('#sys_campaign_deal_or_promotion2').val(),
        //    str_description = (type == 1)? campaignDescription1[type_name]:campaignDescription2[type_name];
        //$('#sys_description').html('');
        //$('#sys_description').html(str_description);
    },

    //show box giảm giá
    showBoxPercent :function(type){
        var type_name = (type == 1)?$('#sys_campaign_deal_or_promotion1').val():$('#sys_campaign_deal_or_promotion2').val();
        //hiển thị mức giảm %
        if(type_name == 1 || type_name == 5 || type_name == 6 || type_name == 7 || type_name == 8){
            $('#sys_box_percent').show();
            $('#sys_per').show();
        }else{
            $('#sys_box_percent').hide();
            $('#sys_per').hide();
        }
        //hiển thị mức giá giảm
        if(type_name == 5){
            $('#sys_box_price').show();
            $("sys_label_percent").removeClass("control-label col-lg-2");
            $("sys_label_percent").addClass("control-label col-lg-1");
        }else{
            $('#sys_box_price').hide();
            $("sys_label_percent").removeClass("control-label col-lg-1");
            $("sys_label_percent").addClass("control-label col-lg-2");
        }

        //hiển thị số lượng
        if(type_name == 6 || type_name == 8){
            $('#sys_box_quanlity').show();
            $("sys_label_percent").removeClass("control-label col-lg-2");
            $("sys_label_percent").addClass("control-label col-lg-1");
        }else{
            $('#sys_box_quanlity').hide();
            $("sys_label_percent").removeClass("control-label col-lg-1");
            $("sys_label_percent").addClass("control-label col-lg-2");
        }

        //hiển thị tiêu đề thêm
        if(type_name == 1 || type_name == 2 || type_name == 4 || type_name == 3 || type_name == 8){
            $('#sys_box_title').show();
        }else{
            if(id > 0)
                $('#sys_box_title').show();
            else
                $('#sys_box_title').hide();
        }

        //hiển thị spad
        if(type_name == 5 || type_name == 6){
            $('#sys_box_product').show();
        }else{
            $('#sys_box_product').hide();
        }
        //hiển thị spad+spkt
        if(type_name == 7){
            $('#sys_box_product_add').show();
        }else{
            $('#sys_box_product_add').hide();
        }

    },

    //ajax lấy dữ liệu sản phẩm theo ncc
    getListProductBySupplier :function(){
        var supplier = $('#sys_supplier_select').val(),
            from = $.trim($('#campaign_start_time').val()),
            to = $.trim($('#campaign_end_time').val()),
            campaign_type = $.trim($('#sys_hidden_campaign').val()),
            mess = '';
        //them kiem tra khoang thoi gian trung sp
        //type = $('#sys_hidden_campaign').val(),
        //type_name = (type == 1)?$('#sys_campaign_deal_or_promotion1').val():$('#sys_campaign_deal_or_promotion2').val();
        //reset du lieu da build trc do
        this.initilize();
        if(supplier > 0){
            //check thời gian
            if(!this.checkEmpty(from)){
                mess += "Hãy chọn thời gian bắt đầu </br>";
            }

            //check thời gian
            if(!this.checkEmpty(to)){
                mess += "Hãy chọn thời gian kết thúc </br>";
            }
            $('#sys_mess').html('');
            if(this.checkEmpty(mess)){
                $('#sys_mess').html(mess);
                $('#sys_mess_form').show();
                $("html, body").animate({ scrollTop: 0 }, 500);
                $("#campaign_start_time").focus();
                $("#campaign_start_time").css( "background-color","#FFE4B5");
                return false;
            }else{
                //ko cho chuyen doi trong khi dang goi ajax
                $('#sys_supplier_select').attr('disabled', true);
                $('#img_loading').show();
                $('#sys_mess_form').hide();
                $("#campaign_start_time").css( "background-color","");
            }

            if(supplier > 0 && this.checkEmpty(from) && this.checkEmpty(to)){
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: 'getListDataSupplier',
                    data: {
                        supplier : supplier,
                        from : from,
                        to : to
                        //type_name : type_name
                    },
                    success: function(res) {
                        if(res.status){
                            if(res.status == 2){
                                window.location = linkAdmin+'logout';
                            }else{
                                //lấy dữ liệu về sp + kho theo ncc
                                productAdd = res.dataProduct;
                                lengthProduct = productAdd.length;
                                storeAdd = res.arrStore;
                                lengthStore = storeAdd.length;
                                arrProductKey = res.arrProduct;
                                arrProductPrice = res.listProductPrice;
                                console.log(lengthProduct);
                                console.log(lengthStore);
                                if(lengthProduct > 0 && lengthStore >0){
                                    $("#sys_title_label").show();
                                    $("#sys_product").show();
                                    $('#sys_box_by_supplier').show();
                                    //focus vao nhap tieu de box luon
                                    $("#sys_campaign_title").focus();
                                    $("#sys_campaign_title").css( "background-color","#FFE4B5");
                                }else{
                                    $('#sys_box_by_supplier').hide();

                                    var mess = '';
                                    if(lengthProduct == 0){
                                        mess += 'Không có sản phẩm nào của ncc có thể áp dụng trong khoảng thời gian vừa chọn';
                                    }

                                    if(lengthStore == 0){
                                        mess += 'NCC chưa có kho nên không thể tạo được campaign';
                                    }
                                    //thong bao neu khong thay sp hc kho
                                    if(mess != ''){
                                        $('#sys_mess').html(mess);
                                        $('#sys_mess_form').show();
                                        $("html, body").animate({ scrollTop: 0 }, 500);
                                    }
                                }
                                campaign.showProduct(-1);
                                //build select box
                                $("#sys_select_product").html('');
                                $("#sys_select_product").html(res.temp_mutil);
                                $("#sys_select_product_add1").html('');
                                $("#sys_select_product_add1").html(res.temp);
                                $("#sys_select_product_add2").html('');
                                $("#sys_select_product_add2").html(res.temp2);
                                //reset du lieu tieu de
                                $("#sys_campaign_title").val('');
                                if(campaign_type == 1){
                                    $("#sys_box_title").show();
                                    $("#sys_box_product").hide();
                                }else{
                                    $("#sys_box_title").hide();
                                    $("#sys_box_product").show();
                                }
                            }
                        }
                        $('#img_loading').hide();
                        $('#sys_supplier_select').attr('disabled', false);
                    }
                });
            }else{
                $('#sys_box_by_supplier').hide();
                $('#sys_supplier_select').attr('disabled', false);
            }
        }
    },

    //ajax lấy dữ liệu sản phẩm theo ncc
    getListProductBySupplierEdit :function(supplier_data){
        var supplier = (supplier_data > 0)? supplier_data :0,
            from = $.trim($('#campaign_start_time').val()),
            to = $.trim($('#campaign_end_time').val()),
            mess = '';

        //reset du lieu da build trc do
        this.initilizeEdit();
        if(supplier > 0){
            //check thời gian
            if(!this.checkEmpty(from)){
                mess += "Hãy chọn thời gian bắt đầu </br>";
            }

            //check thời gian
            if(!this.checkEmpty(to)){
                mess += "Hãy chọn thời gian kết thúc </br>";
            }
            $('#sys_mess').html('');
            if(this.checkEmpty(mess)){
                $('#sys_mess').html(mess);
                $('#sys_mess_form').show();
                $("html, body").animate({ scrollTop: 0 }, 500);
                $("#campaign_start_time").focus();
                $("#campaign_start_time").css( "background-color","#FFE4B5");
                return false;
            }else{
                $('#img_loading').show();
                $('#sys_mess_form').hide();
                $("#campaign_start_time").css( "background-color","");
            }

            if(supplier > 0 && this.checkEmpty(from) && this.checkEmpty(to)){
                var productDataOrigin = [];
                for(var k in arrProductChecked){
                    if(arrProductChecked[k] != undefined){
                        var i = 0;
                        productDataOrigin[i] =
                             {
                                product_name: arrProductKey[arrProductChecked[k]],
                                product_id: arrProductChecked[k],
                                product_price: arrProductPrice[arrProductChecked[k]]
                            };
                        i++;
                    }
                }
                productDataOrigin = JSON.stringify(productDataOrigin);
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: 'getListDataSupplier',
                    data: {
                        supplier : supplier,
                        from : from,
                        to : to,
                        productDataOrigin : productDataOrigin,
                        campaignId : id
                    },
                    success: function(res) {
                        if(res.status){
                            if(res.status == 2){
                                window.location = linkAdmin+'logout';
                            }else{
                                //lấy dữ liệu về sp + kho theo ncc
                                productAdd = res.dataProduct;
                                lengthProduct = productAdd.length;
                                storeAdd = res.arrStore;
                                lengthStore = storeAdd.length;
                                arrProductKey = res.arrProduct;
                                arrProductPrice = res.listProductPrice;
                                console.log(lengthProduct);
                                console.log(lengthStore);
                                if(lengthProduct == 0 || lengthStore == 0){
                                    var mess = '';
                                    if(lengthProduct == 0){
                                        mess += 'Không có sản phẩm nào của ncc có thể áp dụng trong khoảng thời gian vừa chọn';
                                    }

                                    if(lengthStore == 0){
                                        mess += 'NCC chưa có kho nên không thể tạo được campaign';
                                    }
                                    //thong bao neu khong thay sp hc kho
                                    if(mess != ''){
                                        $('#sys_mess').html(mess);
                                        $('#sys_mess_form').show();
                                        $("html, body").animate({ scrollTop: 0 }, 500);
                                    }
                                }

                                //build select box
                                $("#sys_select_product").html('');
                                $("#sys_select_product").html(res.temp_mutil);
                                $("#sys_select_product_add1").html('');
                                $("#sys_select_product_add1").html(res.temp);
                                $("#sys_select_product_add2").html('');
                                $("#sys_select_product_add2").html(res.temp2);
                                //reset du lieu tieu de
                                $("#sys_campaign_title").val('');
                            }
                        }
                        $('#img_loading').hide();
                    }
                });
            }else{
                $('#img_loading').hide();
            }
        }
    },

    //voi spad da dc chon thi ko hien o select box spkt
    disableProduct :function(){
        var product = $('#sys_campaign_product_ad1').val(),
            html = '';
        html = '<select name="sys_campaign_product_add2" id="sys_campaign_product_add2" class="form-control input-sm">';
        for( var i in productAdd){
            if(i != product || product == 0){
                html += '<option value="'+i+'" >'+productAdd[i]+'</option>';
            }
        }
        html += '</select>';
        $("#sys_select_product_add2").html('');
        $("#sys_select_product_add2").html(html);
    },

    //an hien cac nut chon sp va nut them box khi title rong
    disableButton : function(){
        var title = $('#sys_campaign_title').val();
        if($.trim(title) != ''){
            if(flag == 0)
                $('#sys_button_add_product').show();
            else
                $('#sys_button_edit_title').show();
            //$('#sys_button').show();
        }else{
            if(flag == 0)
                $('#sys_button_add_product').hide();
            else
                $('#sys_button_edit_title').hide();
            //$('#sys_button').hide()
        }
    },

    //show pop up chon product
    showProduct : function(key){
        var key_box = (key == -1)? $("#sys_campaign_title").val():BOX[key].campaign_box_name,
            length = productAdd.length,
            productForBox = (typeof arrProductForBox[key_box] != 'undefined')?arrProductForBox[key_box]:[];//nếu thêm mới thì là mảng hiển thị
        if(supplier_name != ''){
            strUser = supplier_name;
        }else{
            /*var name_supplier = document.getElementById("sys_supplier_select"),
                strUser = name_supplier.options[name_supplier.selectedIndex].text;*/
            strUser = $('#sys_supplier_select').val();
        }
        //nếu tạo box mới thi gan ten da nhap vao the hidden -  phuc vu viec sua tieu de
        if(key == -1)
            $('#sys_campaign_title_hidden').val(key_box);

        $('#myModalLabel').html('');
        //$('#myModalLabel').html('Nhà cung cấp - '+strUser);
        var html = '<div class="box" style="border : 1px solid;">';
        html +='<header>';
        html +=' <h5>Danh sách sản phẩm chưa được chọn</h5>';
        html +='<div class="toolbar">';
        html +='<div class="btn-group">';
        html +='<a href="#defaultTable" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">';
        html +='<i class="fa fa-angle-up"></i>';
        html +='</a></div></div></header>';
        html +=' <div id="div-4" class="body clearfix">';
        html +='<div class="margin-left-1 col-lg-3" id="sys_button_accept_product" >';
        html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.acceptProduct('+key+');">Chọn sản phẩm</button></div>';
        html +='<div class="col-lg-7" style="float:right"><input type="text" id="sys_txt_search_product" placeholder="Nhập tên sản phẩm cần tìm" class="col-lg-12" style="line-height: 32px;clear:both"/></div>';
        html +='</div>';
        html +='<div id="defaultTable" class="body collapse in">';
        html +='<table class="table responsive-table">';
        html +='<thead><tr>';
        html +='<th>Tên SP</th>';
        html +='<th>Chọn</th></tr></thead><tbody>';
        if(length > 0){
            for( var i in productAdd){
                html += '<tr id="sys_data_row_'+ productAdd[i].products_id +'" class="sys-row-data">';
                html += '<td><p class="word2">' + productAdd[i].products_name+'</p></td>';
                html += '<td><input class="uniform" name="product_'+productAdd[i].products_id+'" type="checkbox" id="product_'+productAdd[i].products_id+'" value="'+productAdd[i].products_id+'"';
                if(this.inArray(productAdd[i].products_id,arrProductChecked)){
                    if(this.inArray(productAdd[i].products_id,productForBox)){
                        html += ' checked';
                    }else{
                        html += ' disabled';
                    }
                }
                html +='></td>';
                html += '</tr>';
            }
        }
        html +='</tbody></table></div>';
        html += '</div>';
        $("#sys_modal_body").html('');
        $("#sys_modal_body").html(html);
        $('#myModal').modal('show');
    },

    checkArray : function(id) {
        for(var i = 0, len = arrProductChecked.length; i < len; i++){
            if(arrProductChecked[i] == id){
                return true;
            }
        }
        return false;
    },

    //ẩn pop up để chọn lại sp cho deal
    showProductForDeal :function(){
        $("#sys_modal_body").html('');
        $('#sys_box_product').show();//mở lại select box chọn lại sp
        $('#myModal').modal('hide');

        //sys_campaign_product
        $("html, body").animate({
            scrollTop: $("#sys_campaign_product").offset().top
        },1000,function(){
            $("#sys_campaign_product").addClass("focus");
            $("body").on("click.hideFocus",function(){
                $("#sys_campaign_product").removeClass("focus");
                $("body").off("click.hideFocus");
            });
        });
    },

    //build mang sp da dc chon va sp chon cho box dang xet
    acceptProduct :function(key){
        var productForBox = [],
            j = 0;
        //mảng sp đã đc chọn arrProductChecked
        lengthProductChecked = arrProductChecked.length;
        for( var i in productAdd){
            if($("#product_"+productAdd[i].products_id).is(':checked')){
                //kt xem thuộc mảng đã check chưa
                if( !this.checkArray(productAdd[i].products_id)){
                    arrProductChecked[arrProductChecked.length] = productAdd[i].products_id;
                }
                productForBox[j] = productAdd[i].products_id;
                j++;
            }else{
                if(!$("#product_"+productAdd[i].products_id).is(":disabled"))
                    this.deleteProductAll(productAdd[i].products_id);
            }
        }
        //kiem tra da chon sp cho Box hay chưa,nếu chưa ko cho tạo Box
        if($.isEmptyObject(productForBox)){
            alert('Bạn phải chọn sản phẩm khuyến mại cho deal');
            return false;
        }else{
            //gán lại sản phẩm đc chọn cho Box cho biến global
            var index = (key == -1)? $("#sys_campaign_title").val():BOX[key].campaign_box_name;
            arrProductForBox[index] = productForBox;
            if(key == -1)
                var type = 0;
            else
                var type = 1;
            var html = this.buildBoxProduct(key,type);
            //hiển thị box sp + nút sửa tiêu đề,ẩn tiêu đề đi
            $("#sys_display_box").html('');
            $("#sys_display_box").html(html);
            $("#sys_display_box").show();
            //$("#sys_button_edit").hide();
            $("#sys_title_label").hide();
            $("#sys_button_add_product").hide();
            $("#sys_product").hide();
            $("#sys_button_cancel").hide();
            $('#myModal').modal('hide');
            if($('#title_'+key).length > 0){
                $("#title_"+key).html('');
            }
        }
    },

    //tạo BOX cho trường hợp chọn sp áp dụng
    acceptProductForDeal :function(){
        var selectProduct = $('#sys_campaign_product').val();
        if(selectProduct > 0){
            productSelect = selectProduct;
            var key = -2,
                type = 1;
            this.showEditBox(key,type);
        }
    },

    //key laf id cua box,type de phan biet giua viec chon sp cho box moi va box cu
    buildBoxProduct :function(key,type){
        //key để xác định là tạo mới hay edit box có sẵn -key =-1 (box mới)
        var name_box = (key == -1)?($('#sys_campaign_title').val()): ((key == -2)?'box_default':BOX[key].campaign_box_name),
        //length = arrProductForBox[name_box].length,
            productForBox = [];
        if(key == -2){
            var value = $('#sys_campaign_product').val(),
                index = 0;
            productForBox[index] = value;
        }else{
            productForBox = arrProductForBox[name_box];
        }

        var html = '<div class="box frm-edit-number" style="margin-top:0">';
        html +='<header>';
        html +=' <h5>Danh sách sản phẩm chọn</h5>';
        html +='<div class="toolbar">';
        html +='<div class="btn-group">';
        html +='<a href="#defaultTable" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">';
        html +='<i class="fa fa-angle-up"></i>';
        html +='</a></div></div></header>';
        html +=' <div id="div-4" class="body clearfix">';
        html +='<div class="col-lg-3 margin-left-1" id="sys_button_accept_product" >';
        html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.saveProduct('+key+');">Hoàn thành</button></div>';
        html +='<div class="col-lg-4 margin-left-1">';
        if(key == -2){
            if(product_check == ''){
                html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.showProductForDeal();">Chọn lại sản phẩm</button></div>';
            }
        }else{
            html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.showProduct('+key+');">Chọn lại sản phẩm</button></div>';
        }
        //với chúc năng tạo box mới có sửa tiêu đề
        /*
        if(key != -2){
            html +='<div class="col-lg-3 margin-left-1">';
            html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.showEditTitle('+key+');">Sửa tiêu đề</button></div>';
        }
        //khi đã tạo xong box thì thêm thao tác xóa
        if(key > -1){
            html +='<div class="col-lg-1 margin-left-1">';
            html +=' <button class="btn btn-default btn-sm btn-line text-right" type="button"  onclick="javascript:campaign.deleteBox('+key+');">Xóa box</button></div>';
        }*/
        html +='</div>';
        html +='<div id="defaultTable" class="body collapse in">';
        html +='<table class="table responsive-table">';
        html +='<thead><tr>';
        html +='<th>STT</th>';
        html +='<th width="40%">Tên sản phẩm</th>';
        html +='<th>SP đại diện</th>';
        html +='<th>Giảm giá(%)</th>';
        for( var i in storeAdd){
            html +='<th>Số lượng ở<br/>'+storeAdd[i].store_supplier_name+'</th>';
        }
        html +='</tr></thead><tbody>';
        var checkBox = 2;
        if(key == -2){
            checkBox = (typeof BOX[key] != 'undefined')?1:0;
        }
        if(key == -1 || checkBox == 0 || type ==1){
            for( var i in productForBox){
                var index = productForBox[i];
                html += '<tr>';
                html += '<td>'+(parseInt(i)+1)+'</td>';
                html += '<td><p class="word2">' + arrProductKey[index]+'</br>(<span style="color: #226699">'+arrProductPrice[index]+'</span>Vnd)</p></td>';
                if(key == -2){
                    html += '<td><div class="checkbox"><label><input class="uniform" type="radio" name="product_is_default" id="product_is_default_'+index+'"'+ ((i==0) ? 'checked="checked"':'') +'></label></div>';
                }else{
                    html += '<td><div class="checkbox"><label><input class="uniform" type="radio" name="product_is_default" id="product_is_default_'+index+'"'+ ((i==0) ? 'checked="checked"':'') +'></label></div>';
                }
                html += '<td><input maxlength="10" autocomplete="off" onkeyup="javascript:campaign.validatePercent(this.value, this.id)"  type="text" id="sys_product_percent_discount_'+ i +'" name="sys_product_percent_discount_'+ i +'" value="0"  placeholder="" class="form-control" /></td>';
                for( var j in storeAdd){
                    html +='<td><div>';
                    html += '<input maxlength="10" autocomplete="off" onkeyup="javascript:campaign.validateQuanlity('+storeAdd[j].store_supplier_id+','+index+');"  type="text" id="sys_store_quanlity_'+storeAdd[j].store_supplier_id+'_'+index+'" name="sys_store_quanlity_'+storeAdd[j].store_supplier_id+'_'+index+'" value="0" placeholder="" class="form-control" />';
                    html +=' </div></td>';
                }
                html += '</tr>';
            }
        }else{
            var productForBoxByKey = BOX[key].campaign_products;
            var id_x = 0;
            for( var i in productForBoxByKey){
                var index = i,
                    del_flag = ( productForBoxByKey[i] != undefined && productForBoxByKey[i].campaign_products_del_flag != undefined)?productForBoxByKey[i].campaign_products_del_flag:0;
                html += '<tr>';
                html += '<td>'+(parseInt(i)+1)+'</td>';
                if(del_flag == 0){
                    html += '<td><p class="word2">' + arrProductKey[index]+'</br>(<span style="color: #226699">'+arrProductPrice[index]+'</span>Vnd)</p></td>';
                }
                if(del_flag == 0){
                    if(index == productIsDefault){
                        html += '<td><div class="checkbox"><label><input class="uniform" type="radio" name="product_is_default" id="product_is_default_'+index+'" checked></label></div></td>';
                    }else{
                        html += '<td><div class="checkbox"><label><input class="uniform" type="radio" name="product_is_default" id="product_is_default_'+index+'"></label></div></td>';
                    }
                }
                html += '<td><input maxlength="10" autocomplete="off" onkeyup="javascript:campaign.validatePercent(this.value, this.id)"  type="text" id="sys_product_percent_discount_'+ id_x +'" name="sys_product_percent_discount_'+ id_x +'" value="'+arrProductPercent[id_x]+'" placeholder="" class="form-control"  /></td>';
                for( var j in storeAdd){
                    if(del_flag == 0){
                        var store = (typeof productForBoxByKey[i].store_supplier_campaign[storeAdd[j].store_supplier_id] != 'undefined')? productForBoxByKey[i].store_supplier_campaign[storeAdd[j].store_supplier_id]:'',
                            quanlity = (store != '')? store.store_supplier_campaign_number_init:'',
                            strValue = (quanlity != '')? 'value = "'+quanlity+'"':'value = ""';
                        html +='<td><div>';
                        html += '<input maxlength="10" autocomplete="off" onkeyup="javascript:campaign.validateQuanlity('+storeAdd[j].store_supplier_id+','+index+');"  type="text" id="sys_store_quanlity_'+storeAdd[j].store_supplier_id+'_'+index+'" name="sys_store_quanlity_'+storeAdd[j].store_supplier_id+'_'+index;
                        html +='"class="form-control" '+strValue+'/>';
                        html +=' </div></td>';
                    }
                }
                html += '</tr>';
                id_x++;
            }
        }
        html +='</tbody></table></div>';
        html += '</div>';
        return html;
    },

    //hiển thị sửa title
    showEditTitle :function(key){
        flag = 1;
        //tao lai nut hoan thanh chinh tieu de theo key
        var html = this.buildButtonEditTitle(key);
        $("#sys_button_edit_title").html(html);

        $("#sys_display_box").hide();
        $("#sys_button_edit").hide();
        $("#sys_title_label").show();
        $("#sys_product").show();

        //ẩn box sửa san phẩm-reset lại box
        $("#sys_modal_body").html('');
        $('#myModal').modal('hide');
    },

    buildButtonEditTitle:function(key){
        var html = '<button class="btn btn-default btn-sm btn-line" type="button"   onclick="javascript:campaign.hideEditTitle('+key+');">Hoàn thành</button>';
        return html;
    },

    //ẩn hiển thị sửa title
    hideEditTitle :function(key){
        //lay gia ten moi va cu de thuc hien viec gan lai mang sp gan voi box
        var old_name_box = (key == -1)?$('#sys_campaign_title_hidden').val():BOX[key].campaign_box_name,
            new_name_box = $('#sys_campaign_title').val(),
            productNewName = arrProductForBox[old_name_box],//gan lai mang sp cho box da doi ten
            productEditNewName = [];
        //neu moi khoi tao thi gan lai ten moi vao hidden else gan lai ten moi cho box tuong ung
        if(!$.isEmptyObject(arrProductEdit) && arrProductEdit[old_name_box] != undefined){
            productEditNewName = arrProductEdit[old_name_box];
        }
        if(key == -1)
            $('#sys_campaign_title_hidden').val(new_name_box);
        else
            BOX[key].campaign_box_name = new_name_box;
        delete arrProductForBox[old_name_box];//xoa key cu
        //this.deleteIndexBox(old_name_box,arrProductForBox)
        //build lai title edit khi sua ten voi nhung box da co trong dl
        if(key > -1){
            $('span[id^="title_'+key+'"]').remove();
            var html = this.buildHtmlTitle(key,new_name_box);//build lai title hien thi ten da thay doi
            type = 1;
            this.addHtmlTitle(key,html,type);//html title -hien thi len
        }

        flag = 0;
        if(key == -1)
            $("#sys_display_box").show();
        else
            $("#sys_display_box").hide();

        $("#sys_title_label").hide();//an o nhap title
        $("#sys_product").hide();
        $('#sys_button_edit_title').hide();
        //chuyển key cho mảng id sp gắn vs box
        arrProductForBox[new_name_box] = productNewName;//gan lai ten moi cho mang sp da dc chon cua box

        if(!$.isEmptyObject(arrProductEdit) && !$.isEmptyObject(productEditNewName) && arrProductEdit[old_name_box] != undefined){
            delete arrProductEdit[old_name_box];//xoa key cu
            arrProductEdit[new_name_box] = productEditNewName;//gan lai ten moi cho mang sp da dc chon cua box
        }

        $('#name_box').html('');
        $('#name_box').html(new_name_box);//gan lai ten moi hien thi tren box
    },

    //kiem tra index co trong mang khong
    inArray :function (id,arr){
        for(var i = 0, len = arr.length; i < len; i++){
            if(arr[i]==id){
                return true;
            }
        }
        return false;
    },

    saveProduct :function(key){
        //key để xác định là tạo mới hay edit box có sẵn -key =-1 (box mới)
        var campaign_box_name = (key == -1)?$('#sys_campaign_title').val():((key == -2)?'box_default':BOX[key].campaign_box_name),//ten box
            campaign_products = [],
            productForBox = [],//mang sp
            checkQuanlity = 1,
            priceAceeptProduct = 0,
            idAcceptProduct= 0,
            product_default = 0,
            quanlity_checked = 0,
            campaign_box_del_flag = 0,
            campaign_box_id = ( BOX[key] != undefined && BOX[key].campaign_box_id != undefined  )?BOX[key].campaign_box_id:0;//kiem tra da co kho nao có sl chua,nếu có mới cho tạo BOX
        campaign_box_name = $.trim(campaign_box_name);//trim ten box lai
        if(id > 0 && key != -1 && campaign_box_id > 0){
            campaign_box_del_flag = BOX[key].campaign_box_del_flag;
            campaign_box_id = BOX[key].campaign_box_id;
        }
        //xet id san pham cho Box
        var value = parseInt($('#sys_campaign_product').val());
        if(key == -2){
            //build
            if($("#product_is_default_"+value).is(":checked")){
                productIsDefault = value;
                var box_default = [];
                box_default[0] = value;
                arrProductForBox[campaign_box_name] = box_default;
                arrProductChecked[0] = value;
            }

            if(productIsDefault == productOrigin){
                productForBox = arrProductForBox[campaign_box_name];
            }else{
                var index = 0;
                productForBox[index] = value;
            }
        }else{
            productForBox = arrProductForBox[campaign_box_name];
        }
        arrProductStore = [];
        for(var j in storeAdd){
            var storeQuanlity = [];
            arrProductChecked.forEach(function(itm) {
                storeQuanlity[itm] = parseInt($('#sys_store_quanlity_'+storeAdd[j].store_supplier_id+'_'+itm).val());
            });
            arrProductStore[j] = storeQuanlity;
        }
        //build mang sp theo box
        for( var i in productForBox){
            var product_id = productForBox[i],
                product_price = arrProductPrice[product_id],
                store_supplier_campaign = [];
            if(key == -2){
                priceAceeptProduct = product_price;
                idAcceptProduct = product_id;
            }
            //build mang voi moi sp
            for(var j in storeAdd){
                var store_supplier_id = storeAdd[j].store_supplier_id,
                    quanlity = $('#sys_store_quanlity_'+store_supplier_id+'_'+product_id).val();
                if($("#product_is_default_"+product_id).is(":checked")){
                    product_default = product_id;
                    if(!isNaN(quanlity) && quanlity > 0 && quanlity_checked === 0)
                        quanlity_checked = parseInt(quanlity);
                }
                if(!isNaN(quanlity)){
                    if(quanlity > 0){
                        var itemStore = {
                            store_supplier_campaign_number_init: parseInt(quanlity),
                            store_supplier_id: store_supplier_id
                        };
                        store_supplier_campaign[store_supplier_id] = itemStore;
                    }
                }
            }
            if($.isEmptyObject(store_supplier_campaign)){
                checkQuanlity = 0;
            }


            var product_price_sale = this.caculatorPrice(product_price);
            if(id > 0 && checkQuanlity > 0 && key != -1){
                if(arrProductEdit[campaign_box_name] == undefined || !this.inArray(product_id,arrProductEdit[campaign_box_name])){
                    var itemProduct = {
                        product_price : product_price,
                        product_price_sale: parseInt(product_price_sale),
                        products_id : product_id,
                        store_supplier_campaign : store_supplier_campaign,
                        product_is_default : 0
                    }
                } else {
                    var itemProduct = {
                        product_price : product_price,
                        product_price_sale: parseInt(product_price_sale),
                        products_id : product_id,
                        store_supplier_campaign : store_supplier_campaign,
                        product_is_default : 0
                    }
                }
            }else{
                var itemProduct = {
                    product_price : product_price,
                    product_price_sale: parseInt(product_price_sale),
                    products_id : product_id,
                    store_supplier_campaign : store_supplier_campaign,
                    product_is_default : 0
                }
            }
            campaign_products[product_id]= itemProduct;

        }
        //danh dau san pham da bi xoa
        if(id >0  && checkQuanlity > 0 && key != -1){
            var dataProduct = BOX[key].campaign_products,
                nameBox = BOX[key].campaign_box_name;
            for(var p in dataProduct){
                if(arrProductEdit[nameBox] != undefined && typeof p != 'undefined' && this.inArray(parseInt(p),arrProductEdit[nameBox])){
                    var product_id = parseInt(p),
                        campaign_products_del_flag = (this.inArray(product_id,arrProductForBox[nameBox]))?0:1,
                        campaign_products_id = BOX[key].campaign_products[product_id].campaign_products_id,
                        store_supplier_campaign = campaign_products[product_id].store_supplier_campaign,
                        product_price = arrProductPrice[product_id],
                        product_price_sale = this.caculatorPrice(product_price);
                    var itemProduct = {
                        product_price : product_price,
                        product_price_sale: parseInt(product_price_sale),
                        products_id : product_id,
                        store_supplier_campaign : store_supplier_campaign,
                        product_is_default : 0,
                        campaign_products_del_flag : campaign_products_del_flag,
                        campaign_products_id : campaign_products_id
                    }
                    campaign_products[p]= itemProduct;
                }
            }
        }

        if(checkQuanlity > 0){
            if(product_default > 0){
                if(!isNaN(quanlity_checked) && quanlity_checked > 0){
                    productIsDefault = product_default;
                    $('#sys_product_is_default').val(productIsDefault);
                }else{
                    alert('Hãy nhập số lượng kho của sản phẩm');
                    return false;
                }
            }
            if(id > 0 && key != -1 && campaign_box_id > 0){
                var itemBox = {
                    campaign_box_name: campaign_box_name,
                    campaign_box_del_flag: campaign_box_del_flag,
                    campaign_box_id: campaign_box_id,
                    campaign_products: campaign_products
                };
            }else{
                var itemBox = {
                    campaign_box_name: campaign_box_name,
                    campaign_products: campaign_products
                };
            }
            arrProductPercent = [];
            for(var c in arrProductChecked) {
                arrProductPercent[c] = parseInt($('#sys_product_percent_discount_' + c).val());
            }
            $('#sys_product_percent_discount').val(JSON.stringify(arrProductPercent));

            var typeTitle = 0;
            if(key == -1 || key == -2){
                if(key == -2){
                    //khởi tạo lại BOX
                    BOX = [];
                    index = key;
                }else{
                    index = BOX.length;
                }
                BOX[index] = itemBox;
                var html = this.buildHtmlTitle(index,campaign_box_name);
            }else{
                //xoa va build lai
                delete BOX[key];
                //BOX.splice(key,1);
                BOX[key] = itemBox;
                $('#myModal').modal('hide');
                if($('#title_'+key).length == 0){
                    var html = this.buildHtmlTitle(key,campaign_box_name);
                }else{
                    $('span[id^="title_'+key+'"]').remove();
                    var html = this.buildHtmlTitle(key,campaign_box_name);//build lai title hien thi ten da thay doi
                }
                typeTitle = 1;
            }
            //chuyen dl Box ve dang json
            if(key == -2){
                var dataBox = JSON.stringify(BOX[key]);
            }else{
                var dataBox = JSON.stringify(BOX);
            }

            $('#sys_data_box').val(dataBox);
            //xóa bảng sửa box -> tiêu đề cho gọn
            $("#sys_display_box").html('');
            this.addHtmlTitle(key,html,typeTitle);//html title -hien thi len
            $('#sys_box_by_supplier').show();
            $("#sys_display_box_title").show();

            //hien thi muc giam va gia giam de nhap vao
            $('#sys_campaign_price').attr('readonly', false);
            $('#sys_campaign_percent').attr('readonly', false);

            //neu chon sp chu ko build box thi ko cho hien nut them
            if(key != -2){
                $('#sys_button').show();
                $('#sys_box_title').show();
            }else{
                $('#sys_box_title').show();
                $('#sys_box_product').hide();
                $("#sys_title_label").hide();
                $("#sys_product").hide();
                $('#sys_button').hide();//an nut them
                $('#myModal').modal('hide');

                //tu fill gia sp vao o gia giam va muc giam + gan gia an de so sanh
               // if($('#sys_campaign_price').val() == ''){
                    $('#sys_campaign_price').val(priceAceeptProduct);
                    campaign.fomatNumber('sys_campaign_price');
                    $('#sys_campaign_percent').val(0);
                //}

                $('#sys_price_product').val(priceAceeptProduct);
                $('#sys_id_product').val(idAcceptProduct);
            }
            //$("html, body").animate({ scrollTop: 0 }, 600);
            $("#sys_campaign_percent").focus();
            $("#sys_campaign_percent").css( "background-color","#FFE4B5");

            $('#sys_button_cancel').hide();
            $("#sys_display_box").hide();//an hien thi box

            if(supplier_name != '')
                $('#box_fix').html('');
            //neu sp default bi xoa thi gan lai sp default = 0
            if(productIsDefault > 0){
                if(!this.inArray(productIsDefault,arrProductChecked)){
                    productIsDefault = 0;
                    $('#sys_product_is_default').val(productIsDefault);
                }
            }
        }else{
            alert('Sản phẩm phải nhập kho mới được tạo deal');
            return false;
        }
    },

    deleteBox:function(key){
        $('span[id^="title_'+key+'"]').remove();//xoa title de sua box
        //xoa box hien thi
        $('#myModal').modal('hide');
        $("#sys_modal_body").html('');
        //xoa Box
        if(typeof BOX[key] != 'undefined' ){
            var campaign_box_name = BOX[key].campaign_box_name,
                productByKey = arrProductForBox[campaign_box_name],
                campaign_box_id = (BOX[key] != undefined && BOX[key].campaign_box_id != undefined)?BOX[key].campaign_box_id:0;
            //xóa trong arr checked
            for(var i in productByKey){
                if(productByKey[i] == productIsDefault){
                    productIsDefault = 0;
                    $('#sys_product_is_default').val(productIsDefault);
                }
                this.deleteProductAll(productByKey[i]);
                //if(this.inArray(i,))
            }
            //xóa trong arrForBox
            delete arrProductForBox[campaign_box_name];
            if(campaign_box_id == 0){
                delete BOX[key];
            }else{
                BOX[key].campaign_box_del_flag = 1;
            }

            //chuyen dl Box ve dang json
            if(key == -2){
                var dataBox = JSON.stringify(BOX[key]);
            }else{
                var dataBox = JSON.stringify(BOX);
            }

            $('#sys_data_box').val(dataBox);
        }
    },

    //type = 1 cho phep append
    addHtmlTitle:function(key,html,type){
        if(key == -1 || type == 1){
            $("#sys_display_box_title").append(html);
        }else if(key == -2){
            $("#sys_display_box_title").html(html);
        }
    },

    caculatorPrice :function(price){
        var type = $('#sys_hidden_campaign').val(),
            percent = ($('#sys_campaign_percent').val() != '' && !isNaN($('#sys_campaign_percent').val()))?$('#sys_campaign_percent').val():0,
            price_sale = 0;
        if(type == 1){
            price_sale = Math.round(((100 - percent)*price)/100);
        }else{
            var campaign_price = parseInt($('#sys_campaign_price').val());
            if(this.checkNumber(campaign_price,1) != 2){
                campaign_price = 0;
            }
            price_sale = parseInt(campaign_price);
        }
        if(isNaN(price_sale))
            price_sale = 0;
        return price_sale;
    },

    //build title thu gọn sau khi dựng xong 1 box,truyền key của box vào để thuận tiện khi thực hiện edit
    buildHtmlTitle :function(key,campaign_box_name){
        var html = '<span id="title_'+key+'">';
        html +='<table class="table responsive-table">';
        html +='<thead><tr>';
        html +='<th width="5%">STT</th>';
        html +='<th width="50%">Tên sản phẩm</th>';
        html +='<th width="20%" style="text-align:right">Giảm giá(%)</th>';
        html +='<th width="25%" style="text-align:right">Số lượng</th>';

        html +='</tr></thead><tbody>';
        var id_x = 0;
        for( var i in arrProductChecked){
            var index = arrProductChecked[i];
            html += '<tr>';
            html += '<td align="left">'+(id_x+1)+'</td>';
            html += '<td>' + productAdd[i].products_name +'</td>';
            html += '<td align="right">' + arrProductPercent[id_x]+'</td>';
            html += '<td align="right">';
            for( var k in arrProductStore){
                html += 'tại ' + storeAdd[k].store_supplier_name+ ': ' +((arrProductStore[k][index]>0) ? arrProductStore[k][index] : 0) + '<br/>';
            }
            html += '</td>';
            html += '<tr>';
            id_x++;
        }
        html +='</thead><tbody>';
        //html +='<p id="sys_description" class="col-lg-8 word" style="color: #3D3D3D;">Click để sửa sản phẩm của deals</p></a></span>';
        return html;
    },

    showEditBox :function(key,type){
        if(supplier_name == ''){
            /*var name_supplier = document.getElementById("sys_supplier_select"),
                strUser = name_supplier.options[name_supplier.selectedIndex].text;*/
            var strUser = $("#sys_supplier_name").val();

        }else{
            strUser = supplier_name;
        }
        //$('#sys_button').hide();
        //gán lại mảng product cho box đang đc sửa
        $('#myModalLabel').html('');
        $('#myModalLabel').html('Sửa nhà cung cấp - '+strUser);
        var html = this.buildBoxProduct(key,type);//tao type = 0 kho phai chon lai sp
        $("#sys_modal_body").html('');
        $("#sys_modal_body").html(html);
        $('#myModal').modal('show');
        $("#sys_display_box").html('');
    },

    //tạo thêm box mới
    buildNewBox :function(){
        //hiển thị lại text nhập tiêu đề
        $('#sys_campaign_title').val('');//f5 lại ô nhập
        $("#sys_title_label").show();
        $("#sys_product").show();
        $("#sys_button").hide();
        //ẩn ds box + hiện nút hủy thao tác thêm
        $("#sys_display_box_title").hide();
        $("#sys_button_cancel").show();
    },

    cancelAdd:function(){
        //hien ds box + hiện nút thêm
        $('#sys_campaign_title').val('');//f5 lại ô nhập
        $("#sys_display_box_title").show();
        $("#sys_button").show();
        $("#sys_button_cancel").hide();
        $("#sys_title_label").hide();
        $("#sys_product").hide();
        $("#sys_button_add_product").hide();//ẩn nút chọn sản phẩm
    },

    deleteProductAll :function(id){
        for(var i = 0, len = arrProductChecked.length; i < len; i++){
            if(arrProductChecked[i]==id){
                arrProductChecked.splice(i,1);
                //delete arrProductChecked[i];
                break;
            }
        }
    },

    //xóa phần tử trong mảng
    deleteIndexBox :function(id,arr){
        for(var i in arr){
            if($.trim(i) == $.trim(id)){
                //arr.splice(i,1);
                delete arr[i];
            }
        }
    },

    displayValError: function(id, mess){
        this.disableValError(id);
        $('#'+id).css({'background-color':'#ffc1c1'});
        $('#'+id).parent().append('<span id="show-error" style="color:#888;font-size:11px">' + mess + '</span>');
        $('#sys_update').attr('disabled', false);
        var top = $('#'+id).offset().top;
        $("html, body").animate({ scrollTop: top-80 }, 500);
    },

    disableValError: function(id){
        $('input, select').css({'background-color':''});
        $('#show-error').remove();
    },

    checkValidate:function(route){
        /*if(route == 1)
            $('#sys_update').attr('disabled', true);
        else
            $('#sys_next').attr('disabled', true);*/
        $('#sys_mess').html('');
        var percent = $('#sys_campaign_percent').val(),//mức giảm
            campaign_price = $('#sys_campaign_price_hidden').val(),//giá giảm
            title = $('#campaign_name').val(),//tiêu đề campaign
            supplier = $('#sys_supplier_select').val(),//nha cung cap
            positive = 1,//check số âm
            promotion_deal = $('#sys_hidden_campaign').val(),
            sys_id_campaign= $('#sys_id_campaign').val(),
            campaign_start_time= $('#campaign_start_time').val(),
            campaign_end_time= $('#campaign_end_time').val(),
            product_default= $('#sys_product_is_default').val(),
            campaign_expired_coupon= $('#campaign_expired_coupon').val(),
            campaign_category= $('#category_id').val(),
            object = [],//doi tuong ap dung
            mess= '',
            done = 0;

        //luu dl checked vao mang
        $("input:checkbox[name=sys_campaign_location]:checked").each(function() {
            object.push($(this).val());
        });
        /*
        if(promotion_deal == 2){
            if(this.checkNumber(campaign_price,positive) == 1){
                this.displayValError('sys_campaign_price', 'Giá trị giá giảm nhập vào không phải là số');
                return false;
            }else if(this.checkNumber(campaign_price,positive) == 0){
                this.displayValError('sys_campaign_price', 'Giá trị giá giảm nhập vào không được nhỏ hơn 0');
                return false;
            }
            if(!this.checkEmpty(campaign_price)){
                this.displayValError('sys_campaign_price', 'Giá giảm không được để trống');
                return false;
            }
        }
*/

        if(campaign_category == 0){
            this.displayValError('category_id', 'Hãy chọn 1 danh mục cho campaign');
            return false;
        }else{
            if(this.inArray(campaign_category,cateParent)){
                alert('Không chọn danh mục cha,hãy chọn danh mục con');
            }
        }

        //check tiêu đề
        if(!this.checkEmpty(title)){
            this.displayValError('campaign_name', 'Không để trống tiêu đề deal');
            return false;
        }

        var value_upload = $('#campaign_images').val();
        if(value_upload == '' && $('#sys_is_update').val() == 1 )
        {
            alert('Bạn chưa chọn ảnh để upload');
            return false;
        }

        if($.isEmptyObject(object)){
            alert('Hãy chọn 1 đối tượng áp dụng deal');
            return false;
        }
        if(isNaN(campaign_expired_coupon)){
            this.displayValError('campaign_expired_coupon', 'Thời gian giữ hàng phải là số');
            return false;
        } else if(campaign_expired_coupon <= 0) {
            this.displayValError('campaign_expired_coupon', 'Thời gian giữ hàng không được nhỏ hơn 0');
            return false;
        }

        //check thời gian
        if(!this.checkEmpty(campaign_start_time)){
            this.displayValError('campaign_start_time', 'Không để trống thời gian bắt đầu');
            return false;
        }

        //check thời gian
        if(!this.checkEmpty(campaign_end_time)){
            this.displayValError('campaign_end_time', 'Không để trống thời gian kết thúc');
            return false;
        }

        //check sp tạo
        if($.isEmptyObject(BOX) && sys_id_campaign == '' && $.isEmptyObject(arrProductChecked)){
            this.displayValError('sys_id_campaign', 'Phải chọn sản phẩm mới qua được bước tiếp theo');
            return false;
        }

        //check hệ số nhập vào
        /*
        if(this.checkNumber(percent,positive) == 1){
            this.displayValError('sys_campaign_percent', 'Giá trị mức giảm nhập vào không phải là số');
            return false;
        }else if(this.checkNumber(percent,positive) == 0){
            this.displayValError('sys_campaign_percent', 'Giá trị mức giảm nhập vào không được nhỏ hơn 0');
            return false;
        }
        if(!this.checkEmpty(percent)){
            this.displayValError('sys_campaign_percent', 'Mức giảm không được để trống');
            return false;
        }
        */


        /*if(!this.checkEmpty(product_default)){
            this.displayValError('sys_product_is_default', 'Hãy chọn 1 sản phẩm làm đại diện cho campaign');
            return false;
        }*/

        if(mess !=''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            if(route == 1)
                $('#sys_update').attr('disabled', false);
//            else
//                $('#sys_next').attr('disabled', false);
            return false;
        }else{
            $('#sys_mess_form').hide();
        }
        var checkDataBox = $.trim($('#sys_data_box').val());
        if(checkDataBox == ''){
            var dataBox = JSON.stringify(BOX);
            $('#sys_data_box').val(dataBox);
        }
        var save = this.setValueCheckBox();
        if(save == 1){
            done = this.checkUpdate(route);
            if(done == 1){
                document.getElementById("campaign_promotion").submit();
            }
        }
    },

    setValueCheckBox:function(){
        var object = [],
            save = 0;

        $("input:checkbox[name=sys_campaign_location]:checked").each(function() {
            object.push($(this).val());
        });

        //luu dl object dang chuoi
        var strObject = object.join(',');
        $('#sys_data_object').val(strObject);
        save = 1;
        return save;
    },

    //dieu huong action
    checkUpdate:function(route){
        if(route == 1)
            $('#check_update').val(1);
        return 1;
    },

    //value :gt can kiem tra;positive: kiem tra no la so duong hay am(1:kiem tra,0:ko kiem tra)
    checkNumber:function(value,positive){
        if(!isNaN(value)){
            if(positive === 1){
                if(value <= 0){
                    return 0;
                }
            }
        }else{
            return 1;
        }
        return 2;
    },

    checkEmpty:function(value){
        if($.trim(value) === ''){
            return false
        }
        return true;
    },

    //check validate so luong nhap vao
    validateQuanlity:function(store_id,product_id){
        var quanlity = $('#sys_store_quanlity_'+store_id+'_'+product_id).val();
        //check hệ số nhập vào
        if(this.checkNumber(quanlity,1) == 1){
            alert("Giá trị mức giảm nhập vào không phải là số");
            $('#sys_store_quanlity_'+store_id+'_'+product_id).val(0);
        }else if(this.checkNumber(quanlity,1) == 0){
            alert("Giá trị mức giảm nhập vào không được nhỏ hơn 0");
            $('#sys_store_quanlity_'+store_id+'_'+product_id).val(0);
        }
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

    fomatNumber:function(id) {
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        if (re > 1000000000) {
            re = 1000000000;
        }
        jQuery('#' + id +'_hidden').val(re);
        number.numberFormatNew(re, id);
    },

    convertStringInt:function(id){
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        return re;
    }
}