var linkAdmin = '';
var linkShop = '';
var Product = {
    /**
     * QuynhTM add
     * function action đăng sản phẩm
     */

    config: {
        checkUpload : true},

    updateStatusUser: function(id){
        if(id > 0){
            var urlAjaxUpdateStatus = document.getElementById('sys_urlAjaxUpdateStatus').value;
            var status = document.getElementById('option_status_id_'+id).value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatus,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        alert('Cập nhật thành công');
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                }
            });
        }
    },

    searchObjectShowPagePromotion: function(){
        var id_object = document.getElementById("search_object_id").value;
        if(id_object > 0){
            var urlAjaxGetItems = document.getElementById('sys_urlAjaxGetItems').value;

            $.ajax({
                type: "POST",
                url: urlAjaxGetItems,
                data: {id_object : id_object},
                responseType: 'json',
                success: function(data) {
                    $('#sys_object_id').html('');
                    var html = '<table class="table-hover table table-bordered success" width="100%">';
                    html +='<thead>';
                    html +='<tr>';
                    html +='<th width="3%">Id</th>';
                    html +='<th width="10%">Ảnh promotion</th>';
                    html +='<th width="87%">Tên Campaign</th>';
                    html +='</tr>';
                    html +='</thead>';
                    html +='<tbody >';
                    if(data.intReturn == 1){
                        var urlUploadImgCampaign = document.getElementById('sys_urlUploadImgCampaign').value;
                        var rs = data.info;
                        urlUploadImgCampaign +='/'+rs.id;
                        html += "<tr>";
                        html +="<td><input class='uniform' type='checkbox' value = '" + rs.id + "' name='page_promotion_object_id'/></td>";
                        html +="<td><img src='" + rs.img_promotion + "' width='30' height='30' /></td>";
                        html +="<td>" + rs.name + "</td>";
                        html += "</tr>"
                        html += "<tr>";
                        html +="<td  colspan='2' class='text-center'> <a href='" + urlUploadImgCampaign + "' class='btn btn-warning' target='_blank'>Sửa ảnh Campaign này</a></td>";
                        html +="<td> Trạng thái: "+rs.status+" <br/> Chạy từ ngày <b>"+rs.time_start+"</b> đến ngày: <b>"+rs.time_end+"</b></td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                        $('#sys_object_id').append(html);
                    }else{
                        html += "<tr>";
                        html +="<td  colspan='7'>Không có dữ liệu</td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                        $('#sys_object_id').append(html);
                    }
                }
            });
        }
    },

    popupActiveCouponCode: function(orderId, coupon){
        if(parseInt(orderId) > 0 && parseInt(coupon) > 0){
            var store_supplier_id = "";
            var selected = $("input[type='radio'][name='store_supplier_id']:checked");
            if (selected.length > 0) {
                store_supplier_id = selected.val();
            }
            if(store_supplier_id === ''){
                $('#sys_msg_return').html('<b class="red">Bạn chưa chọn kho để kích hoạt Coupon</b>');
            }else{
                if (confirm('Bạn có muốn kích hoạt mã Coupon này?')) {
                    var urlAjax = document.getElementById('sys_urlAjaxActiveOneCoupon').value ;
                    $('#button_action_coupon').hide();
                    $.ajax({
                        type: "POST",
                        url: urlAjax,
                        data: {orderId: orderId, coupon : parseInt(coupon),store_supplier_id : parseInt(store_supplier_id)},
                        responseType: 'json',
                        success: function(data) {
                            if(data.intReturn == 1){
                                $('#sys_msg_return').html(data.msg);
                            }else if(data.intReturn == -1){
                                $('#sys_msg_return').html(data.msg);
                                $('#button_action_coupon').show();
                            }
                        }
                    });
                }
            }
        }
    },

    popupInforActionOneCoupon: function(orderId,coupon) {
        $('#sys_PopupActiveOneCoupon').modal('show');
        $('#sys_msg_return').html('');
        $('#sys_infor_order').html('');
        if(orderId > 0 && coupon > 0){
            var urlAjax = document.getElementById('sys_urlAjaxGetInforOrderCoupon').value ;
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {orderId : orderId, coupon : coupon},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        var infor = data.info;
                        var action = 'onclick="Product.popupActiveCouponCode(' + orderId + ', '+infor.coupon_id+')"';
                        var html = '<table width="100%">';
                        html +='<tr>';
                        html +='<td colspan="2"> <b>'+infor.name+'</b></td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td width="20%">Giá bán:</td>';
                        html +='<td width="80%"><b class="price red">'+infor.price+'đ</b></td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td>Mã Coupon</td>';
                        html +='<td> <b class="green">'+infor.coupon+'</b></td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td width="20%">Kho nhà cung cấp:</td>';
                        html +='<td width="80%">'+infor.html_radio_store+'</td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td>HSD</td>';
                        html +='<td>'+infor.time_start+'  đến '+infor.time_end+' </td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td colspan="2" class="text-center"><a href="javascript:;" class="btn btn-info btn-xs" title="Active Coupon" id="button_action_coupon" style="height: 30px; margin-top: 10px;line-height: 25px;" ';
                        html += action;
                        html +='>Kích hoạt Coupon</a></td>';
                        html +='</tr>';

                        html +='</table>';

                        $('#sys_infor_order').html(html);
                    }else{
                        $('#sys_msg_return').html(data.msg);
                    }
                }
            });
        }
    },

    updateStatusOrderId: function(idOrder,status){
        if(idOrder > 0){
            var urlAjaxUpdateStatusOrder = document.getElementById('sys_urlAjaxUpdateStatusOrder').value;
            var status_order_change = document.getElementById('option_status_id_'+idOrder).value;
            if(status != status_order_change){
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateStatusOrder,
                    data: {idOrder : idOrder, status_order_change : status_order_change},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $('#sys_block_statusId_'+idOrder).html('');
                            $('#sys_block_statusId_'+idOrder).html(data.info);
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

    buildCopuponOrderId: function(idOrder){
        if(idOrder > 0){
            var urlAjaxBuildCouponOrder = document.getElementById('sys_urlAjaxBuildCouponOrder').value;
            $.ajax({
                type: "POST",
                url: urlAjaxBuildCouponOrder,
                data: {idOrder : idOrder},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_coupon_orderid_'+idOrder).html('');
                        $('#sys_coupon_orderid_'+idOrder).html(data.coupon);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                }
            });
        }
    },
    /*
    Update status list danh sách sản phẩm
     */
    updateAllStatusProduct:function(){
        var value_deal_id = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                value_deal_id += this.value + ',';
            }
        });
        if(value_deal_id ==''){
            alert('Bạn chưa chọn item để xóa.');
        }else{
            jQuery('#list_all_id_action').val(value_deal_id);
            Product.submitUpdateAllStatusProduct();
        }
    },

    submitUpdateAllStatusProduct: function(){
        var list_all_id_action = document.getElementById('list_all_id_action').value;
        var urlAjaxUpdate = document.getElementById('sys_urlAjaxAllStatusProduct').value;
        if(confirm('Bạn có muốn thay đổi trạng thái các sản phẩm này không?')) {
            $('#img_loading').show();
            $.ajax({
                type: "POST",
                url: urlAjaxUpdate,
                data: {list_all_id_action : list_all_id_action},
                responseType: 'json',
                success: function(data) {
                    $('#img_loading').hide();
                    if(data.intReturn == 1){
                        if(data.info.length !== 0){
                            $.each(data.info, function(key_id, link_a){
                                $('#sys_status_product_'+key_id).html('');
                                $('#sys_status_product_'+key_id).html(link_a);
                            });
                        }
                        //reset checked
                        var value_deal_id = '';
                        $('.checkbox_items').each(function() {
                            this.checked = false;
                        });
                        jQuery('#list_all_id_action').val(value_deal_id);

                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }else if(data.intReturn == 4){
                        if(data.info.length !== 0){
                            $.each(data.info, function(key_id, link_a){
                                $('#sys_status_product_'+key_id).html('');
                                $('#sys_status_product_'+key_id).html(link_a);
                            });
                        }
                        alert(data.msg);
                    }
                }
            });
        }
    },

    updateStatusProduct: function(id,status){
        if(id > 0){
            var urlAjaxUpdateStatusProduct = document.getElementById('sys_urlAjaxUpdateStatusProduct').value;
            if(confirm('Bạn có muốn thay đổi trạng thái sản phẩm này không?')) {
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateStatusProduct,
                    data: {id : id, status: status},
                    responseType: 'json',
                    success: function(data) {
                        if(data.intReturn == 1){
                            $('#sys_status_product_'+id).html('');
                            $('#sys_status_product_'+id).html(data.info);
                        }else if(data.intReturn == 2){
                            alert('Bạn không có quyền thực hiện thao tác này');
                        }else if(data.intReturn == 3){
                            window.location = linkAdmin+'login/logout';
                        }else if(data.intReturn == 4){
                            alert(data.msg);
                        }
                    }
                });
            }
        }
    },

    updateAreaPageHome: function(id,status){
        if(id > 0){
            var urlAjaxUpdateItem = document.getElementById('sys_urlAjaxUpdateItem').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateItem,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_page_home_'+id).html('');
                        $('#sys_status_page_home_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }
                }
            });
        }
    },

    searchObjectShowPageHome: function(){
        var id_object = document.getElementById("search_object_id").value;
        if(id_object > 0){
            var urlAjaxGetItems = document.getElementById('sys_urlAjaxGetItems').value;

            $.ajax({
                type: "POST",
                url: urlAjaxGetItems,
                data: {id_object : id_object},
                responseType: 'json',
                success: function(data) {
                    $('#sys_object_id').html('');
                    var html = '<table class="table-hover table table-bordered success" width="100%">';
                    html +='<thead>';
                    html +='<tr>';
                    html +='<th width="3%">Id</th>';
                    html +='<th width="10%">Banner <br/>lớn</th>';
                    html +='<th width="10%">Banner <br/> nhỏ</th>';
                    html +='<th width="10%">Banner <br/> promotion</th>';
                    html +='<th width="10%">SP hot</th>';
                    html +='<th width="10%">SP top</th>';
                    html +='<th width="57%">Tên Campaign</th>';
                    html +='</tr>';
                    html +='</thead>';
                    html +='<tbody >';
                    if(data.intReturn == 1){
                        var urlUploadImgCampaign = document.getElementById('sys_urlUploadImgCampaign').value;
                        var rs = data.info;
                        urlUploadImgCampaign +='/'+rs.id;
                            html += "<tr>";
                            html +="<td><input class='uniform' type='checkbox' value = '" + rs.id + "' name='page_home_object_id'/></td>";
                            html +="<td><img src='" + rs.img_big + "' width='30' height='30' /></td>";
                            html +="<td><img src='" + rs.img_min + "' width='30' height='30' /></td>";
                            html +="<td><img src='" + rs.img_promotion + "' width='30' height='30' /></td>";
                            html +="<td><img src='" + rs.img_product + "' width='30' height='30' /></td>";
                            html +="<td><img src='" + rs.img_product_top + "' width='30' height='30' /></td>";
                            html +="<td>" + rs.name + "</td>";
                            html += "</tr>"
                        html += "<tr>";
                       // html +="<td  colspan='6' class='text-center'> <a href='" + urlUploadImgCampaign + "' class='btn btn-warning' target='_blank'>Sửa ảnh Campaign này</a></td>";
                        //html +="<td> Trạng thái: "+rs.status+" <br/> Chạy từ ngày <b>"+rs.time_start+"</b> đến ngày: <b>"+rs.time_end+"</b></td>";
                        html +="<td  colspan='7'> Trạng thái: "+rs.status+" <br/> Chạy từ ngày <b>"+rs.time_start+"</b> đến ngày: <b>"+rs.time_end+"</b></td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                            $('#sys_object_id').append(html);
                    }else{
                        html += "<tr>";
                        html +="<td  colspan='7'>Không có dữ liệu</td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                        $('#sys_object_id').append(html);
                    }
                }
            });
        }
    },

    onchangeSelectOptionAreaBanner: function(){
        var type_top = document.getElementById("sys_type_banner").value;
        if(type_top > 0){
            var urlAjaxGetItems = document.getElementById('sys_urlAjaxGetItems').value;
            $.ajax({
                type: "POST",
                url: urlAjaxGetItems,
                data: {type_top : type_top},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_object_id').html('');
                        var rs = data.info;
                        for( k in rs ) {
                            var html = "<option value = '" + rs[k].id + "'>"+rs[k].name+"</option>";
                            $('#sys_object_id').append(html);
                        }
                    }
                }
            });
        }
    },

    // popup hiển thị list ảnh khác sản phẩm để chèn
    // vào mô tả ngắn của sản phẩm
    popupInsertImagesToDescPro: function() {
        var index = 1;
        $('#sys_PopupInsertImageToDesc').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var arrImgOther = new Array();
        $(".sys_img_other").each(function() {
            arrImgOther.push($(this).val());
        });
        var checkUpload= Product.config.checkUpload;
        var urlAjaxGetImagesOther = document.getElementById('sys_urlAjaxgGetListImages').value;
        /*
        Ajax upload thêm ảnh mới để chèn
         //upload them ảnh khác để chèn
         */
        if(checkUpload == true){
            var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOtherInsertToDesc').value;
            var settings = {
                url: urlAjaxUpload,
                method: "POST",
                allowedTypes:"jpg,png,jpeg",
                fileName: "multipleFile",
                multiple: true,
                onSuccess:function(files,xhr,data){
                    if(xhr.intReturn == 1){
                        CKEDITOR.instances.sys_posts_content.insertHtml('<img src="'+ xhr.info.src +'"/>');
                    }
                    $("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                    setTimeout( "jQuery('#status').hide();",5000 );
                    Product.config.checkUpload = false;
                },
                onError: function(files,status,errMsg){
                    $("#status").html("<font color='red'>Upload is Failed</font>");
                }
            }
            $("#sys_mulitplefileuploader_insertDesc").uploadFile(settings);
            index++;
        }
    },

    popupUploadImagerOtherPro: function() {
        $('#sys_PopupUploadImgOtherPro').modal('show');
        var urlAjaxUpload = document.getElementById('sys_urlAjaxUpload').value ;
        new AjaxUpload(jQuery('#sys_ajax_uploadImgOther'), {
            action: urlAjaxUpload,
            name: 'uploadfile',
            responseType: 'json',
            onSubmit: function(file, ext){
                if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){
                     alert('Only JPG, PNG, JPEG files are allowed');
                    return false;
                }
            },
            onComplete: function(file, xhr){
                if(xhr.intReturn == 1)
                {
                    Product.config.checkUpload = true; // call lại ajax load ảnh Other để chèn
                    var imagePopup = "<img style='float:left;margin: 5px; 10px; width:100px; height: 100px;' id='sys_new_img' width='100px' height='100px' src='" + xhr.info.src + "' />";
                    $('#div_image').append(imagePopup);
                    //add vao list s?n s?n ph?m khác
                    var checked_img_pro = "<br/><a href='javascript:void(0);' class='btn btn-warning' style='margin: 5px 0;' onclick='Product.checkedImageProduct(\""+xhr.info.name_img_orther+"\")' >??t ?nh ??i di?n</a><br/>";
                    var delete_img = "<br/><a href='javascript:void(0);' class='btn' style='background-color: #bbb; border: 1px solid #ccc;' onclick='Product.removeImageOtherProduct("+xhr.info.id_key+")' >Xóa ?nh</a>";

                    var html= "<div style='margin: 5px 10px 5px 0;padding:6px; width: 130px;overflow-x:hidden;float: left;text-align:center;border: 1px solid #eee;' id='sys_div_img_other_" + xhr.info.id_key + "'>";
                    html += "<img style='height:80px;' src='" + xhr.info.src + "'/>";
                    html += "<input type='hidden' id='sys_img_other_" + xhr.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + xhr.info.name_img_orther + "'/>";
                    html += checked_img_pro;
                    html += delete_img;
                    html +="</div>";
                    $('#div_image_input').append(html);
                }else{
                    alert('Bạn chưa chèn đc ảnh');
                }
            }
        });
    },

    /*
    upload nhiều ảnh cho Admin cùng một lúc
     */
    uploadMultipleImagesProduct: function() {
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
                    //check anh chỉnh sản phẩm
                    /*var products_images = $('#products_images').val();
                    if(products_images == '' || products_images == undefined){
                        $('#products_images').val(xhr.info.name_img_orther);
                        $('#products_images_key_upload').val(xhr.info.id_key);
                    }*/

                    var imagePopup = "<img style='float:left;margin: 5px; 10px; width:100px; height: 100px;' id='sys_new_img_" + xhr.info.id_key + "' width='100px' height='100px' src='" + xhr.info.src + "'/>";
                    $('#div_image').append(imagePopup);

                    //add vao list sản sản phẩm khác
                    //var checked_img_pro = "<a href='javascript:void(0);' class='btn btn-warning' style='margin: 5px 0;' onclick='Product.checkedImageProduct(\""+xhr.info.name_img_orther+"\")' >Đặt ảnh đại diện</a><br/>";
                    var checked_img_pro = "<div class='clear'></div><input type='radio' id='chẹcked_image_"+xhr.info.id_key+"' name='chẹcked_image' value='"+xhr.info.id_key+"' onclick='Product.checkedImageProduct(\""+xhr.info.name_img_orther+"\",\""+xhr.info.src+"\")'><label for='chẹcked_image_"+xhr.info.id_key+"' style='font-weight:normal'>Ảnh đại diện</label>";
                    var delete_img = "<a href='javascript:void(0);' onclick='Product.removeImageOtherProduct("+xhr.info.id_key+")' >Xóa ảnh</a>";

                    var html= "<li id='sys_div_img_other_" + xhr.info.id_key + "'>";
                    html += "<div class='block_img_upload' >";
                    html += "<img style='height:120px;' src='" + xhr.info.src + "'/>";
                    html += "<input type='hidden' id='sys_img_other_" + xhr.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + xhr.info.name_img_orther + "'/>";
                    html += checked_img_pro;
                    html += delete_img;
                    html +="</div></li>";
                    $('#sys_drag_sort').append(html);

                    //thanh cong
                    $("#status").html("<font color='green'>Upload is success</font>");
                    setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                    setTimeout( "jQuery('#status').hide();",5000 );
                    Product.config.checkUpload = true;
                }
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },

    /*
    upload 1 ảnh sản phẩm nổi bật
     */
    uploadProductImagesHot: function() {
        $('#sys_PopupUploadImgHotProduct').modal('show');
        $('.ajax-upload-dragdrop').remove();
        var settings = {
            url: WEB_ROOT + 'admin/adminProduct/uploadImageHotProduct',
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "uploadfile",
            multiple: false,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    $('#product_image_hot').val(xhr.info.name_img_orther);
                    //imageHotProductShow
                    var html = '';
                    html += "<img style='height:234px;width:515px' src='" + xhr.info.src + "'/>";
                    var delete_img = "<br/><a href='javascript:void(0);' onclick='Product.removeImageHotProduct()' >Xóa ảnh nổi bật</a>";
                    html += delete_img
                    $('#imageHotProductShow').html(html);
                    $('#sys_PopupUploadImgHotProduct').modal('hide');
                }
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_fileimagehotuploader").uploadFile(settings);
    },
    removeImageHotProduct: function(){
        if (confirm('Bạn có chắc xóa ảnh nổi bật này?')) {
            $('#product_image_hot').val('');
            $('#imageHotProductShow').html('');
        }
    },
    /*
    Up anh san pham cho SHOP
     */
    uploadMultipleImagesProductShop: function() {
        var category = document.getElementById('sys_category_id').value;
        if(parseInt(category) == 0){
            alert('Bạn chưa chọn danh mục sản phẩm.');
        }else {
            $('#sys_PopupUploadImgOtherPro').modal('show');
            $('.ajax-upload-dragdrop').remove();
            var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOther').value;

            var settings = {
                url: urlAjaxUpload,
                method: "POST",
                allowedTypes: "jpg,png,jpeg",
                fileName: "multipleFile",
                formData: {category: category},
                multiple: false,
                onSuccess: function (files, xhr, data) {
                    if (xhr.intReturn !== 0) {
                        //check anh chỉnh sản phẩm
                        /*var products_images = $('#products_images').val();
                         if(products_images == '' || products_images == undefined){
                         $('#products_images').val(xhr.info.name_img_orther);
                         $('#products_images_key_upload').val(xhr.info.id_key);
                         }*/

                        var imagePopup = "<img style='float:left;margin: 5px; 10px; width:100px; height: 100px;' id='sys_new_img_" + xhr.info.id_key + "' width='100px' height='100px' src='" + xhr.info.src + "'/>";
                        $('#div_image').append(imagePopup);

                        //add vao list sản sản phẩm khác
                        var checked_img_pro = "<div class='clear'></div><input type='radio' id='chẹcked_image_" + xhr.info.id_key + "' name='chẹcked_image' value='" + xhr.info.id_key + "' onclick='Product.checkedImageProduct(\"" + xhr.info.name_img_orther + "\",\"" + xhr.info.src + "\")'><label for='chẹcked_image_" + xhr.info.id_key + "' style='font-weight:normal'>Ảnh đại diện</label>";
                        var delete_img = "<a href='javascript:void(0);' onclick='Product.removeImageOtherProduct(" + xhr.info.id_key + ")' >Xóa ảnh</a>";

                        var html = "<li id='sys_div_img_other_" + xhr.info.id_key + "'>";
                        html += "<div class='block_img_upload'>";
                        html += "<img style='height:120px;' src='" + xhr.info.src + "'/>";
                        html += "<input type='hidden' id='sys_img_other_" + xhr.info.id_key + "' class='sys_img_other' name='img_other[]' value='" + xhr.info.name_img_orther + "'/>";
                        html += checked_img_pro;
                        html += delete_img;
                        html += "</div></li>";
                        $('#sys_drag_sort').append(html);

                        //thanh cong
                        $("#status").html("<font color='green'>Upload is success</font>");
                        setTimeout("jQuery('.ajax-file-upload-statusbar').hide();", 5000);
                        setTimeout("jQuery('#status').hide();", 5000);
                        Product.config.checkUpload = true;
                    } else {
                        $('#sys_PopupUploadImgOtherPro').modal('hide');
                        alert(xhr.msg);
                    }

                },
                onError: function (files, status, errMsg) {
                    $("#status").html("<font color='red'>Upload is Failed</font>");
                }
            }
            $("#sys_mulitplefileuploader").uploadFile(settings);
        }
    },

    /*
     upload nhiều ảnh cùng một lúc
     */
    uploadMultipleAddDesc: function() {
        $('#sys_PopupUploadImgOtherPro').modal('show');
        var urlAjaxUpload = document.getElementById('sys_urlUploadMultipleImageOther').value;
        var settings = {
            url: urlAjaxUpload,
            method: "POST",
            allowedTypes:"jpg,png,jpeg",
            fileName: "multipleFile",
            multiple: true,
            onSuccess:function(files,xhr,data){
                if(xhr.intReturn == 1){
                    CKEDITOR.instances.textDescrip.insertHtml('<img src="'+xhr.info.src+'"/>');
                    $('#sys_PopupUploadImgOtherPro').modal('hide');
                }
                $("#status").html("<font color='green'>Upload is success</font>");
                setTimeout( "jQuery('.ajax-file-upload-statusbar').hide();",5000 );
                setTimeout( "jQuery('#status').hide();",5000 );
                Product.config.checkUpload = true;
            },
            onError: function(files,status,errMsg){
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#sys_mulitplefileuploader").uploadFile(settings);
    },


    removeImageOtherProduct: function(id){
        if (confirm('Bạn có chắc xóa ảnh này?')) {
            // xóa ảnh khác
            $('#sys_div_img_other_'+id).hide();
            $('#sys_img_other_'+id).val('');

            var products_images_key_upload = $('#products_images_key_upload').val();
            if(parseInt(products_images_key_upload) == parseInt(id)){
                $('#products_images').val('');
            }

            //xóa popup
            $('#sys_new_img_'+id).hide();
            Product.config.checkUpload = true; // call lại ajax load ảnh Other để chèn
        }
    },

    removeImageProduct: function(){
        if (confirm('Bạn có chắc xóa ảnh đại diện này?')) {
            $('#products_images').val('');
            var img = '<img src="" style="height:120px;" title ="Ảnh đại diện của sản phẩm"/>';
            $( "#imageProductShow").html(img);
        }
    },

    checkedImageProduct: function(nameImage,srcImage){
        if (confirm('Bạn có muốn chọn ảnh này làm ảnh đại diện của sản phẩm?')) {
            $('#products_images').val(nameImage);
            var img = '<img src="'+srcImage+'" style="height:320px; width:534px" title ="Ảnh đại diện của sản phẩm"/>';
            img += '<br/><a href="javascript:void(0);" onclick="Product.removeImageProduct();">Xóa ảnh đại diện</a>';
            $( "#imageProductShow").html(img);
            /*$( "#imageProductShow" ).attr({
                src: srcImage,
                title: "Ảnh sản phẩm"
            });*/
            Product.config.checkUpload = true; // call lại ajax load ảnh Other để chèn
        }
    },

    showLogOrder: function(orderId) {
        $('#sys_PopupShowOrderCoupon').modal('show');
        $('#sys_msg_return').html('');
        $('#sys_infor_order').html('');
        if(orderId > 0 && coupon > 0){
            var urlAjax = document.getElementById('sys_urlAjaxGetInforOrderCoupon').value ;
            $.ajax({
                type: "POST",
                url: WEB_ROOT + 'showLogOrder',
                data: {orderId : orderId, coupon : coupon},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        var infor = data.info;
                        var action = 'onclick="Product.popupActiveCouponCode(' + orderId + ', '+infor.coupon_id+')"';
                        var html = '<table width="100%">';
                        html +='<tr>';
                        html +='<td colspan="2"> <b>'+infor.name+'</b></td>';
                        html +='</tr>';
                        html +='<tr>';
                        html +='<td width="20%">Giá bán:</td>';
                        html +='<td width="80%"><b class="price red">'+infor.price+'đ</b></td>';
                        html +='</tr>';
                        html +='<tr>';
                        html +='<td>Mã Coupon</td>';
                        html +='<td> <b class="green">'+infor.coupon+'</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="btn btn-info btn-xs" title="Active Coupon" id="button_action_coupon" ';
                        html += action;
                        html +='>Active Coupon này</a></td>';
                        html +='</tr>';
                        html +='<tr>';
                        html +='<td>HSD</td>';
                        html +='<td>'+infor.time_start+'  đến '+infor.time_end+' </td>';
                        html +='</tr>';
                        html +='</table>';
                        $('#sys_infor_order').html(html);
                    }else{
                        $('#sys_msg_return').html(data.msg);
                    }
                }
            });
        }
    },

    /*
    Huy dơn hang cua man hinh danh sach order cua khách
     */
    removeOrderCustomer: function(orderId){
        if(orderId > 0){
            if (confirm('Bạn có muốn hủy đơn hàng đã đặt này?')) {
                $('#img_loading_ajax_delete_'+orderId).show();
                var urlAjaxUpdateOrder = document.getElementById('sys_urlAjaxDeleteOrderCustomer').value;
                $('#sys_button_delete_order').hide();
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateOrder,
                    data: {idOrder : orderId},
                    responseType: 'json',
                    success: function(data) {
                        $('#img_loading_ajax_delete_'+orderId).hide();
                        if(data.intReturn == 1){
                            $('#msg_delete').html(data.msg);
                        }else {
                            $('#msg_delete').html(data.msg);
                            $('#sys_button_delete_order').show();
                        }
                        $('#msg_delete').show();
                    }
                });
            }
        }
    },

    insertImageEditor: function(src){
        CKEDITOR.instances.product_extra_desc.insertHtml('<img src="'+src+'"/>');
    },

    insertImageEditorByIdImage: function(id){
        //var src = document.getElementById('sys_img_other_insert_'+id).attr('src') ;
        var src = $('img[alt="sys_posts_content'+id+'"]').attr('src');
        CKEDITOR.instances.sys_posts_content.insertHtml('<img src="'+src+'"/>');
    },

	showLogOrders: function(orderId) {
        $('#sys_PopupShowOrderCoupon').modal('show');
        $('#sys_infor_log_order').html('');
        if(orderId > 0){
            $.ajax({
                type: "GET",
                url: WEB_ROOT + 'admin/showLogOrder',
                data: {orderId : orderId},
                dataType: 'json',
                success: function(res) {
                    if(res.isIntOK == 1){
                        var data = res.data;
                        var html = '<div id="div-4" class="body">';
                            html += '<table width=""100%" class="pupop_show_log_orders"><tr>';
                            html += '<th width="20%">Hành động</th>';
                            html += '<th width="20%">Vị trí tạo đơn hàng</th>';
                            html += '<th width="20%">Vùng thực thiên</th>';
                            html += '<th width="20%">Người thực hiện</th>';
                            html += '<th width="20%">Thời gian thực hiện</th>';
                            html += '</tr>';
                        $.each(data, function(index, value) {
                            html += '<tr><td>' + value.action + '</td>';
                            html += '<td>' + value.source + '</td>';
                            html += '<td>' + value.type + '</td>';
                            html += '<td>' + value.user_name + '</td>';
                            html += '<td>' + value.created_at + '</td></tr>';
                        });
                        html += '</table>';
                        html += '</div>';
                        $('#sys_infor_log_order').html(html);
                    }else{
                        alert('lỗi');
                    }
                }
            });
        }
    },

    getValueStatusProduct: function(){
        var value = document.getElementById('products_status').value;
        if(value == 1){
            $( "#next_button" ).show();
        }else{
            $( "#next_button" ).hide();
        }
    },

    getCheckParentIdCategory: function(){
        var value = document.getElementById('category_parent_id').value;
        if(value == 0){
            $( "#img_category" ).show();
        }else{
            $( "#img_category" ).hide();
        }
    },

    actionUpdateNext: function(valu){
        $('#sys_actionForm').val(valu) ;
        var value = document.getElementById('sys_actionForm').value;
        if(value == valu){
            $( "#form_add_product" ).submit();
        }
    },

    /**
     * Feed home
     */
    searchCampaignFeedHome: function(){
        var id_object = document.getElementById("search_object_id").value;
        if(id_object > 0){
            var urlAjaxGetItems = document.getElementById('sys_urlAjaxGetCampaign').value;
            $.ajax({
                type: "POST",
                url: urlAjaxGetItems,
                data: {id_object : id_object},
                responseType: 'json',
                success: function(data) {
                    $('#sys_object_id').html('');
                    var html = '<table class="table-hover table table-bordered success" width="100%">';
                    html +='<thead>';
                    html +='<tr>';
                    html +='<th width="3%">Id</th>';
                    html +='<th width="10%">Banner <br/>lớn</th>';
                    html +='<th width="10%">Banner <br/> nhỏ</th>';
                    html +='<th width="10%">Banner <br/> promotion</th>';
                    html +='<th width="10%">SP hot</th>';
                    html +='<th width="10%">SP top</th>';
                    html +='<th width="57%">Tên Campaign</th>';
                    html +='</tr>';
                    html +='</thead>';
                    html +='<tbody >';
                    if(data.intReturn == 1){
                        var urlUploadImgCampaign = document.getElementById('sys_urlUploadImgCampaign').value;
                        var rs = data.info;
                        urlUploadImgCampaign +='/'+rs.id;
                        html += "<tr>";
                        html +="<td><input class='uniform' type='checkbox' value = '" + rs.id + "' name='feed_home_campain_id'/></td>";
                        html +="<td><img src='" + rs.img_big + "' width='30' height='30' /></td>";
                        html +="<td><img src='" + rs.img_min + "' width='30' height='30' /></td>";
                        html +="<td><img src='" + rs.img_promotion + "' width='30' height='30' /></td>";
                        html +="<td><img src='" + rs.img_product + "' width='30' height='30' /></td>";
                        html +="<td><img src='" + rs.img_product_top + "' width='30' height='30' /></td>";
                        html +="<td>" + rs.name + "</td>";
                        html += "</tr>"
                        html += "<tr>";
                        html +="<td  colspan='6' class='text-center'> <a href='" + urlUploadImgCampaign + "' class='btn btn-warning' target='_blank'>Sửa ảnh Campaign này</a></td>";
                        html +="<td> Trạng thái: "+rs.status+" <br/> Chạy từ <b>"+rs.time_start+"</b> đến ngày: <b>"+rs.time_end+"</b></td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                        $('#sys_object_id').append(html);
                    }else{
                        html += "<tr>";
                        html +="<td  colspan='7'>Không có dữ liệu</td>";
                        html += "</tr>";
                        html +='</tbody>';
                        html +='</table>';
                        $('#sys_object_id').append(html);
                    }
                }
            });
        }
    },

    updateStatusFeedHome: function(id,status){
        if(id > 0){
            var urlAjaxUpdateStatus = document.getElementById('sys_urlAjaxUpdateStatusFeedHome').value;
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatus,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    if(data.intReturn == 1){
                        $('#sys_status_feed_home_'+id).html('');
                        $('#sys_status_feed_home_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }else if(data.intReturn == 4){
                        alert(data.msg);
                    }
                }
            });
        }
    },

    submitUpdateStickyFeedHome: function(id){
        if(id > 0){
            var urlAjaxUpdate = document.getElementById('sys_urlAjaxUpdateStickyFeedHome').value;
            var time_start = document.getElementById('feed_home_time_start').value;
            var time_end = document.getElementById('feed_home_time_end').value;
            var location = document.getElementById('feed_home_location').value;

            var sticky = ($('#feed_home_sticky').is(':checked')) ? 1: -1;
            var sticky_category = ($('#feed_home_sticky_catalog').is(':checked')) ? 1: -1;

            if(time_start == '' || time_end == ''){
                alert('Bạn phải chọn thời gian bắt đầu và kết thúc cho deal');
            }else{
                if (confirm('Bạn có muốn cập nhật dữ liệu này không?')) {
                    $.ajax({
                        type: "POST",
                        url: urlAjaxUpdate,
                        data: {id:id, sticky:sticky ,sticky_category:sticky_category ,time_start:time_start, time_end:time_end, location:location},
                        responseType: 'json',
                        success: function(data) {
                            if(data.intReturn == 1){
                                var show = data.info;
                                $('#sys_sticky_feed_home_'+id).html('');
                                $('#sys_sticky_feed_home_'+id).html(show.sticky);
                                $('#sys_sticky_category_feed_home_'+id).html('');
                                $('#sys_sticky_category_feed_home_'+id).html(show.stickyCategory);
                                $('#sys_location_feed_home_'+id).html('');
                                $('#sys_location_feed_home_'+id).html(show.location);

                                alert('Đã cập nhật thành công');
                                $('#sys_PopupUpScore').modal('hide');
                            }else if(data.intReturn == 2){
                                alert('Bạn không có quyền thực hiện thao tác này');
                            }else if(data.intReturn == 3){
                                window.location = linkAdmin+'login/logout';
                            }else if(data.intReturn == 4){
                                alert(data.msg);
                            }else if(data.intReturn == -1){
                                alert("Trong khoảng thời gian này, đã đủ deal cho Sticky");
                            }
                        }
                    });
                }
            }
        }
    },

    submitUpdateScoreFeedHome: function(id){
        var money_score = document.getElementById('money_score').value;
        if(money_score == 0){
            alert('Bạn chưa chọn mệnh giá để up điểm!');
        }else{
            if (confirm('Bạn có muốn nạp điểm cho deal này không?')) {
                if(id > 0 && money_score > 0){
                    var urlAjaxUpdateScore = document.getElementById('sys_urlAjaxUpdateScoreFeedHome').value;
                    $.ajax({
                        type: "POST",
                        url: urlAjaxUpdateScore,
                        data: {id : id, money_score : money_score},
                        dataType: 'json',
                        success: function(res) {
                            if(res.intReturn == 1){
                                $('#sys_feed_home_score_'+id).html('');
                                $('#sys_feed_home_score_'+id).html(res.info);
                                alert('Đã up điểm thành công');
                                $('#sys_PopupUpScore').modal('hide');
                            }else{
                                alert('lỗi chưa cập nhật đươc điểm cho deal này');
                            }
                        }
                    });
                }
            }
        }
    },

    updateInforDealFeedHome: function(id,type_update) {
        /*type_update: 1 update sticky
        type_update: 2 update score*/

        $('#sys_PopupUpScore').modal('show');
        $('#sys_show_infor_update_score').hide();
        $('#sys_show_infor_update_sticky').hide();
        $('#sys_block_popup_infor').hide();


        var urlAjaxUpdateInfor = document.getElementById('sys_urlAjaxGetInforFeedHome').value;
        $.ajax({
            type: "POST",
            url: urlAjaxUpdateInfor,
            data: {id : id},
            dataType: 'json',
            success: function(res) {
                if(res.intReturn == 1){
                    var data = res.info;
                    $('#sys_popup_img').html("<img src='" + data.campaign_image + "' width='155' height='120'/>");
                    var html_infor = "<p><b>" + data.campain_name + "</b>";
                    html_infor += "<br/><i class='font_11'>Chạy từ <b class='green'>" + data.campain_time_start + "</b> đến <b class='red'>" + data.campain_time_end + "</b></i>";
                    html_infor += "<br/>Campaign Id: <b>" + data.campain_id + "</b>";
                    html_infor += "<br/>Danh mục: <b>" + data.name_category + "</b>";
                    html_infor += "<br/>Điểm xếp hạng: <b>" + data.score + "</b>";
                    html_infor += '</p>';
                    $('#sys_popup_infor_campagin').html(html_infor);
                    if(type_update == 1){
                        $('#sys_popup_name_province').html('<b>'+data.name_province+'</b>');
                        $('#sys_popup_location').html("<input type='hidden' class='form-control' name='feed_home_location' id='feed_home_location' value='" + data.location +"'/>");

                        $('#sys_popup_sticky').html(data.sticky);
                        $('#sys_popup_sticky_category').html(data.sticky_category);
                        $('#sys_popup_time_start').html("<input type='text' class='form-control' name='feed_home_time_start' id='feed_home_time_start' style='width: 295px' data-date-format='DD-MM-YYYY hh:mm A' value='" + data.time_start +"'/>");
                        $('#sys_popup_time_end').html("<input type='text' class='form-control' name='feed_home_time_end' id='feed_home_time_end' style='width: 295px' data-date-format='DD-MM-YYYY hh:mm A' value='" + data.time_end +"'/>");
                        $('#feed_home_time_start').datetimepicker();
                        $('#feed_home_time_end').datetimepicker();

                        //button
                        var button_submit = "<button class='btn btn-primary' onclick='Product.submitUpdateStickyFeedHome("+id+")'";
                        button_submit += ">Cập nhật</button>";
                        $('#button_update').html(button_submit);
                        $('#sys_show_infor_update_sticky').show();
                    }else{
                        //button
                        var button_submit = "<button class='btn btn-primary' onclick='Product.submitUpdateScoreFeedHome("+id+")'";
                        button_submit += ">Cập nhật</button>";
                        $('#button_update').html(button_submit);
                        $('#sys_show_infor_update_score').show();
                        $('#money_score').val(0);
                    }
                    $('#sys_block_popup_infor').show();
                }
            }
        });
    },
    /*
    Action cho Log COD
     */
    putSendSmsLogAgain: function(id_log_sms) {
        if(id_log_sms > 0){
            if (confirm('Bạn có muốn gửi lại tin nhắn này?')) {
                var urlAjax = document.getElementById('sys_urlSendSmsAgain').value;
                $('#img_loading_log_sms_'+id_log_sms).show();
                $('#botton_send_log_sms_'+id_log_sms).hide();
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {id_log_sms : id_log_sms},
                    dataType: 'json',
                    success: function(res) {
                        $('#img_loading_log_sms_'+id_log_sms).hide();
                        $('#botton_send_log_sms_'+id_log_sms).show();
                        if(res.intReturn === 1){
                            alert(res.msg);
                        }else{
                            alert(res.msg);
                        }
                    }
                });
            }
        }
    },
    /*
    day don hang sang ben COD o list don hang
     */
    pushOrderIdToCod: function(orderId) {
        if(orderId > 0){
            if (confirm('Bạn có muốn đẩy lại đơn hàng này qua COD?')) {
                $('#sys_block_put_order_id_'+orderId).hide();
                var urlAjax = document.getElementById('sys_urlPushDataOrderCod').value;
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {orderId : orderId},
                    dataType: 'json',
                    success: function(res) {
                        if(res.intReturn === 1){
                            alert(res.msg);
                        }else{
                            alert(res.msg);
                            $('#sys_block_put_order_id_'+orderId).show();
                        }
                    }
                });
            }else{
                $('#sys_block_put_order_id_'+orderId).show();
            }
        }
    },

    getViewLogCod: function(orderId) {
        $('#sys_PopupShowLogCod').modal('show');
        $('#sys_table_view_log_order').hide();
        $('#sys_table_view_log_cod').hide();
        $('#myModalLabel').html('View log COD của Order id: '+orderId );
        if (orderId > 0) {
            $('#img_loading').show();
            var urlAjax = document.getElementById('sys_urlViewLogCOD').value;
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {orderId : orderId},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn === 1){
                        var rs = res.info;
                        var html = "";
                        for( k in rs ) {
                            html += "<tr>";
                            html += "<td>" + rs[k].stt + "</td>";
                            html += "<td>[" + rs[k].user_id + "] " + rs[k].user_name + "</td>";
                            html += "<td>" + rs[k].created_time + "</td>";
                            html += "<td>" + rs[k].status + "</td>";
                            html += "<td>" + rs[k].note + "</td>";
                            html += "</tr>";
                        }
                        $('#sys_table_view_log_cod').show();
                        $('#sys_tr_infor_log_cod').html(html);
                    }else{
                        $('#sys_table_view_log_cod').show();
                        $('#sys_table_view_log_cod').html(res.msg);
                    }
                }
            });
        }
    },

    getViewLogOrder: function(orderId) {
        $('#sys_PopupShowLogCod').modal('show');
        $('#sys_table_view_log_cod').hide();
        $('#sys_table_view_log_order').hide();
        $('#img_loading').show();
        $('#myModalLabel').html('View log Order id: '+orderId );
        if (orderId > 0) {
            var urlAjax = document.getElementById('sys_urlViewLogOrder').value;
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {orderId : orderId},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn === 1){
                        var rs = res.info;
                        var html = "";
                        for( k in rs ) {
                            html += "<tr>";
                            html += "<td>" + rs[k].stt + "</td>";
                            html += "<td>[" + rs[k].cod_id + "] " + rs[k].cod_name + "</td>";
                            html += "<td>" + rs[k].created_time + "</td>";
                            html += "<td>" + rs[k].status + "</td>";
                            html += "<td>" + rs[k].note + "</td>";
                            html += "</tr>";
                        }
                        $('#sys_table_view_log_order').show();
                        $('#sys_tr_infor_log_order').html(html);
                    }else{
                        $('#sys_table_view_log_order').show();
                        $('#sys_table_view_log_order').html(res.msg);
                    }
                }
            });
        }
    },



    /*
     Nạp tiền vào ví cho Shop
     */
    pushRequestMoneyShop: function(request_id) {
        $('#sys_PopupRequestMoney').modal('show');
        $('#sys_view_infor_request').html('');
        $('#sys_block_popup_infor').hide();
        $('#img_loading').show();
        var urlAjaxGetInfor = document.getElementById('sys_urlGetInforRequest').value;
        $.ajax({
            type: "POST",
            url: urlAjaxGetInfor,
            data: {request_id : request_id},
            dataType: 'json',
            success: function(res) {
                $('#img_loading').hide();
                if(res.intReturn === 1){
                    var data = res.info;
                    var html_infor = "<p>Số tiền nạp ví: <b class='red'>" + data.number_value + "</b>";
                    html_infor += "<br/>Nạp cho nhà cung cấp: <b>" + data.supplier_name + "</b>";
                    html_infor += "<br/>Hình thức nạp: <b>" + data.name_request_type + "</b>";
                    html_infor += '</p>';
                    $('#sys_view_infor_request').html(html_infor);
                    if(data.request_status == 1 && data.request_type == 1){
                        var button_submit = "<button class='btn btn-primary' onclick='Product.submitPushMoneyToShop("+data.id+")' id='button_submit_ajax'";
                        button_submit += ">Nạp ví</button>";
                        $('#button_update').html(button_submit);
                    }else{
                        var msg = '<b class="red">Yêu cầu nạp tiền này đã được thực hiện! <br/>Hình thức nạp ví không đúng! <br/>Yêu cầu này bị hủy!</b>';
                        $('#button_update').html(msg);
                    }

                    $('#sys_show_infor_update_score').show();
                    $('#sys_block_popup_infor').show();
                }else{
                    $('#sys_view_infor_request').html('Không tìm thấy dữ liệu để nạp điểm');
                }
            }
        });
    },

    submitPushMoneyToShop: function(request_id){
        if(request_id == 0){
            alert('Có lỗi khi nạp điểm!');
        }else{
            if (confirm('Bạn có muốn nạp ví cho shop này không?')) {
                if(request_id > 0){
                    $('#button_submit_ajax').attr('onclick','').unbind('click');
                    var urlAjax = document.getElementById('sys_urlActionRequestMoneyShop').value;
                    $('#img_loading').show();
                    $.ajax({
                        type: "POST",
                        url: urlAjax,
                        data: {request_id : request_id},
                        dataType: 'json',
                        success: function(res) {
                            $('#img_loading').hide();
                            if(res.intReturn == 1){
                                alert('Đã nạp điểm thành công');
                                $('#sys_PopupRequestMoney').modal('hide');
                            }else{
                                alert(res.msg);
                            }
                        }
                    });
                }
            }
        }
    },


    /**
     * update status
     */
    updateStatusSupplierAccount: function(id,status){
        if(id > 0){
            var urlAjaxUpdateStatus = document.getElementById('sys_urlAjaxUpdateStatusSupplierAcount').value;
            $('#img_loading_status_'+id).show();
            $.ajax({
                type: "POST",
                url: urlAjaxUpdateStatus,
                data: {id : id, status: status},
                responseType: 'json',
                success: function(data) {
                    $('#img_loading_status_'+id).hide();
                    if(data.intReturn == 1){
                        $('#sys_status_supplier_account_'+id).html('');
                        $('#sys_status_supplier_account_'+id).html(data.info);
                    }else if(data.intReturn == 2){
                        alert('Bạn không có quyền thực hiện thao tác này');
                    }else if(data.intReturn == 3){
                        window.location = linkAdmin+'login/logout';
                    }else if(data.intReturn == 4){
                        alert(data.msg);
                    }
                }
            });
        }
    },

    /*
    * Quản lý đăng tin
    * set up thời gian dăng tin
     */
    popupSetupTimeRunDeal: function(idDeal) {
        $('#sys_PopupSetTimeUpDeal').modal('show');
        $('#sys_infor_popup').hide();
        $('#sys_msg_return').hide();
        Product.resetInputPopup();
        Product.removePointer();
         if(idDeal > 0 ){
            var urlAjax = document.getElementById('sys_urlAjaxGetInforShop').value ;
            $('#img_loading_ajax').show();
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {campaign_id : idDeal},
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
                                Product.addTime(str_time);
                            });
                        }

                        //show thông tin
                        var nameDeal = infor.campain_name+" (Id deal:" + infor.campain_id + ")";
                        $('#sys_name_deal_up').html(nameDeal);

                        /*var tinhthanhDeal = infor.name_province;
                        $('#sys_tinhthanh_deal_up').html(tinhthanhDeal);*/

                        //lươt up deal cua shop
                        $('#sys_number_up_shop').html(infor.strNumberUp);
                        $('#sys_number_up_can_user_shop').val(infor.numberUpDeal);

                        $('#number_up_hold').val(infor.number_up_hold);
                        $('#sys_hidden_hold_con_lai').val(infor.number_up_hold);
                        $('#hold_con_lai').html(infor.number_up_hold);

                        //if(infor.numberUpDeal > 0){
                            var button_submit = "<a href='javascript:;' class='btn btn-primary'onclick='Product.submitSetUpTime()' id='submitUptime'>";
                            button_submit += "<i class='fa fa-floppy-o'></i> &nbsp;&nbsp;Lưu lại</a>";

                            button_submit += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:;' class='btn btn-warning'onclick='Product.exitPopup()' >";
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
                    var urlAjax = document.getElementById('sys_urlAjaxPustUpTimeDeal').value ;
                    //$('#button_submit').hide();
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
            Product.removePointer();
            if(limit_1 > 0){
                Product.buildTimeRun(limit_1,0);
            }
            if(limit_2 > 0){
                Product.buildTimeRun(limit_2,6);
            }
            if(limit_3 > 0){
                Product.buildTimeRun(limit_3,12);
            }
            if(limit_4 > 0){
                Product.buildTimeRun(limit_4,18);
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
            Product.addTime(time);
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

    getViewLogUptimeDeal: function(campaign_id,feed_id) {
        $('#sys_PopupShowLogUptimeDeal').modal('show');
        $('#sys_table_view_log').hide();
        $('#sys_view_msg').html('');
        $('#img_loading').show();
        $('#myModalLabelLogUpdeal').html('Lịch sử đặt lịch up tin của deal '+campaign_id );
        if (campaign_id > 0) {
            var urlAjax = document.getElementById('sys_urlViewLogUptimeDeal').value;
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {campaign_id : campaign_id,feed_id : feed_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
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

    getViewInforEffectDeal: function(product_id) {
        $('#sys_PopupShowInforEffectDeal').modal('show');
        $('#sys_table_view_effect').hide();
        $('#sys_view_effect').html('');
        $('#sys_view_infor_campaign').hide();
        $('#img_loading_view_effect').show();
        $('#myModalLabelInforEffectDeal').html('Hiệu quả của sản phẩm - '+product_id );
        if (product_id > 0) {
            var urlAjax = document.getElementById('sys_urlViewInforEffectProduct').value;
            $.ajax({
                type: "Get",
                url: urlAjax,
                data: {product_id : product_id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_view_effect').hide();
                    if(res.intReturn === 1){
                        if(res.infor_campaign !== 0) {
                            var inforCampaign = res.infor_campaign;
                            var html_campaign = '';
                            html_campaign += "Sản phẩm:<span> <b>" + inforCampaign.product_name + "</b></span>";
                            html_campaign += "<div class='clearfix'></div>";
                            $('#sys_view_infor_campaign').show();
                            $('#sys_view_infor_campaign').html(html_campaign);
                        }

                        if(res.infor_location !== 0) {
                            var inforLocation = res.infor_location;
                            var html = "";
                            for (k in inforLocation) {
                                html += "<tr>";
                                html += "<td class='text-center'>" + inforLocation[k].name_location + "</td>";
                                html += "<td class='text-center'>" + inforLocation[k].count_view + "</td>";
                                html += "<td class='text-center'>" + inforLocation[k].count_sale + "</td>";
                                html += "</tr>";
                            }
                            $('#sys_table_view_effect').show();
                            $('#sys_tr_infor_effect').html(html);
                        }
                    }else{
                        $('#sys_view_effect').html(res.msg);
                    }
                }
            });
        }
    },
    /*
     Up score cho SHOP
     */
    getInforCampaignOfShopUpscore: function(campaign_id) {
        $('#sys_PopupUpScore').modal('show');
        $('#sys_popup_infor_campagin').html('');
        $('#sys_block_popup_infor').hide();
        $('#img_loading').show();
        var urlAjaxGetInfor = document.getElementById('sys_urlAjaxGetInforCampaginFeedHome').value;
        $.ajax({
            type: "POST",
            url: urlAjaxGetInfor,
            data: {campaign_id : campaign_id},
            dataType: 'json',
            success: function(res) {
                if(res.intReturn === 1){
                    $('#img_loading').hide();
                    var data = res.info;
                    if(data.moneyShop >0){
                        var button_submit = "<button class='btn btn-primary' onclick='Product.submitUpdateScoreCampaignShop("+campaign_id+")' id='button_submit_ajax'";
                        button_submit += ">Set Top</button>";

                        button_submit += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:;' class='btn btn-warning' onclick='Product.exitPopupSetTop()' style='background-color:#bbb;border-color:#bbb;margin-left: 10px;'>";
                        button_submit += "&nbsp;&nbsp;Bỏ qua</a>";
                        $('#button_update').html(button_submit);
                    }else{
                        var thongbao = "<b class='red'>Bạn muốn set top cho deal này? Shop của bạn đã hết lượt up!<br/> <a href='javascript:;' onclick='Product.exitPopupSetTop();Gold.openPopupBuyUp("+campaign_id+");' >";
                        thongbao += "Mua lượt up cho shop để set top</a></b>";
                        $('#button_update').html(thongbao);
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

    submitUpdateScoreCampaignShop: function(camp_id){
        if(camp_id > 0){
            $('#button_submit_ajax').hide();
            $('#img_loading').show();
                var urlAjaxUpdateScore = document.getElementById('sys_urlAjaxUpdateScoreShop').value;
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateScore,
                    data: {camp_id : camp_id},
                    dataType: 'json',
                    success: function(res) {
                        $('#img_loading').hide();
                        if(res.intReturn == 1){
                            alert('Đã Set Top thành công');
                            $('#sys_PopupUpScore').modal('hide');
                            window.location = linkShop+'manageUpDeal';
                        }else{
                            alert(res.msg);
                        }
                    }
                });
            }
    },
    /**
     * Xóa uptime
     */
    deleteDealUp:function(){
        var value_deal_id = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                value_deal_id += this.value + ',';
            }
        });
        if(value_deal_id ==''){
            alert('Bạn chưa chọn item để xóa.');
        }else{
            jQuery('#list_deal_delete').val(value_deal_id);
            Product.submitDeleteUptimeDeal();
        }
    },

    submitDeleteUptimeDeal: function(){
        var list_deal_delete = document.getElementById('list_deal_delete').value;
        if(list_deal_delete != ''){
            if (confirm('Bạn có muốn Xóa các deal này không?')) {
                $('#sys_button_delete_up_deal').hide();
                $('#img_loading_delete').show();
                var urlAjaxUpdateScore = document.getElementById('sys_urlAjaxDeleteUptimeDeal').value;
                $.ajax({
                    type: "POST",
                    url: urlAjaxUpdateScore,
                    data: {list_deal_delete : list_deal_delete},
                    dataType: 'json',
                    success: function(res) {
                        alert(res.msg);
                        window.location = linkShop+'manageUpDeal';
                        $('#sys_button_delete_up_deal').show();
                        $('#img_loading_delete').hide();
                    }
                });
            }
        }else{
            alert('Bạn chưa chọn deal để xóa');
        }
    },


    /**
     * checked xác nhận đơn hàng cho shop
     */
    updateConfirmOrderShop:function(){
        var value_id = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                value_id += this.value + ',';
            }
        });
        if(value_id ==''){
            alert('Bạn chưa chọn đơn hàng để xác nhận.');
        }else{
            jQuery('#list_checked_id').val(value_id);
            Product.submitConfirmOrderSho();
        }
    },
    updateConfirmOrderInDetailShop:function(order_id){
        if(parseInt(order_id) > 0){
            if (confirm('Bạn có muốn xác nhận các đơn hàng này?')) {
                $('#sys_confirm_not_ok').hide();
                $('#img_loading_update').show();
                var urlAjax = document.getElementById('sys_urlAjaxConfirmOrder').value;
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {list_id : parseInt(order_id)},
                    dataType: 'json',
                    success: function(res) {
                        if(res.intReturn == 1){
                            $('#img_loading_update').hide();
                            $('#sys_confirm_ok').show();
                            $('#sys_confirm_ok').html(res.msg);
                        }else{
                            alert(res.msg);
                            $('#img_loading_update').hide();
                            $('#sys_confirm_not_ok').show();
                        }
                    }
                });
            }
        }
    },
    submitConfirmOrderSho: function(){
        var list_id = document.getElementById('list_checked_id').value;
        if(list_id != ''){
            if (confirm('Bạn có muốn xác nhận các đơn hàng này?')) {
                var urlAjax = document.getElementById('sys_urlAjaxConfirmOrder').value;
                $('#sys_button_ConfirmOrderShop').hide();
                $('#img_loading_update').show();
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {list_id : list_id},
                    dataType: 'json',
                    success: function(res) {
                        $('#img_loading_update').hide();
                        $('#sys_button_ConfirmOrderShop').show();
                        alert(res.msg);
                        window.location.reload();
                    }
                });
            }
        }else{
            alert('Bạn chưa chọn deal để xóa');
        }
    },
    /**
     * Check chay đồng bộ các campaign trong feed home
     */
    syncListCampaignToFeedHome:function(){
        var value_id = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                value_id += this.value + ',';
            }
        });
        if(value_id ==''){
            alert('Bạn chưa chọn deal để đồng bộ.');
            return false;
        }else{
            jQuery('#list_checked_id').val(value_id);
            if (confirm('Bạn có muốn dồng bộ các deal này?')) {
                var urlAjax = document.getElementById('sys_syncListCampaignToFeedHome').value;
                $('#sys_button_ConfirmOrderShop').hide();
                $('#img_loading_update').show();
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {list_id : value_id},
                    dataType: 'json',
                    success: function(res) {
                        if(res.intReturn == 1){
                            $('#img_loading_update').hide();
                            $('#sys_button_ConfirmOrderShop').show();
                            alert(res.msg);
                            window.location.reload();
                        }
                    }
                });
            }
        }
    },

    /**
     * Poup kích hoạt Coupon
     */
    viewPopupCouponAction: function() {
        var list_coupon = '';
        $('.checkbox_items').each(function() {
            if(this.checked == true){
                list_coupon += this.value + ',';
            }
        });
        var store_supplier_id = 0;
        store_supplier_id = $("input[type='radio'][name='store_supplier_id']:checked").val();
        if(list_coupon ===''){
            alert('Bạn chưa chọn mã Coupon để kích hoạt.');
        }else if(parseInt(store_supplier_id) <= 0 || store_supplier_id == undefined){
            alert('Bạn chưa chọn kho để kích hoạt Coupon.');
        }else if(list_coupon != '' && store_supplier_id !=''){
            $('#sys_PopupShowCouponAction').modal('show');
            $('#sys_table_view_coupon').hide();
            $('#sys_view_msg_ok').html('');
            $('#sys_view_msg').html('');
            $('#sys_tr_infor_coupon').html('');
            $('#img_loading').show();
            var urlAjax = document.getElementById('sys_urlAjaxGetInforCouponAction').value;
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: {list_coupon : list_coupon,store_supplier_id : parseInt(store_supplier_id)},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading').hide();
                    if(res.intReturn === 1){
                        var rs = res.infor;
                        var html = "";
                        for( k in rs ) {
                            var coupon = rs[k].infor_coupon;
                            html += "<tr>";
                                html += "<td class='text-center'>";
                                    for( y in coupon ) {
                                        html += coupon[y]+"<div class='clear'></div>";
                                    }
                                html +"</td>";
                                html += "<td>" + rs[k].nameProduct + "</td>";
                                html += "<td class='text-center'>" + rs[k].total_coupon + "</td>";
                                html += "<td class='text-right'>" + rs[k].str_price + "</td>";
                                html += "<td class='text-right'>" + rs[k].str_total_price + "</td>";
                            html += "</tr>";
                        }

                        $('#str_total_money').html(res.str_total_money);
                        $('#total_money_pay').val(res.total_money_pay);
                        $('#money_in').val(res.str_total_money_pay);

                        $('#input_strListCoupon').val(res.strListCoupon);
                        if(res.total_money_pay > 0){
                            $('#show_total_money_order').show();
                            $('#show_total_money_order_2').show();
                            var action = 'onclick="Product.activeCouponCodeShopWithPopup('+res.store_supplier_id+',1)"';
                        }else{
                            var action = 'onclick="Product.activeCouponCodeShopWithPopup('+res.store_supplier_id+',2)"';
                        }
                        var button = '<a href="javascript:;" class="btn btn-black" id="sys_botton_action" style="height: 40px; background:black; color: #fff "';
                        button += action;
                        button +='>Kích hoạt coupon</a>';
                        $('#show_button_action_coupon').html(button);

                        $('#sys_table_view_coupon').show();
                        $('#sys_tr_infor_coupon').html(html);
                    }else{
                        $('#sys_view_msg').html(res.msg);
                    }
                }
            });
        }
    },
    activeCouponCodeShopWithPopup: function(store_supplier_id,type){
        var strListCoupon = document.getElementById('input_strListCoupon').value ;
        if(strListCoupon !='' && parseInt(store_supplier_id) > 0){
            if(parseInt(type) == 1){
                var money_in = $("#money_in").autoNumeric("get");
                var total_money_pay = document.getElementById('total_money_pay').value;
                if(parseInt(total_money_pay) > parseInt(money_in)){
                    alert('Bạn chưa nhập số tiền khách trả');
                    return false;
                }
            }
            if (confirm('Bạn có muốn kích hoạt các Coupon này?')) {
                var urlAjax = document.getElementById('sys_urlAjaxActiveCouponCodeShop').value ;
                $('#show_button_action_coupon').hide();
                $('#img_loading').show();
                $.ajax({
                    type: "POST",
                    url: urlAjax,
                    data: {strListCoupon: strListCoupon, store_supplier_id : parseInt(store_supplier_id)},
                    responseType: 'json',
                    success: function(data) {
                        $('#show_button_action_coupon').show();
                        $('#img_loading').hide();
                        if(data.intReturn == 1){
                            alert(data.msg);
                            window.location.reload();
                        }else if(data.intReturn == -1){
                            $('#sys_view_msg').html(data.msg);
                        }
                    }
                });
            }
        }
    },
};