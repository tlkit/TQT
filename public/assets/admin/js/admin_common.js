var adminCommon = {
    /*******************************************************************************************************************
     * Set Top San pham
     *******************************************************************************************************************/
    uploadMultipleImages: function() {
        $('#sys_PopupUpMultipleImages').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var urlAjaxUpload = document.getElementById('sys_ajaxUploadMultipleImages').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            multiple: true,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    var imagePopup = "<img style='float:left;margin: 5px; 10px; width:100px; height: 100px;' id='sys_new_img_" + xhr.info.id_key + "' width='100px' height='100px' src='" + xhr.info.src_img + "'/>";
                    $('#div_image').append(imagePopup);

                    var cheked_img = "<div class='clear'></div>Chọn: <input type='checkbox' id='checkbox_image_"+xhr.info.id_key+"' name='checkbox_image' value='"+xhr.info.id_key+"' onclick='adminCommon.checkImageInput("+xhr.info.id_key+")'/>";
                    var dalete_img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='javascript:void(0);' style='display:none;'id='a_delete_image_"+xhr.info.id_key+"' onclick='adminCommon.removeImageOther("+xhr.info.id_key+")' >Xóa</a>";

                    var html= "<div style='margin: 5px 10px 5px 0;padding:6px; width: 130px;overflow-x:hidden;float: left;text-align:center;border: 1px solid #eee;' id='sys_div_img_other_" + xhr.info.id_key + "'>";
                    html += "<img style='height:120px;' src='" + xhr.info.src_img + "'/>";
                    html += "<input type='hidden' id='sys_img_other_" + xhr.info.id_key + "' name='img_other[]' value='" + xhr.info.name_img + "'/>";
                    html += "<input type='hidden' id='sys_img_other_input_" + xhr.info.id_key + "' class='sys_name_img_input' name='img_other_input[]' value=''/>";
                    html += "<input type='hidden' id='sys_src_image_" + xhr.info.id_key + "' class='sys_src_img_input' name='src_image[]' value='" + xhr.info.src_img + "'/>";
                    html += cheked_img;
                    html += dalete_img;
                    html +="</div>";
                    $('#div_image_input').append(html);

                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                setTimeout( "jQuery('#status').hide();",5000 );
                $('#sys_PopupUpMultipleImages').modal('hide');
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },

    removeImageOther: function(id){
        if (confirm('Bạn có chắc xóa ảnh này?')) {
            var total_image_check = document.getElementById('sys_total_image_check').value;
            // xóa ảnh khác
            $('#sys_div_img_other_'+id).hide();
            $('#sys_img_other_input_'+id).val('');
            $('#sys_src_image_'+id).val('');
            if(parseInt(total_image_check) > 0){
                $('#sys_total_image_check').val(parseInt(total_image_check)-1);
            }
            //xóa popup
            $('#sys_new_img_'+id).hide();
        }
    },

    checkImageInput: function(id){
        var total_image_check = document.getElementById('sys_total_image_check').value;
        var check_image = document.getElementById('checkbox_image_'+id).checked;

        //chọn ảnh để input
        if(check_image === true){
            if( parseInt(total_image_check) <= 2){
                $('#a_delete_image_'+id).show();
                var image = document.getElementById('sys_img_other_'+id).value;
                $('#sys_img_other_input_'+id).val(image);
                //$('#sys_src_image_'+id).val(image);
                $('#sys_total_image_check').val(parseInt(total_image_check)+1);
            }else{
                alert('Bạn chỉ chọn tối đa 3 ảnh banner để dùng');
                $("#checkbox_image_"+id).attr("checked", false);
            }
        }
        //loại không chọn ảnh
        else{
            $('#a_delete_image_'+id).hide();
            $('#sys_img_other_input_'+id).val('');
            $('#sys_src_image_'+id).val('');
            $('#sys_total_image_check').val(parseInt(total_image_check)-1);
        }
    },

    /**
     * Lấy thông tin deal, SP của các banner cần gán quảng cáo
     */
    loadInforDealOfBanner: function(){
        var banner_type = document.getElementById("banner_type").value;
        var banner_object_id = document.getElementById("banner_object_id").value;
        var tinhthanh = document.getElementById("sys_tinhthanh").value;
        if(parseInt(banner_type) > 0 && parseInt(banner_object_id) > 0){
            var urlAjax = document.getElementById('sys_ajaxLoadDealOfBanner').value;
            $('#img_loading').show();
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {banner_type : banner_type,banner_object_id : banner_object_id,tinhthanh : tinhthanh},
                responseType: 'json',
                success: function(data) {
                    $('#img_loading').hide();
                    if(data.intReturn === 1){
                        //fill du lieu tim thay vao cac field
                        var data_out = data.infor;
                        $('#banner_name').val(data_out.banner_name);
                        $('#banner_url').val(data_out.banner_url);
                        $('#banner_price').val(data_out.banner_price);
                        $('#banner_percent').val(data_out.banner_percent);

                        //show anh hien thi
                        if(data_out.banner_images.length !== 0) {
                            $.each(data_out.banner_images, function (index, value) {
                                var cheked_img = "<div class='clear'></div>Chọn: <input type='checkbox' id='checkbox_image_"+value.id_key+"' name='checkbox_image' value='"+value.id_key+"' onclick='adminCommon.checkImageInput("+value.id_key+")'/>";
                                var dalete_img = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href='javascript:void(0);' style='display:none;'id='a_delete_image_"+value.id_key+"' onclick='adminCommon.removeImageOther("+value.id_key+")' >Xóa</a>";

                                var html= "<div style='margin: 5px 10px 5px 0;padding:6px; width: 130px;overflow-x:hidden;float: left;text-align:center;border: 1px solid #eee;' id='sys_div_img_other_" + value.id_key + "'>";
                                html += "<img style='height:120px;' src='" + value.src_img + "'/>";
                                html += "<input type='hidden' id='sys_img_other_" + value.id_key + "' name='img_other[]' value='" + value.name_img + "'/>";
                                html += "<input type='hidden' id='sys_img_other_input_" + value.id_key + "' class='sys_name_img_input' name='img_other_input[]' value=''/>";
                                html += "<input type='hidden' id='sys_src_image_" + value.id_key + "' class='sys_src_img_input' name='src_image[]' value='" + value.src_img + "'/>";
                                html += cheked_img;
                                html += dalete_img;
                                html +="</div>";
                                $('#div_image_input').append(html);
                            });
                        }
                    }else{
                        alert(data.msg)
                    }
                }
            });
        }else{
            alert('Bạn cần nhập dữ liệu chính xác! Hãy nhập lại');
        }
    },

    changeTypeBanner: function(){
        var banner_type = $('#banner_type').val();
        if(parseInt(banner_type) == 1){
            $('#sys_box_tinhthanh').show();
            $('#sys_box_none').hide();
        }else{
            $('#sys_box_tinhthanh').hide();
            $('#sys_box_none').show();
        }
    },

    /*
    check tìm kiếm banner theo type website
     */
    changeTypeWebsite: function(){
        var banner_name = 'a';
        if(banner_name != ''){
            var urlAjax = document.getElementById('sys_ajaxListBannerByName').value;
            $('#img_loading').show();
            $.ajax({
                type: "GET",
                url: urlAjax,
                data: {banner_name : banner_name},
                responseType: 'json',
                success: function(data) {
                    $('#img_loading').hide();
                    if(data.intReturn === 1){
                        var html= '<select name="sys_banner_id" id="sys_banner_id" class="form-control input-sm chosen-select-deselect" tabindex="12" data-placeholder="Nhập tên Banner để tìm kiếm">';
                        if(data.infor.length !== 0) {
                            $('#box_banner_id').html(html);
                            html+= '<option value=""></option>';
                            $.each(data.infor, function (index, value) {
                                html += '<option value="'+index+'">'+value+'</option>'
                            });
                            html+= '</select>';
                        }
                        $('#box_banner_id').html(html);
                        var config = {
                            '.chosen-select'           : {},
                            '.chosen-select-deselect'  : {allow_single_deselect:true},
                            '.chosen-select-no-single' : {disable_search_threshold:10},
                            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
                            //      '.chosen-select-width'     : {width:"95%"}
                        }
                        for (var selector in config) {
                            $(selector).chosen(config[selector]);
                        }
                    }else{
                        //alert(data.msg)
                    }
                }
            });
        }else{
            alert('Bạn cần nhập dữ liệu chính xác! Hãy nhập lại');
        }
    },

    /*
        Xem qua ảnh banner
     */

    viewPreviewImagerOther: function(){

        /*var banner_position = document.getElementById("banner_position").value;
         //var imageView = '<img class="img-overlay" style="background-image: url('+image_show_i+')" src="'+image_show_i+'" '+style_1+'>';
        var image_show_0 = '';
        var image_show_1 = '';
        var image_show_2 = '';
        var myElements = $(".sys_img_other_input");
        for (var i=0;i<myElements.length;i++) {
            alert(myElements.eq(i).attr("value"));
        }
         <img src="http://plaza10.vcmedia.vn/thumb/516_300/campaign/banner/-0-23601.jpg" width="172" height="300">
         <img src="http://plaza10.vcmedia.vn/thumb/516_300/campaign/banner/-0-23601.jpg" width="172" height="300">
         <img src="http://plaza10.vcmedia.vn/thumb/516_300/campaign/banner/-0-23601.jpg" width="172" height="300">
        */
    },

    viewPreviewImager: function(){
        var image_show_0 = '';
        var image_show_1 = '';
        var image_show_2 = '';
        var myElements = $(".sys_src_img_input");
        for (var i=0;i<myElements.length;i++) {
            if(image_show_0 == ''){
                image_show_0 = myElements.eq(i).attr("value");
            }else if(image_show_1 == ''){
                image_show_1 = myElements.eq(i).attr("value");
            }else if(image_show_2 == ''){
                image_show_2 = myElements.eq(i).attr("value");
            }
        }
        if(image_show_0 == '' && image_show_1 == '' && image_show_2 == ''){
            alert('Bạn chưa chọn ảnh Banner');
            return false;
        }
        var type_view = document.getElementById("type_view").value;
        if(parseInt(type_view) > 0){
            $('#sys_PopupShowView').modal('show');
            var banner_name = document.getElementById("banner_name").value;
            var banner_url = document.getElementById("banner_url").value;
            var title_banner = '<a href="'+banner_url+'" class="cl-trans" >'+banner_name+'</a>';
            $("#iframe_show").contents().find("#sys_title_adver").html(title_banner);

            var banner_percent = document.getElementById("banner_percent").value;
            $("#iframe_show").contents().find("#sys_percent").html(banner_percent);

            //hien thi giá san pham
            var banner_price = document.getElementById("banner_price").value;
            $("#iframe_show").contents().find("#sys_price").html(banner_price);

            var banner_price_end = document.getElementById("banner_price_end").value;
            var price_end = '<span class="price-val">'+banner_price_end+'</span><span class="price-unit">đ</span>';
            $("#iframe_show").contents().find("#sys_price_end").html(price_end);

            //ten, link nha cung cap
            var banner_supplier_name = document.getElementById("banner_supplier_name").value;
            var banner_supplier_url = document.getElementById("banner_supplier_url").value;
            var src_image_log_ncc = document.getElementById("src_image_log_ncc").value;
            var infor_ncc = '<a href="'+banner_supplier_url+'" class="logo-shop thumb-left" ><img src="'+src_image_log_ncc+'" alt="'+banner_supplier_name+'"></a>';
                infor_ncc += '<div class="flex-body"><a href="'+banner_supplier_url+'" class="shop-name" >'+banner_supplier_name+'</a></div>';
            $("#iframe_show").contents().find("#sys_infor_ncc").html(infor_ncc);

            var banner_target = document.getElementById("banner_target").value;
            var title_target = new Array();
            title_target[1]='Muachung';
            title_target[2]='Du lịch';
            title_target[3]='Vip';
            title_target[4]='Promotion';
            if(jQuery.inArray( banner_target, title_target )){
                $("#iframe_show").contents().find("#sys_target").html('#'+title_target[banner_target]);
            }else{
                $("#iframe_show").contents().find("#sys_target").html('#Loai target');

            }

            //view ảnh
            var imageView = '';
            if(parseInt(type_view) == 1){
                var style = 'style="height:300px; width:535px"';
                if(image_show_0 != ''){
                    imageView += '<img src="'+image_show_0+'" '+style+'>';
                }
            }else if(parseInt(type_view) == 2){
                var style = 'style="height:300px; width:260px"';
                if(image_show_0 != ''){
                    imageView += '<img src="'+image_show_0+'" '+style+'>';
                }
                if(image_show_1 != ''){
                    imageView += '<img src="'+image_show_1+'" '+style+'>';
                }
            }
            else if(parseInt(type_view) == 3){
                var style = 'style="height:300px; width:173px"';
                if(image_show_0 != ''){
                    imageView += '<img src="'+image_show_0+'" '+style+'>';
                }
                if(image_show_1 != ''){
                    imageView += '<img src="'+image_show_1+'" '+style+'>';
                }
                if(image_show_2 != ''){
                    imageView += '<img src="'+image_show_2+'" '+style+'>';
                }
            }
            $("#iframe_show").contents().find("#sys_block_image").html(imageView);
        }else{
            alert('Bạn chưa chọn kiểu xem');
        }
    },

    validate_form: function(){
        var price = $('#banner_price').val();
        if (price == '' || price == undefined) {
            this.displayValError('banner_price', 'Bạn chưa nhập giá sản phẩm.');
            return false;
        }
        else{
            $("#banner_price_hide").val($("#banner_price").autoNumeric("get"));
        }

        $("#banner_price_end_hide").val($("#banner_price_end").autoNumeric("get"));

        return true;
    },

    updateStatusItem: function(id,status){
        if(id > 0){
            var urlAjaxUpdateItem = document.getElementById('sys_urlAjaxUpdateStatusItem').value;
            $("#img_loading_status_item_"+id).show();
            $.ajax({
                type: "get",
                url: urlAjaxUpdateItem,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    $("#img_loading_status_item_"+id).hide();
                    if(data.intReturn == 1){
                        $('#sys_status_item_'+id).html('');
                        $('#sys_status_item_'+id).html(data.info);
                    }else{
                        alert('Có lỗi, chưa cập nhật được trạng thái');
                    }
                }
            });
        }
    },

    /*
    công lượt up cho SHop
     */
    payInningsUpToShop: function() {

        var list_id_shop = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_id_shop += this.value + ',';
            }
        });
        if(list_id_shop == ''){
            alert('Bạn chưa chọn Shop để thực hiện thao tác');
            return false;
        }
        $('#sys_PopupUpPayInningsup').modal('show');
    },
    submitPayInningsUp: function(){
        var type_up = document.getElementById('type_pay_innings_up').value;
        var number_up = document.getElementById('number_pay_innings_up').value;
        var note_up = document.getElementById('note_pay_innings_up').value;
        var submitForm = true;
        var list_id_shop = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_id_shop += this.value + ',';
            }
        });

        if(list_id_shop == ''){
            $('#sys_view_msg').html('Bạn chưa chọn Shop để thao tác');
            submitForm = false;
            return false;
        }
        if(parseInt(type_up) == 0){
            $('#sys_view_msg').html('Bạn chưa chọn thao tác thực hiện Nạp - Trừ lượt up');
            submitForm = false;
            return false;
        }
        if(!parseInt(number_up) && number_up == ''){
            $('#sys_view_msg').html('Bạn chưa nhập số lượt up');
            submitForm = false;
            return false;
        }
        if(note_up == ''){
            $('#sys_view_msg').html('Bạn chưa nhập lý do thực hiện');
            submitForm = false;
            return false;
        }

        if(submitForm){
            if(confirm('Bạn có muốn thực hiện thao tác này?')) {
                if(parseInt(type_up) > 0 && parseInt(number_up) > 0 && note_up != '') {
                    $('#sys_view_msg').html('');
                    $('#img_loading_pay_innings').show();
                    $.ajax({
                        dataType: 'json',
                        type: 'post',
                        url: WEB_ROOT + 'admin/supplier/payInninsUpToShop',
                        data: {
                            type_up : type_up, number_up : number_up, note_up : note_up, list_id_shop : list_id_shop
                        },
                        beforeSend: function() {},
                        complete: function() {},
                        success: function(res) {
                            $('#img_loading_pay_innings').hide();
                            if(res.isIntOk == 1) {
                                alert(res.msg);
                                $('#sys_PopupUpPayInningsup').modal('hide');
                            } else {
                                alert(res.msg);
                            }
                        }
                    });
                } else {
                    $('#sys_view_msg').html('Lượt up phải là số');
                }
            }
        }
    },

    deleteLogCallApi: function() {
        if(confirm('Bạn có muốn xóa các log này?')) {
            $('#img_loading_delete_log').show();
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: WEB_ROOT + 'admin/adminLogRunApi/deleteLogCallApi',
                data: {

                },
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(res) {
                    $('#img_loading_delete_log').hide();
                    if(res.isIntOk == 1) {
                        alert(res.msg);
                        window.location.reload();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng liên hệ với Admin.');
                    }
                }
            });
        }
    },
    removeSeoSmartLink: function(id){
        if(id > 0){
            if(confirm('Bạn có muốn xóa không?')) {
                $.ajax({
                    type: "POST",
                    url: WEB_ROOT + 'admin/seo/removeSeoSmartLink',
                    data: {id : id},
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
};