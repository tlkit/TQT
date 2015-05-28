$(document).ready(function(){
//lấy ngày hiện tại cho lịch
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#supplier_delivery_delivered_fee_start').datepicker({
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
        $('#supplier_delivery_delivered_fee_end')[0].focus();
    }).data('datepicker');
    var checkout = $('#supplier_delivery_delivered_fee_end').datepicker({
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function (ev) {
        checkout.hide();
    }).data('datepicker');
});
var BOX = [];
var linkAdmin = '';
var AreaCorpImage = true;
var supplier = {

    config: {
        checkUpload : true},
    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------ START CREATE INFO------------------------------------------------------------
    doneCreateInfo:function(){
        $('#submit_info').attr('disabled', true);
        var name = $('#textName').val(),
            email = $('#textEmail').val(),
            phone = $('#textPhone').val();
        var mess = this.validateCreateInfo(name,email,phone);
        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_info').attr('disabled', false);
        }else{
            //alert('donecreateinfo');
            document.getElementById("create_edit").submit();
        }
    },

    validateCreateInfo:function(name,email,phone){
        var mess = '';
        if(!this.checkEmpty(name)){
            mess +='Tên không được bỏ trống</br>';
        }

        if(!this.checkEmpty(email)){
            mess +='Email không bỏ trống</br>';
        }

        if(!this.is_email(email)){
            mess +='Email nhập không hợp lệ</br>';
        }

        if(!this.checkEmpty(phone)){
            mess +='SDT không được bỏ trống</br>';
        }

//        if(this.checkNumber(phone,1) != 2){
//            mess +='SDT nhập không hợp lệ</br>';
//        }
        return mess;
    },

    is_email:function(str){return (/^[a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(this.util_trim(str))},

    util_trim:function(str) {return (/string/).test(typeof str) ? str.replace(/^\s+|\s+$/g, "") : ""},

    updateCoords: function(c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    },

    checkCoords: function() {
        /*console.log("rèasfs");
        return false;*/
        var point_x = parseInt($('#x').val());
        var point_y = parseInt($('#y').val());
        var point_w = parseInt($('#w').val());
        var point_h = parseInt($('#h').val());
        var supplier_id = parseInt($('#supplier_id_image_crop').val());
        if (parseInt($('#w').val())){
            if (confirm('Bạn có muốn cắt ảnh avatar này?')) {
                $('#w').val(0);
                $('#img_loading_crop_image').show();
                $('#button_crop_image').hide();
                var urlAjaxCrop = document.getElementById('sys_urlAjaxCropAvatarSupplier').value;
                var src_image = document.getElementById('src_image').value;
                var name_image = document.getElementById('image').value;
                $.ajax({
                    type: "POST",
                    url: urlAjaxCrop,
                    data: {point_x : point_x,point_y : point_y,point_w : point_w,point_h : point_h,src_image:src_image,supplier_id:supplier_id,name_image:name_image},
                    responseType: 'json',
                    success: function(data) {
                        $('#img_loading_crop_image').hide();
                        $('#button_crop_image').show();
                        if(data.intReturn === 1){
                            $("#avatarImagerShow").attr("src", data.src_avatar);
                        }else {
                            $("#avatarImagerShow").attr("src", data.src_avatar);
                            $("#imageCrop").val( data.info.name_avatar);
                        }
                        $("#sys_wrap_avatar_shop").fadeIn();
                        var getCurrentImg = $("#button_crop_image").attr("data-current-img");
                        $("#sys_wrap_crop_area").html('<img id="cropbox" class="cropImage" style="max-width: 100%" src="' + getCurrentImg + '" />');
                    }
                });
            }
        }else{
            alert('Bạn hãy chọn vùng ảnh để cắt làm ảnh đại diện.');
            $('#cropbox').Jcrop({
                aspectRatio: 1,
                onSelect: supplier.updateCoords
            });
            return false;
        }
    },



    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------END CREATE INFO------------------------------------------------------------


    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START STEP BUY js sys form 1------------------------------------------------------------
    saveBox:function(key){
        var name = $('#sys_name_'+key).val(),
            address = $('#sys_address_'+key).val(),
            user_contact = $('#sys_user_contact_'+key).val(),
            phone = $('#sys_phone_'+key).val(),
            status = $('#sys_status_'+key).val(),
            id = $('#store_supplier_id_'+key).val(),
            object = [];
        $("input:checkbox[name=sys_objects_"+key+"]:checked").each(function() {
            object.push($(this).val());
        });
        //kiem tra loi tren box nhap
       var mess = this.validate(name,address,user_contact,phone,object);
        if(mess !=''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
        }else{
            key = parseInt(key);
            this.buildBox(key,id,name,address,user_contact,phone,status,object);//luu dl tren client
            this.hiddenBox(key);//hidden cac input
            $('#sys_add_box').show();//hien thi nut them
            $('#sys_edit_box_'+key).show();//hien nut sua
            $('#sys_del_box_'+key).show();//hien nut xoa
            $('#sys_done_box_'+key).hide();//an nut hoan thanh
            $('#sys_mess_form').hide();
        }
    },

    editBox:function(key){
        this.showBox(key);//show cac input
        $('#sys_add_box').hide();//an nut them
        $('#sys_edit_box_'+key).hide();//an nut sua
        $('#sys_del_box_'+key).hide();//an nut xoa
        $('#sys_done_box_'+key).show();//hien nut hoan thanh
    },

    delBox:function(key){
      $('#sys_panel_'+key).html('');
        //xoa theo key
        delete BOX[key];
        var dataBox = JSON.stringify(BOX);
        $('#sys_data_box').val(dataBox);
    },

    addBox:function(){
        var key = BOX.length;
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: 'buildBox',
            data: {
                key : key
            },
            success: function(res) {
                if(res.status){
                    jQuery("#sys_form_box").append(res.temp);//tao them box
                    $('#sys_add_box').hide();//an nut them
                }
            }
        });
    },

    //luu dl tren client
    buildBox:function(key,id,name,address,user_contact,phone,status,object){
        var strObject = object.join(',');
        if(id > 0){
            var box = {
                store_supplier_id : id,
                store_supplier_name : name,
                store_supplier_contact_name: user_contact,
                store_supplier_contact_phone : phone,
                store_supplier_status : status,
                store_supplier_address : address,
                store_supplier_place : strObject
            };
        }else{
            var box = {
                store_supplier_name : name,
                store_supplier_contact_name: user_contact,
                store_supplier_contact_phone : phone,
                store_supplier_status : status,
                store_supplier_address : address,
                store_supplier_place : strObject
            };
        }
        BOX[key] = box;
        //luu dl box dang json
        var dataBox = JSON.stringify(BOX);
        $('#sys_data_box').val(dataBox);
    },

    //hidden cac input
    hiddenBox:function(key){
        $('#sys_name_'+key).attr('readonly', true);
        $('#sys_address_'+key).attr('readonly', true);
        $('#sys_user_contact_'+key).attr('readonly', true);
        $('#sys_phone_'+key).attr('readonly', true);
        //doi tuong ap dung
        $('#sys_objects_type1_'+key).attr('disabled', true);
        $('#sys_objects_type2_'+key).attr('disabled', true);
        $('#sys_objects_type3_'+key).attr('disabled', true);
        $('#sys_objects_type4_'+key).attr('disabled', true);
        $('#sys_status_'+key).attr('disabled', true);
    },

    //show lai cac input
    showBox:function(key){
        $('#sys_name_'+key).attr('readonly', false);
        $('#sys_address_'+key).attr('readonly', false);
        $('#sys_user_contact_'+key).attr('readonly', false);
        $('#sys_phone_'+key).attr('readonly', false);
        //doi tuong ap dung
        $('#sys_objects_type1_'+key).attr('disabled', false);
        $('#sys_objects_type2_'+key).attr('disabled', false);
        $('#sys_objects_type3_'+key).attr('disabled', false);
        $('#sys_objects_type4_'+key).attr('disabled', false);
        $('#sys_status_'+key).attr('disabled', false);
    },

    validate:function(name,address,user_contact,phone,object){
        var mess= '';
        if(!this.checkEmpty(name)){
            mess +='Tên cửa hàng không được bỏ trống</br>';
        }

        if(!this.checkEmpty(address)){
            mess +='Địa chỉ không được bỏ trống</br>';
        }

        /*if(!this.checkEmpty(user_contact)){
            mess +='Người liên hệ không được bỏ trống</br>';
        }*/

        if(!this.checkEmpty(phone)){
            mess +='SDT không được bỏ trống</br>';
        }

        /*if(this.checkNumber(phone,1) != 2){
            mess +='SDT nhập không hợp lệ</br>';
        }*/

        if($.isEmptyObject(object)){
            mess +='Hãy chọn 1 đối tượng áp dụng</br>';
        }
        return mess;
    },

    //check rong
    checkEmpty:function(value){
        if($.trim(value) === ''){
            return false
        }
        return true;
    },

    //check phone
    is_phone:function(num) {
        //return (/^(0120|0121|0122|0123|0124|0125|0126|0127|0128|0129|0163|0164|0165|0166|0167|0168|0169|0188|0199|090|091|092|093|094|095|096|097|098|099)(\d{7})$/i).test(num);
        return (/^(01([0-9]{2})|09[0-9])(\d{7})$/i).test(num);
    },

    //check phone
    is_phone_2:function(num) {
        //return (/^(0120|0121|0122|0123|0124|0125|0126|0127|0128|0129|0163|0164|0165|0166|0167|0168|0169|0188|0199|090|091|092|093|094|095|096|097|098|099)(\d{7})$/i).test(num);
        return (/^([0-9])(\d{11})$/i).test(num);
    },

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------end js sys form 1------------------------------------------------------------


    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------js sys form 2------------------------------------------------------------
    next:function(){
        $('#submit_buy').attr('disabled', true);
        //kiem tra loi tren form
        var mess = this.validateForm();
        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_buy').attr('disabled', false);
        }else{
            //alert('done');
            var done = 0 ;
                done = this.setValueCheckBox();
            if(done == 1)
                document.getElementById("setting_buy").submit();
        }
    },

    showChecked:function(){
        if($("#sys_check_setting_2").is(':checked')){
            $('#sys_objects2_type1').attr('disabled', false);
            $('#sys_objects2_type2').attr('disabled', false);
            $('#sys_objects2_type3').attr('disabled', false);
            $('#sys_objects2_type4').attr('disabled', false);
            $('#sys_price').attr('disabled', false);
            $('#supplier_purchase_delivery_type').attr('disabled', false);
        }else{
            //an doi tuong ap dung va remove checked
            $('#sys_objects2_type1').attr('disabled', true);
            $('#sys_objects2_type2').attr('disabled', true);
            $('#sys_objects2_type3').attr('disabled', true);
            $('#sys_objects2_type4').attr('disabled', true);

            $('#sys_objects2_type1').attr('checked', false);
            $('#sys_objects2_type2').attr('checked', false);
            $('#sys_objects2_type3').attr('checked', false);
            $('#sys_objects2_type4').attr('checked', false);

            $('#sys_price').attr('disabled', true);
            $('#supplier_purchase_delivery_type').attr('disabled', true);
        }
    },

    setValueCheckBox:function(){
        var object = [],
            buy_type_1 = 1,
            buy_type_2 = 0,
            buy_type_3 = 0,
            done = 0;

        if($("#sys_check_setting_2").is(':checked')){
            $("input:checkbox[name=sys_objects2]:checked").each(function() {
                object.push($(this).val());
            });

            //luu dl object dang chuoi
            var strObject = object.join(',');
            $('#sys_data_object').val(strObject);
            buy_type_2 = 1;
        }
        buy_type_3 = document.getElementById("supplier_payment_method_cod_type").value;
        //luu dl type vao hidden
        $('#sys_data_type1').val(buy_type_1);
        $('#sys_data_type2').val(buy_type_2);
        $('#sys_data_type3').val(buy_type_3);

        var dataBox = JSON.stringify(BOX);
        $('#sys_data_box').val(dataBox);
        done = 1;
        return done;
    },

    validateForm:function(){
        var object = [],
            mess = '';;
        $("input:checkbox[name=sys_objects2]:checked").each(function() {
            object.push($(this).val());
        });
        // khong de trong hinh thuc 1
        if(!$("#sys_check_setting_1").is(':checked'))
            mess += 'Bắt buộc phải chọn hình thức này';

        if($("#sys_check_setting_2").is(':checked')){
            if($.isEmptyObject(object)){
                mess +='Hãy chọn 1 đối tượng áp dụng cho hình thức giao hàng tận nơi</br>';
            }
        }

        if($.isEmptyObject(BOX)){
            mess +='Bạn buộc phải có cửa hàng</br>';
        }
        return mess;

    },

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------DONE STEP BUY------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START STEP PAYMENT-------------------------------------------------------

    donePayment:function(){
        $('#submit_payment').attr('disabled', true);
        //kiem tra loi tren form
        var mess = this.validateFormPayment();
        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_payment').attr('disabled', false);
        }else{
           // alert('donepayment');
            var done = 0 ;
            done = this.setValueCheckBoxPayment();
            if(done == 1)
                document.getElementById("setting_payment").submit();
        }
    },

    showCheckedPayment:function(){
        if($("#sys_check_setting_payment_2").is(':checked')){
            $('#sys_objects_type_payment1').attr('disabled', false);
            $('#sys_objects_type_payment2').attr('disabled', false);
            $('#sys_objects_type_payment3').attr('disabled', false);
            $('#sys_objects_type_payment4').attr('disabled', false);
            $('#supplier_payment_method_cod_type').attr('disabled', false);
        }else{
            //an doi tuong ap dung va remove checked
            $('#sys_objects_type_payment1').attr('disabled', true);
            $('#sys_objects_type_payment2').attr('disabled', true);
            $('#sys_objects_type_payment3').attr('disabled', true);
            $('#sys_objects_type_payment4').attr('disabled', true);
            $('#supplier_payment_method_cod_type').attr('disabled', true);

            $('#sys_objects_type_payment1').attr('checked', false);
            $('#sys_objects_type_payment2').attr('checked', false);
            $('#sys_objects_type_payment3').attr('checked', false);
            $('#sys_objects_type_payment4').attr('checked', false);
            $('#supplier_payment_method_cod_type').attr('checked', false);
        }
    },

    setValueCheckBoxPayment:function(){
        var object = [],
            payment_type_1 = 0,
            payment_type_2 = 0,
            payment_type_3 = 0,
            payment_type_4 = 0,
            done = 0;

        if($("#sys_check_setting_payment_1").is(':checked')){payment_type_1 =1}

        if($("#sys_check_setting_payment_3").is(':checked')){payment_type_3 =1}

        if($("#sys_check_setting_payment_4").is(':checked')){payment_type_4 =1}

        if($("#sys_check_setting_payment_2").is(':checked')){
            $("input:checkbox[name=sys_objects_payment]:checked").each(function() {
                object.push($(this).val());
            });

            //luu dl object dang chuoi
            var strObject = object.join(',');
            $('#sys_data_object').val(strObject);
            payment_type_2 =1
        }

        //luu dl type vao hidden
        $('#sys_data_type1').val(payment_type_1);
        $('#sys_data_type2').val(payment_type_2);
        $('#sys_data_type3').val(payment_type_3);
        $('#sys_data_type4').val(payment_type_4);
        done = 1;
        return done;
    },

    validateFormPayment:function(){
        var payment_type = [],
            object = [],
            mess = '';
        $("input:checkbox[name=sys_objects_payment]:checked").each(function() {
            object.push($(this).val());
        });

        $("input:checkbox[name=sys_check_setting_payment]:checked").each(function() {
            payment_type.push($(this).val());
        });

        if($("#sys_check_setting_payment_2").is(':checked')){
            if($.isEmptyObject(object)){
                mess +='Hãy chọn 1 đối tượng áp dụng cho hình thức giao hàng thanh toán tận nơi</br>';
            }
        }

        if($.isEmptyObject(payment_type)){
            mess +='Bạn buộc phải thiết lập 1 trong số các hình thức thanh toán dưới đây</br>';
        }
        return mess;
    },

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------DONE STEP PAYMENT------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START STEP DELIVERY-------------------------------------------------------

    doneDelivery:function(){
        $('#submit_delivery').attr('disabled', true);
        //kiem tra loi tren form
        var mess = this.validateFormDelivery();
        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_delivery').attr('disabled', false);
        }else{
            //alert('donedeliveryt');
            var done = 0 ;
            done = this.setValueCheckBoxDelivery();
            if(done == 1)
                document.getElementById("setting_delivery").submit();
        }
    },

    showCheckedDelivery:function(){
        if($("#sys_check_setting_delivery2").is(':checked')){
            $('#sys_objects_type_delivery1').attr('disabled', false);
            $('#sys_objects_type_delivery2').attr('disabled', false);
            $('#sys_objects_type_delivery3').attr('disabled', false);
            $('#sys_objects_type_delivery4').attr('disabled', false);

            $('#sys_free_type1').attr('disabled', false);
            $('#sys_free_type2').attr('disabled', false);
            $('#sys_free_type3').attr('disabled', false);
            $('#sys_free_type4').attr('disabled', false);

            $('#sys_price').attr('readonly', false);
        }else{
            //an doi tuong ap dung va remove checked
            $('#sys_objects_type_delivery1').attr('disabled', true);
            $('#sys_objects_type_delivery2').attr('disabled', true);
            $('#sys_objects_type_delivery3').attr('disabled', true);
            $('#sys_objects_type_delivery4').attr('disabled', true);

            $('#sys_objects_type_delivery1').attr('checked', false);
            $('#sys_objects_type_delivery2').attr('checked', false);
            $('#sys_objects_type_delivery3').attr('checked', false);
            $('#sys_objects_type_delivery4').attr('checked', false);

            //an doi tuong ap dung fee ship va remove checked
            $('#sys_free_type1').attr('disabled', true);
            $('#sys_free_type2').attr('disabled', true);
            $('#sys_free_type3').attr('disabled', true);
            $('#sys_free_type4').attr('disabled', true);

            $('#sys_free_type1').attr('checked', false);
            $('#sys_free_type2').attr('checked', false);
            $('#sys_free_type3').attr('checked', false);
            $('#sys_free_type4').attr('checked', false);

            $('#sys_price').attr('readonly', true);
            $('#sys_price').val('');

            $('#supplier_delivery_delivered_fee_start').val('');
            $('#supplier_delivery_delivered_fee_end').val('');
        }
    },

    setValueCheckBoxDelivery:function(){
        var object1 = [],
            object2 = [],
            delivery_type1= 0,
            delivery_type2= 0,
            done = 0;

        if($("#sys_check_setting_delivery1").is(':checked')){delivery_type1 =1}


        if($("#sys_check_setting_delivery2").is(':checked')){
            $("input:checkbox[name=sys_objects_delivery]:checked").each(function() {
                object1.push($(this).val());
            });

            //luu dl object dang chuoi
            var strObject1 = object1.join(',');
            $('#sys_data_object1').val(strObject1);

            $("input:checkbox[name=sys_free]:checked").each(function() {
                object2.push($(this).val());
            });

            //luu dl object dang chuoi
            var strObject2 = object2.join(',');
            $('#sys_data_object2').val(strObject2);

            delivery_type2 = 1;
        }

        $('#sys_data_type1').val(delivery_type1);
        $('#sys_data_type2').val(delivery_type2);
        done = 1;
        return done;
    },

    validateFormDelivery:function(){
        var delivery_type = [],
            object1 = [],
            object2 = [],
            value_order = $('#sys_price').val(),
            fee_start = $('#supplier_delivery_delivered_fee_start').val(),
            fee_end = $('#supplier_delivery_delivered_fee_end').val(),
            mess = '';
        $("input:checkbox[name=sys_objects_delivery]:checked").each(function() {
            object1.push($(this).val());
        });

        $("input:checkbox[name=sys_free]:checked").each(function() {
            object2.push($(this).val());
        });

        $("input:checkbox[name=sys_check_setting_delivery]:checked").each(function() {
            delivery_type.push($(this).val());
        });

        //neu chon hinh thuc 2
        if($("#sys_check_setting_delivery2").is(':checked')){
            if($.isEmptyObject(object1)){
                mess +='Hãy chọn 1 đối tượng áp dụng cho hình thức nhận hàng thanh toán tận nơi</br>';
            }

            if($.isEmptyObject(object2)){
                mess +='Hãy chọn 1 đối tượng miễn phí vận chuyển cho hình thức nhận hàng thanh toán tận nơi</br>';
            }

            //check gia
            var positive = 1;
            if(this.checkNumber(value_order,positive) == 1){
                mess += "Giá trị đơn hàng nhập vào không phải là số </br>";
            }else if(this.checkNumber(value_order,positive) == 0){
                mess += "Giá trị mức giảm nhập vào không được nhỏ hơn 0</br>";
            }

//            if(!this.checkEmpty(value_order)){
//                mess += "Không để trống giá trị đơn hàng nhập vào </br>";
//            }

//            if(!this.checkEmpty(fee_start)){
//                mess += "Không để trống trường thời gian áp dụng 'TỪ NGÀY'</br>";
//            }
//
//            if(!this.checkEmpty(fee_end)){
//                mess += "Không để trống trường thời gian áp dụng 'ĐẾN NGÀY'</br>";
//            }
        }


        if($.isEmptyObject(delivery_type)){
            mess +='Bạn buộc phải thiết lập 1 trong số các hình thức nhận hàng dưới đây</br>';
        }
        return mess;
    },

    //value :gt can kiem tra;positive: kiem tra no la so duong hay am(1:kiem tra,0:ko kiem tra)
    checkNumber:function(value,positive){
        if(!isNaN(value)){
            if(positive === 1){
                if(value < 0){
                    return 0;
                }
            }
        }else{
            return 1;
        }
        return 2;
    },

//-------------------------------------------------------------------------------------------------------------
    //------------------------------------DONE STEP DELIVERY------------------------------------------------------------


    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START STEP RETURN-------------------------------------------------------
    doneReturn:function(){
        $('#submit_return').attr('disabled', true);
        var textReturn = $('#sys_text_return').val(),
            selected = $("input[type='radio'][name='sys_return']:checked"),
            selectedVal = 0;

        if (selected.length > 0) {
            selectedVal = selected.val();
        }
        var mess = this.validateReturn(selectedVal,textReturn);

        if(mess != ''){
            $('#sys_mess').html(mess);
            $('#sys_mess_form').show();
            $("html, body").animate({ scrollTop: 0 }, 500);
            $('#submit_return').attr('disabled', false);
        }else{
            document.getElementById("setting_return").submit();
        }
    },

    validateReturn:function(selected,textReturn){
        var mess = '';
        if(selected == 1){
            if($.trim(textReturn) == ''){
                mess+= 'Hãy nhập nội dung cho chính sách hoàn trả của bạn';
            }
        }
        return mess;
    },

    checkRadio:function(type){
       if(type == 0){
           //an text area reset area
           $('#sys_text_return').attr('disabled', true);
           $('#sys_text_return').val('');
       }else{
           //hien lai area
           $('#sys_text_return').attr('disabled', false);
       }
    },

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------END STEP RETURN-------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------------
    //------------------------------------START INDEX-------------------------------------------------------
    updateStatusSupplier: function(id,status){
        if(id > 0){
            $('#sys_status_'+id).attr('disabled', true);
            $('#img_loading_status_'+id).show();
            var urlAjaxUpdateStatusSupplier = document.getElementById('sys_urlAjaxUpdateStatusSupplier').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatusSupplier,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_supplier_'+id).html('');
                        $('#sys_status_supplier_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                    $('#img_loading_status_'+id).hide();
                }
            });
        }
    },

    deleteSupplier:function(id){
        if(confirm("Bạn có chắc muốn xóa shop này? \n - Nhấn ok nếu vẫn muốn xóa. \n - Cancel để trở lại.")){
            if(id > 0){
                var urlAjaxDeleteSupplier = document.getElementById('sys_urlAjaxDeleteSupplier').value;
                $.ajax({
                    type: "POST",
                    url: urlAjaxDeleteSupplier,
                    data: {id : id},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $("#row_"+id).remove();
                        }else if(data.intReturn == 2){
                            alert('Bạn không có quyền thực hiện thao tác này');
                        }else if(data.intReturn == 3){
                            window.location = linkAdmin+'login/logout';
                        }
                    }
                });
            }
        }
    },

//-------------------------------------------------------------------------------------------------------------
    //------------------------------------END INDEX-------------------------------------------------------
    uploadImagesAvatarSupplier: function(supplier_id) {
        $('#sys_PopupUploadImgSupplier').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var urlAjaxUpload = document.getElementById('sys_urlAjaxImageAvatarSupplier').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            data: {supplier_id : supplier_id},
            multiple: true,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    $("#sys_wrap_crop_area").show();
                    $("#cropbox").attr("src", xhr.info.src);
                    $("#image").val( xhr.info.name_avatar);
                    $("#src_image").val(xhr.info.src);
                    $("#button_crop_image").attr("data-current-img", xhr.info.src).fadeIn();
                    $('#sys_PopupUploadImgSupplier').modal('hide');
                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",3000 );
                setTimeout( "jQuery('#status').hide();",3000 );
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader_supplier").uploadFile(settings);
    },

    // popup hiển thị list ảnh khác sản phẩm để chèn
    // vào mô tả ngắn của nhà cung cấp
    popupInsertImagesToDescSupplier: function() {
        $('#sys_PopupInsertImageToDesc').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOtherInsertToDesc').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            multiple: true,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    var clickInsert = "<a href='javascript:;'  onclick='supplier.insertImageEditorByIdImage("+ xhr.info.id_key +")'>";
                    var html ="<div style='margin: 5px; 10px; width:100px;float: left'>";
                    html +=clickInsert;
                    html += "<img id='sys_img_other_insert_'" +xhr.info.id_key+ "' class='imgeProductOther' src='" + xhr.info.src + "' alt='alt_imag_insert_" +xhr.info.id_key+ "'/>";
                    html +="</a>";
                    html +="</div>";
                    $('#sys_upload_image').append(html);
                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                setTimeout( "jQuery('#status').hide();",5000 );
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader_insertDesc").uploadFile(settings);
    },
    insertImageEditorByIdImage: function(id){
        var src = $('img[alt="alt_imag_insert_'+id+'"]').attr('src');
        CKEDITOR.instances.textDescrip.insertHtml('<img src="'+src+'"/>');
    },
}
