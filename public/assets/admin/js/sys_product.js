var sys_product = {
    /*******************************************************************************************************************
     * Set Top San pham
     *******************************************************************************************************************/
    getInforShopSetTopProduct: function(product_id,product_sale_id,supplier_id,is_shop) {
        $('#sys_PopupUpScore').modal('show');
        $('#sys_popup_infor_campagin').html('');
        $('#button_update').html('');
        $('#sys_block_popup_infor').hide();
        $('#img_loading').show();
        var urlAjaxGetInfor = document.getElementById('sys_getAjaxInforShopSetTop').value;
        $.ajax({
            type: "get",
            url: urlAjaxGetInfor,
            data: {supplier_id : supplier_id},
            dataType: 'json',
            success: function(res) {
                if(res.intReturn === 1){
                    $('#img_loading').hide();

                    var data = res.info;
                    if(data.moneyShop >0){
                        $('#msg_thongbao_settop').show();
                        //dùng cho Admin settop
                        if(is_shop == 0){
                            var button_submit = "<button class='btn btn-primary' onclick='sys_product.submitSetTopProductInAdmin("+product_id+","+product_sale_id+","+supplier_id+")' id='button_submit_ajax'";
                        }else{
                            //is_shop == 1// dùng cho Shop
                            var button_submit = "<button class='btn btn-primary' onclick='sys_product.submitSetTopProductInShop("+product_id+")' id='button_submit_ajax'";
                        }
                        button_submit += ">Set Top</button>";

                        button_submit += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:;' class='btn btn-warning' onclick='sys_product.exitPopupSetTop()' style='background-color:#bbb;border-color:#bbb;margin-left: 10px;'>";
                        button_submit += "&nbsp;&nbsp;Bỏ qua</a>";
                        $('#button_update').html(button_submit);
                    }else{
                        if(is_shop == 0) {
                            $('#button_update').html('Shop này đã hết lượt up, nên không set top được!!!');
                        }else{
                            var thongbao = "<b class='red'>Bạn muốn set top cho deal này? Shop của bạn đã hết lượt up!<br/> <a href='javascript:;' onclick='sys_product.exitPopupSetTop();Gold.openPopupBuyUp("+product_id+");' >";
                            thongbao += "Mua lượt up cho shop để set top</a></b>";
                            $('#button_update').html(thongbao);
                        }
                    }
                    $('#sys_show_infor_update_score').show();
                    $('#sys_block_popup_infor').show();
                }else{
                    $('#sys_popup_infor_campagin').html('Không tìm thấy dữ liệu để up điểm');
                }
            }
        });
    },

    exitPopupSetTop:function(){
        $('#sys_PopupUpScore').modal('hide');
    },

    submitSetTopProductInShop: function(product_id){
        if(product_id > 0){
            $('#button_submit_ajax').hide();
            $('#img_loading').show();
            var urlAjaxUpdateScore = document.getElementById('sys_getAjaxSetTopProduct').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateScore,
                data: {product_sale_id : product_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn == 1){
                        alert('Đã Set Top thành công');
                        $('#sys_PopupUpScore').modal('hide');
                        window.location.reload();
                    }else{
                        alert(res.msg);
                    }
                }
            });
        }
    },

    submitSetTopProductInAdmin: function(product_id,product_sale_id,supplier_id){
        if(product_id > 0 && product_sale_id > 0 && supplier_id > 0){
            $('#button_submit_ajax').hide();
            $('#img_loading').show();
            var urlAjaxUpdateScore = document.getElementById('sys_getAjaxSetTopProduct').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateScore,
                data: {product_id : product_id,product_sale_id : product_sale_id,supplier_id : supplier_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn == 1){
                        alert('Đã Set Top thành công');
                        $('#sys_PopupUpScore').modal('hide');
                        window.location.reload();
                    }else{
                        alert(res.msg);
                    }
                }
            });
        }
    },

    /*******************************************************************************************************************
     * Quản lý đăng tin
     * set up thời gian dăng tin
     *******************************************************************************************************************/
    popupSetupTimeRunProduct: function(product_id) {
        $('#sys_PopupSetTimeUpDeal').modal('show');
        $('#sys_infor_popup').hide();
        $('#sys_msg_return').hide();
        sys_product.resetInputPopup();
        sys_product.removePointer();
        if(product_id > 0 ){
            var urlAjax = document.getElementById('sys_getAjaxInforSetupTime').value ;
            $('#img_loading_ajax').show();
            $.ajax({
                type: "get",
                url: urlAjax,
                data: {product_id : product_id},
                responseType: 'json',
                success: function(data) {
                    $('#img_loading_ajax').hide();

                    if(data.intReturn === 1){
                        var infor = data.info;

                        //build data edit
                        if(infor.dataEdit.length !== 0){
                            var editItem = infor.dataEdit;
                            //so lần up trong khoang thời gian
                            $('#number_up_1').val(editItem.number_up_1);
                            $('#number_up_2').val(editItem.number_up_2);
                            $('#number_up_3').val(editItem.number_up_3);
                            $('#number_up_4').val(editItem.number_up_4);

                            //thứ ngày tháng chọn
                            $.each(editItem.calendar_up_date, function(date, val_date){
                                $('#'+date).prop( "checked", true );
                            });

                            //setup thời gian chạy
                            $.each(editItem.calendar_up_time, function(time, str_time){
                                sys_product.addTime(str_time);
                            });
                        }

                        //show thông tin
                        var nameDeal = infor.campain_name+" (Id deal:" + infor.campain_id + ")";
                        $('#sys_name_deal_up').html(nameDeal);

                        //lươt up deal cua shop
                        $('#sys_number_up_shop').html(infor.strNumberUp);
                        $('#sys_number_up_can_user_shop').val(infor.numberUpDeal);

                        $('#number_up_hold').val(infor.number_up_hold);
                        $('#sys_hidden_hold_con_lai').val(infor.number_up_hold);
                        $('#hold_con_lai').html(infor.number_up_hold);

                        //if(infor.numberUpDeal > 0){
                        var button_submit = "<a href='javascript:;' class='btn btn-primary'onclick='sys_product.submitSetUpTime()' id='submitUptime'>";
                        button_submit += "<i class='fa fa-floppy-o'></i> &nbsp;&nbsp;Lưu lại</a>";

                        button_submit += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:;' class='btn btn-warning'onclick='sys_product.exitPopup()' >";
                        button_submit += "&nbsp;&nbsp;Bỏ qua</a>";
                        $('#button_submit').html(button_submit);
                        /*}else{
                         $('#sys_msg_return').show();
                         $('#sys_msg_return').html('Tài khoản của bạn không đủ điều kiện để thiết lập lịch up');
                         }*/
                        var input_hidden = '<input type="hidden" id="campaign_id" name="campaign_id" value="'+infor.campain_id+'"/>';
                        input_hidden += '<input type="hidden" id="feed_home_id" name="feed_home_id" value="'+infor.feed_home_id+'"/>';
                        input_hidden += '<input type="hidden" id="location_id" name="location_id" value="'+infor.location_id+'"/>';
                        input_hidden += '<input type="hidden" id="numberUpDealShop" name="numberUpDealShop" value="'+infor.numberUpDeal+'"/>';
                        $('#sys_input_hidden').html(input_hidden);
                        $('#sys_infor_popup').show();

                    }else{
                        $('#sys_msg_return').show();
                        $('#sys_msg_return').html(data.msg);
                    }
                }
            });
        }
    },

    exitPopup:function(){
        $('#sys_PopupSetTimeUpDeal').modal('hide');
    },

    submitSetUpTime: function(){
        var submitSetup = true;
        $('#sys_msg_return').hide();
        var thu_2 = ($('#thu_2').is(':checked')) ? $('#thu_2').val(2): 0;
        var thu_3 = ($('#thu_3').is(':checked')) ? $('#thu_3').val(3): 0;
        var thu_4 = ($('#thu_4').is(':checked')) ? $('#thu_4').val(4): 0;
        var thu_5 = ($('#thu_5').is(':checked')) ? $('#thu_5').val(5): 0;
        var thu_6 = ($('#thu_6').is(':checked')) ? $('#thu_6').val(6): 0;
        var thu_7 = ($('#thu_7').is(':checked')) ? $('#thu_7').val(7): 0;
        var thu_8 = ($('#thu_8').is(':checked')) ? $('#thu_8').val(8): 0;

        //sys_number_up_can_user_shop
        var numberCanUser = document.getElementById('sys_number_up_can_user_shop').value ;
        var numberUp = document.getElementById('number_up_hold').value ;
        var sys_hidden_hold_con_lai = document.getElementById('sys_hidden_hold_con_lai').value ;

        if(parseInt(numberUp)==0){
            submitSetup = false;
            $('#number_up_hold').focus();
            var thong_bao = '<p>Bạn phải nhập Tổng số lượt dùng cho deal này! </p>';
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao);
        }

        if(parseInt(numberCanUser) + parseInt(sys_hidden_hold_con_lai) < parseInt(numberUp)){
            submitSetup = false;
            $('#number_up_hold').focus();
            var thong_bao = '<p>Bạn phải nhập lượt up dành cho deal này <= số lượt up có thể dùng </p>';
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao);
        }

        if(submitSetup){
            if(thu_2 == 0 && thu_3 == 0 && thu_4 == 0 && thu_5 == 0 && thu_6 == 0 && thu_7 == 0 && thu_8 == 0){
                var thong_bao_thu = 'Bạn phải chọn ngày để chạy up tự động!';
                $('#sys_msg_return').show();
                $('#sys_msg_return').html(thong_bao_thu);
            }else{
                if (confirm('Bạn có muốn lập lịch up cho deal này không?')) {
                    var urlAjax = document.getElementById('sys_getAjaxPushUpTimeProduct').value ;
                    $('#img_loading_ajax').show();
                    $.ajax({
                        type: "POST",
                        url: urlAjax,
                        data: jQuery('#form_uptime').serializeArray(),
                        responseType: 'json',
                        success: function(data) {
                            $('#button_submit').show();
                            $('#img_loading_ajax').hide();
                            if(data.intReturn === 1){
                                alert(data.msg);
                                $('#sys_PopupSetTimeUpDeal').modal('hide');
                                window.location.reload();
                            }else{
                                $('#sys_msg_return').show();
                                $('#sys_msg_return').html(data.msg);
                            }
                        }
                    });
                }
            }
        }
    },

    setUpTime: function(){
        $('#sys_msg_return').hide();
        var total_up = 0;
        var number_up_hold = parseInt(document.getElementById('number_up_hold').value);
        if(isNaN(number_up_hold)){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html('yêu cầu nhập số');
            $('#number_up_hold').focus().val(0);
            return;
        }else if(number_up_hold == 0){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html('Bạn phải nhập Tổng số lượt dùng cho deal này!');
            $('#number_up_hold').focus().val(0);
            return;
        }

        var limit_1 = parseInt(document.getElementById('number_up_1').value);
        var limit_2 = parseInt(document.getElementById('number_up_2').value);
        var limit_3 = parseInt(document.getElementById('number_up_3').value);
        var limit_4 = parseInt(document.getElementById('number_up_4').value);

        //check trong mot khoang thoi gian so lan up time
        var numberTimeAccess = 12;
        if(parseInt(limit_1) > numberTimeAccess || parseInt(limit_2) > numberTimeAccess || parseInt(limit_3) > numberTimeAccess || parseInt(limit_4) > numberTimeAccess ){
            submitSetup = false;
            var thong_bao = '<p>Trong một khoảng thời gian, số lượt up tin không vượt quá '+numberTimeAccess+' </p>';
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao);
        }
        var thong_bao_nhap_so = "Yêu cầu nhập số cho Số lần up tin";
        if(isNaN(limit_1)){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao_nhap_so);
            $('#number_up_1').focus().val(0);
            return;
        }else if(isNaN(limit_2)){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao_nhap_so);
            $('#number_up_2').focus().val(0);
            return;
        }else if(isNaN(limit_3)){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao_nhap_so);
            $('#number_up_3').focus().val(0);
            return;
        }else if(isNaN(limit_4)){
            $('#sys_msg_return').show();
            $('#sys_msg_return').html(thong_bao_nhap_so);
            $('#number_up_4').focus().val(0);
            return;
        }
        total_up = limit_1 + limit_2 +limit_3 + limit_4;
        if(total_up > 0){
            sys_product.removePointer();
            if(limit_1 > 0){
                sys_product.buildTimeRun(limit_1,0);
            }
            if(limit_2 > 0){
                sys_product.buildTimeRun(limit_2,6);
            }
            if(limit_3 > 0){
                sys_product.buildTimeRun(limit_3,12);
            }
            if(limit_4 > 0){
                sys_product.buildTimeRun(limit_4,18);
            }
        }else{
            $('#sys_msg_return').show();
            $('#sys_msg_return').html('Bạn chưa nhập số lần up tin trong các khoảng thời gian trên');
        }
    },

    buildTimeRun: function(number,timeStart) {
        var minute_defaul =(number <= 6)? 60 : 15;
        for(var i=0; i<number; i++){
            //set time auto
            var minuteRun = i*minute_defaul;// khoang cach
            var hour = timeStart+(Math.floor(minuteRun/60));
            var str_hour = (hour < 10)? '0'+hour: hour;
            var minute = minuteRun%60;
            var str_minute = (minute < 10)? '0'+minute: minute;
            var time = str_hour+':'+str_minute;
            sys_product.addTime(time);
        }
    },

    addTime: function(time){
        var imgUptime = document.getElementById('sys_imgUptime').value;//icon di chuyen time
        var pointer = K.create.element({
            style: {
                position: "absolute",
                top: "-12px",
                width: "16px",
                height: "18px",
                cursor: "pointer",
                zIndex:12,
                background: "url('"+imgUptime+"') center no-repeat"
            },
            event: {
                mouseover: function(event) {
                    var tooltip = K('tooltip').show();
                    pointer.appendChild(tooltip);
                    var result = K('result');
                    result.innerHTML = "";
                    result.appendChild(document.createTextNode(pointer.interval));

                },
                mouseout: function(event) {
                    K('tooltip').hide();
                }
            },className:'dragTimeConfig'
        });
        pointer.interval = time ? time : "00:00";
        if (time) {
            var exp = time.split(":");
            pointer.style.left =  (Math.round(38 * exp[0] + 38/60 * exp[1])) + "px";
        }

        K(pointer).initDragDrop({
            onMove: function() {
                var event = this.event;
                var element = this.self;
                var root = K('up_calendar');
                var rootX = K.get.X(root);
                var X = K.get.X(event) - rootX;
                element.style.top = "-12px";

                if (X < 0) {
                    element.style.left = "-1px";
                } else if (X > 912) {
                    element.style.left =  (912-1)  + "px";
                } else {
                    //1 hour = 38px;
                    var hour 	=  parseInt(X/38);
                    var minute 	=  Math.round((60/38) * Math.round(X - 38 * hour));

                    minute = (minute < 10) ? "0" + minute : minute;
                    var interval = 1 * hour < 10 ? "0" + hour + ":" + minute : hour + ":" + minute;

                    var timeGet = X;
                    K(element).first().value = interval;
                    var result = K('result');
                    result.innerHTML = "";
                    result.appendChild(document.createTextNode(interval));
                    element.interval = interval;
                    element.style.left = (X-1) + "px";
                }
            }
        });

        var store = K.create.element({
            tagName: "input",
            className: "interval",
            attribute: {
                type: "hidden",
                name: "timeSetting[]"
            }
        });
        pointer.appendChild(store);
        K('up_calendar').appendChild(pointer);
        pointer.first().value = pointer.interval;
    },

    removePointer: function(){
        $(".interval").val("");  ;
        $(".dragTimeConfig").hide();
    },

    resetInputPopup: function(){
        $('#number_up_hold').val(0);

        $('#number_up_1').val(0);
        $('#number_up_2').val(0);
        $('#number_up_3').val(0);
        $('#number_up_4').val(0);

        $('#thu_2').prop( "checked", false );
        $('#thu_3').prop( "checked", false );
        $('#thu_4').prop( "checked", false );
        $('#thu_5').prop( "checked", false );
        $('#thu_6').prop( "checked", false );
        $('#thu_7').prop( "checked", false );
        $('#thu_8').prop( "checked", false );

    },

    /*******************************************************************************************************************
     * View Log
     * set up thời gian dăng tin
     *******************************************************************************************************************/
    getViewLogUptimeProduct: function(product_id,product_sale_id) {
        $('#sys_PopupShowLogUptimeDeal').modal('show');
        $('#sys_table_view_log').hide();
        $('#sys_view_msg').html('');
        $('#img_loading').show();
        $('#myModalLabelLogUpdeal').html('Lịch sử đặt lịch up tin của Sản phẩm - '+product_id );
        if (product_id > 0) {
            var urlAjax = document.getElementById('sys_urlViewLogUptimeProduct').value;
            $('#img_loading_log').show();
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {product_id : product_id,product_sale_id : product_sale_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_log').hide();
                    if(res.intReturn === 1){
                        var rs = res.info;
                        var html = "";
                        for( k in rs ) {
                            html += "<tr>";
                            html += "<td>" + rs[k].stt + "</td>";
                            html += "<td>" + rs[k].user_action + "</td>";
                            html += "<td>" + rs[k].created_time + "</td>";
                            html += "<td>" + rs[k].note + "</td>";
                            html += "</tr>";
                        }
                        $('#sys_table_view_log').show();
                        $('#sys_tr_infor_log').html(html);
                    }else{
                        $('#sys_view_msg').html(res.msg);
                    }
                }
            });
        }
    },

    actionTypeProduct: function(type) {
        var list_id_product_sale = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_id_product_sale += this.value + ',';
            }
        });
        if(list_id_product_sale == ''){
            alert('Bạn chưa chọn deal để thiết lập');
        }else{
            if(confirm('Bạn có muốn thiết lập deal này?')) {
                if(type > 0) {
                    $('#img_loading_action_type_deal').show();
                    $.ajax({
                        dataType: 'json',
                        type: 'post',
                        url: WEB_ROOT + 'admin/adminProductSale/ajaxActionTypeProduct',
                        data: {
                            list_id_product_sale : list_id_product_sale, type : type
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
    },

    /**
     * Duyet san pham
     * @param id
     */
    approveProduct: function(product_id) {
        if(confirm('Bạn có muốn duyệt sản phẩm này không?')) {
            if(product_id > 0) {
                $('#img_loading_approve_product_'+product_id).show();
                $('#show_approve_product_'+product_id).hide();
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: WEB_ROOT + 'admin/adminProductSale/approveProduct',
                    data: {
                        product_id : product_id
                    },
                    beforeSend: function() {},
                    complete: function() {},
                    success: function(res) {
                        $('#img_loading_approve_product_'+product_id).hide();
                        $('#show_approve_product_'+product_id).show();
                        if(res.isIntOk == 1) {
                            alert(res.msg);
                            var huy_duyet = "<a class='btn btn-primary approve_deal' href = 'javascript:void(0);' style='padding: 1px 2px;font-size: 12px; margin-top: 4px;' onclick='sys_product.deleteApproveProduct("+product_id+")'";
                            huy_duyet += ">Bỏ duyệt</a>";
                            $('#show_approve_product_'+product_id).html(huy_duyet);
                        } else if(res.isIntOk == -1) {
                            alert(res.msg);
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

    /**
     * hủy duyet san pham -> Chờ duyệt
     * @param id
     */
    deleteApproveProduct: function(product_id) {
        $('#sys_PopupUpDeleteApproveProduct').modal('show');
        $('#myModalLabel_deleteApprove').html('Hủy duyệt mã sản phẩm ' + product_id);
        $('#note_approve').val('');
        var button_submit = "<button class='btn btn-primary' onclick='sys_product.submitDeleteApproveProduct("+product_id+")'";
        button_submit += ">Hủy duyệt deal</button>";
        $('#button_update_approve').html(button_submit);
    },
    submitDeleteApproveProduct : function(product_id){
        var note_approve = document.getElementById('note_approve').value;
        if(note_approve == ''){
            alert('Bạn chưa nhập lý do hủy duyệt');
        }else{
            $('#img_loading_approve').show();
            $.ajax({
             type: "post",
             url: WEB_ROOT + 'admin/adminProductSale/refuseApproveProduct',
             data: {product_id : product_id, note_approve:note_approve},
             dataType: 'json',
             success: function(res) {
                 $('#img_loading_approve').hide();
                 if(res.isIntOk == 1){
                     alert(res.msg);
                     var cho_duyet = "<a class='btn btn-danger approve_deal' href = 'javascript:void(0);' style='padding: 1px 2px;font-size: 12px; margin-top: 4px;' onclick='sys_product.approveProduct("+product_id+")'";
                     cho_duyet += ">Chờ duyệt</a>";
                     $('#show_approve_product_'+product_id).html(cho_duyet);

                     var xem_note = "<a class='btn btn-success approve_deal' href = 'javascript:void(0);' style='padding: 1px 2px;font-size: 12px; margin-top: 4px;' onclick='sys_product.getViewNoteProductToAdmin("+product_id+")'";
                     xem_note += ">Xem note</a>";
                     $('#show_view_note_pro_id_'+product_id).html(xem_note);

                     $('#sys_PopupUpDeleteApproveProduct').modal('hide');
                 }else{
                     alert(res.msg);
                 }
             }
             });
        }
    },

    /**
     * add thêm note cho san pham ở Admin
     * @param id
     */
    addNoteProduct: function(product_id) {
        $('#sys_PopupUpAddNoteProduct').modal('show');
        $('#myModalLabelAddNoteProduct').html('Ghi chú thông báo của sản phẩm - ' + product_id);
        $('#note_AddNoteProduct').val('');
        var button_submit = "<button class='btn btn-primary' onclick='sys_product.submitAddNoteProduct("+product_id+")'";
        button_submit += ">Ghi lại</button>";
        $('#button_update_AddNoteProduct').html(button_submit);
    },
    submitAddNoteProduct : function(product_id){
        var note_approve = document.getElementById('note_AddNoteProduct').value;
        if(note_approve == ''){
            alert('Bạn chưa nhập ghi chú cho sản phẩm này');
        }else{
            $('#img_loading_add_note').show();
            $.ajax({
             type: "post",
             url: WEB_ROOT + 'admin/adminProductSale/addNoteRefuseApproval',
             data: {product_id : product_id, note_approve:note_approve},
             dataType: 'json',
             success: function(res) {
                 $('#img_loading_add_note').hide();
                 if(res.isIntOk == 1){
                     alert(res.msg);
                     var xem_note = "<a class='btn btn-success approve_deal' href = 'javascript:void(0);' style='padding: 1px 2px;font-size: 12px; margin-top: 4px;' onclick='sys_product.getViewNoteProductToAdmin("+product_id+")'";
                     xem_note += ">Xem note</a>";
                     $('#show_view_note_pro_id_'+product_id).html(xem_note);
                     $('#sys_PopupUpAddNoteProduct').modal('hide');
                 }else{
                     alert(res.msg);
                 }
             }
             });
        }
    },

    /**
     * View note cua san pham cho Admin
     * @param id
     */
    getViewNoteProductToAdmin: function(product_id) {
        $('#sys_PopupShowNoteProduct').modal('show');
        $('#sys_table_view_note').hide();
        $('#sys_view_msg_note').html('');
        $('#img_loading_view_note').show();
        $('#myModalLabelShowNoteProduct').html('Các ghi chú của sản phẩm - '+product_id );
        if (product_id > 0) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/adminProductSale/getLogRefuseByProductId',
                data: {product_id : product_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_note').hide();
                    if(res.intReturn === 1){
                        var rs = res.info;
                        var html = "";
                        for( k in rs ) {
                            html += "<tr>";
                            html += "<td class='text-center text-middle'>" + rs[k].stt + "</td>";
                            html += "<td class='text-center text-middle'>" + rs[k].user_action + "</td>";
                            html += "<td>" + rs[k].note + "</td>";
                            html += "<td class='text-center text-middle'>" + rs[k].created_time + "</td>";
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
    },/**
     * View note cua san pham cho Shop
     * @param id
     */
    getViewNoteProductToShop: function(product_id) {
        $('#sys_PopupShowNoteProduct').modal('show');
        $('#sys_table_view_note').hide();
        $('#sys_view_msg_note').html('');
        $('#img_loading_view_note').show();
        $('#myModalLabelShowNoteProduct').html('Các ghi chú Muachung gửi cho shop về sản phẩm - '+product_id );
        if (product_id > 0) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'shop/manageProductSaleShop/getLogRefuseByProductId',
                data: {product_id : product_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_note').hide();
                    if(res.intReturn === 1){
                        var rs = res.info;
                        var html = "";
                        for( k in rs ) {
                            html += "<tr>";
                            html += "<td class='text-center text-middle'>" + rs[k].stt + "</td>";
                            html += "<td class='text-center text-middle'>" + rs[k].user_action + "</td>";
                            html += "<td>" + rs[k].note + "</td>";
                            html += "<td class='text-center text-middle'>" + rs[k].created_time + "</td>";
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

    /*
     upload nhiều ảnh khác của sản phẩm cùng một lúc
     */
    uploadMultipleImagesOtherProductShop: function() {
        $('#sys_PopupUploadImgOtherPro').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOther').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            multiple: true,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    var imagePopup = "<img style='float:left;margin: 5px; 10px; width:100px; height: 100px;' id='sys_new_img_" + xhr.info.id_key + "' width='100px' height='100px' src='" + xhr.info.src + "'/>";
                    $('#div_image').append(imagePopup);

                    var dalete_img = "<div class='clear'></div><a href='javascript:void(0);' onclick='Product.removeImageOtherProduct("+xhr.info.id_key+")' >Xóa ảnh</a>";
                    var html= "<div style='margin: 5px 10px 5px 0;padding:6px; width: 130px;overflow-x:hidden;float: left;text-align:center;border: 1px solid #eee;' id='sys_div_img_other_" + xhr.info.id_key + "'>";
                    html += "<img style='height:120px;' src='" + xhr.info.src + "'/>";
                    html += "<input type='hidden' id='sys_img_other_" + xhr.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + xhr.info.name_img_orther + "'/>";
                    html += dalete_img;
                    html +="</div>";
                    $('#div_image_input').append(html);
                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                setTimeout( "jQuery('#status').hide();",5000 );
                $('#sys_PopupUploadImgOtherPro').modal('hide');
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },
    /*
     upload Avatar của sản phẩm trong shop
     */
    uploadImagesAvatarProductShop: function() {
        $('#sys_PopupUploadImgAvartarPro').modal('show');
        $('.ajax-upload-dragdrop').remove();
        $('#div_image_avatar').hide();
        var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOther').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            multiple: false,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    $('#products_images').val(xhr.info.name_img_orther);
                    $('#image_hide_avatar').val(xhr.info.name_img_orther);
                    var img = '<img src="'+xhr.info.src+'" style="height:320px; width:534px" title ="Ảnh đại diện của sản phẩm"/>';
                    img += '<br/><a href="javascript:void(0);" onclick="Product.removeImageProduct();">Xóa ảnh đại diện</a>';
                    $( "#imageProductShow").html(img);
                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                setTimeout( "jQuery('#status').hide();",5000 );
                $('#sys_PopupUploadImgAvartarPro').modal('hide');
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader_avatar").uploadFile(settings);
    },

    actionClockCouponOrder: function() {
        var list_coupon = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_coupon += this.value + ',';
            }
        });
        if(list_coupon == ''){
            alert('Bạn chưa chọn Conpon để khóa');
        }else{
            if(confirm('Bạn có muốn Khóa các coupon này?')) {
                $('#img_loading_action').show();
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: WEB_ROOT + 'admin/adminCouponOrder/ajaxActionClockCoupon',
                    data: {
                        list_coupon : list_coupon
                    },
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(res) {
                        $('#img_loading_action').hide();
                        if(res.isIntOk == 1) {
                            alert(res.msg);
                            window.location.reload();
                        } else {
                            alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                        }
                    }
                });
            }
        }
    },
    /***************************************************************************************
     * tiêu chí dánh giá của danh mục sản phẩm
     * @param id
     * *************************************************************************************
     */
    getInforRattingCategory: function(category_id) {
        $('#sys_PopupShowRattingCategory').modal('show');
        $('#sys_view_msg_note').html('');
        $('#sys_block_ratting').html('');
        $('#img_loading_view_note').show();
        $('#myModalLabelShowRattingCategory').html('Các tiêu chí đánh giá của danh mục id - '+category_id );
        $('#sys_ratting_category_id').val(category_id);
        if (category_id > 0) {
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/adminCategory/getInforRattingCategory',
                data: {category_id : category_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_note').hide();
                    if(res.intReturn === 1){
                        var rs = res.infor;
                        var html = '';
                        for( k in rs ) {
                            html +="<div class='col-lg-9 padding-top-1'>";
                            html +="<div>";
                            html +="<div class='col-lg-10'>";
                            html +="<input type='text' name='ratting_name[" + rs[k].category_ratting_id + "]' class='form-control' value='" + rs[k].category_ratting_name + "'>";
                            html +="</div>";

                            html +="<div class='col-lg-2' id='ratting_delete_" + rs[k].category_ratting_id + "'>";
                            if(rs[k].category_ratting_status == 1){
                                var dalete_ratting = "<a href='javascript:void(0);' title='Click để ẩn tiêu chí này' onclick='sys_product.removeRatting("+rs[k].category_ratting_id+",1)'><i class='fa fa-check'></i></a>";
                            }else{
                                var dalete_ratting = "<a href='javascript:void(0);' title='Click để hiện thị tiêu chí này' onclick='sys_product.removeRatting("+rs[k].category_ratting_id+",0)'><i class='fa fa-times'></i></a>";
                            }
                            html +=dalete_ratting;
                            html +="</div>";
                            html +="<input type='hidden' id='status_ratting_id_" + rs[k].category_ratting_id + "' name='status_ratting[" + rs[k].category_ratting_id + "]' class='form-control' value='"+((rs[k].category_ratting_status == 1)?0:1)+"'>";

                            html +="</div>";
                            html +="</div>";
                        }
                        $('#sys_block_ratting').html(html);
                    }else{
                        var html = '';
                        html +='<div class="col-lg-9 padding-top-1">';
                        html +='<div><div class="col-lg-10"><input type="text" name="ratting_name_new[]" class="form-control" value=""></div></div>';
                        html +='</div>';
                        $('#sys_block_ratting').append(html);
                    }
                }
            });
        }
    },
    saveInforRattingCategory:function(){
        var category_id = document.getElementById('sys_ratting_category_id').value;
        if (category_id > 0) {
            var dataInput = $('#form_add_ratting').serialize();
            $('#img_loading_view_note').show();
            $.ajax({
                type: "post",
                url: WEB_ROOT + 'admin/adminCategory/saveInforRattingCategory?'+dataInput,
                data: {category_id : category_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_note').hide();
                    if(res.intReturn === 1){
                        alert(res.msg);
                        $('#sys_PopupShowRattingCategory').modal('hide');
                    }else{
                        $('#sys_view_msg_note').html(res.msg);
                    }
                }
            });
        }
    },
    addRattingCategory:function(){
        var html = '';
        html +='<div class="col-lg-9 padding-top-1">';
        html +='<div><div class="col-lg-10"><input type="text" name="ratting_name_new[]" class="form-control" value=""></div></div>';
        html +='</div>';
        $('#sys_block_ratting').append(html);
    },
    removeRatting:function(ratting_id,value){
        $('#status_ratting_id_'+ratting_id).val(value);
        if(value == 1){
            var dalete_ratting = "<a href='javascript:void(0);'title='Click để hiển thị tiêu chí này' onclick='sys_product.removeRatting("+ratting_id+",0)'><i class='fa fa-times'></i></a>";
        }else{
            var dalete_ratting = "<a href='javascript:void(0);'title='Click để hiển thị tiêu chí này' onclick='sys_product.removeRatting("+ratting_id+",1)'><i class='fa fa-check'></i></a>";
        }

        $('#ratting_delete_'+ratting_id).html(dalete_ratting);
    },
    /**************************************************************************************
    action sản phẩm hot
     *************************************************************************************
     */
    removeProductHot: function(product_id){
        if(product_id > 0){
            if(confirm('Bạn có muốn xóa sản phẩm nổi bật này không?')) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + 'admin/adminProductHot/removeProductHot',
                    data: {product_id : product_id},
                    dataType: 'json',
                    success: function(res) {
                        if(res.intReturn === 1){
                            alert(res.msg);
                            window.location.reload();
                        }else{
                            alert(res.msg);
                        }
                    }
                });
            }
        }
    },

}