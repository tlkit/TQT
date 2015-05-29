/**
 * Created by ChungDuc on 7/23/14.
 */
var sendingAjax = false;
var objStorage = localStorage.getItem("objDataProduct");
var From_Validate = {
    config: {
        listProduct: null
    },
    displayValError: function(id, mess,scrollToElement){
        this.disableValError(id);
        $('#'+id).css({'border':'1px solid red'}).focus().parent().append('<div id="clear" style="clear: both"></div><span id="show-error" style="color:#f00;font-size:11px">' + mess + '</span>');
        if(scrollToElement == undefined || scrollToElement == true) {
            var top = $('#'+id).offset().top;
            $("html, body").animate({ scrollTop: top-80 }, 500);
        }
    },

    disableValError: function(id){
        $('#'+id).css({'border':''});
        $('#show-error').remove();
    },

    shop_login: function(id) {
        var username = $('#sys_shop_username').val();
        var password = $('#sys_shop_password').val();
        if(username == '') {
            this.displayValError('sys_shop_username', 'Tên đăng nhập không được trống.');
            return false;
        }
        if(password == '') {
            this.displayValError('sys_shop_password', 'Mật khẩu không được trống.');
            return false;
        } else if(password.length < 6) {
            this.displayValError('sys_shop_password', 'Mật khẩu không được nhỏ hơn 6 ký tự.');
            return false;
        }
        return true;
    },

    valid_register: function(fullname, email, phone) {
        if (fullname == '' || fullname == undefined) {
            this.displayValError('sys_reg_name', 'Bạn chưa nhập tên khách hàng.', false);
            return false;
        }else{
            this.disableValError('sys_reg_name');
        }
        if (phone == '' || phone == undefined) {
            this.displayValError('sys_reg_phone', 'Bạn chưa nhập số điện thoại.', false);
            return false;
        } else if(!LibJS.is_phone(phone)) {
            this.displayValError('sys_reg_phone', 'Số điện thoại di động chưa đúng định dạng.', false);
            return false;
        } else {
            this.disableValError('sys_reg_phone');
        }
        if (email == '' || email == undefined) {
            this.displayValError('sys_reg_email', 'Bạn chưa nhập email.', false);
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_reg_email', 'Email chưa đúng định dạng.', false);
            return false;
        } else {
            this.disableValError('sys_reg_email');
        }
        return true;
    },

    valid_forget: function(email) {
            if (email == '' || email == undefined) {
                this.displayValError('sys_forget_email', 'Bạn chưa nhập email.', false);
                return false;
            } else if (!LibJS.is_mail(email)) {
                this.displayValError('sys_forget_email', 'Email chưa đúng định dạng.', false);
                return false;
            }
            return true;
        },

    /*********************************************************************************************************
     * QuynhTM add cho phàn đăng nhập đăng ký Customer
     * *******************************************************************************************************
     */
    valid_register_page_customer: function(fullname, email, phone) {
        if (fullname == '' || fullname == undefined) {
            this.displayValError('sys_customer_name', 'Bạn chưa nhập tên khách hàng.', false);
            return false;
        }else{
            this.disableValError('sys_customer_name');
        }

        if (phone == '' || phone == undefined) {
            this.displayValError('sys_customer_phone', 'Bạn chưa nhập số điện thoại.', false);
            return false;
        } else if(!LibJS.is_phone(phone)) {
            this.displayValError('sys_customer_phone', 'Số điện thoại di động chưa đúng định dạng.', false);
            return false;
        }else{
            this.disableValError('sys_customer_phone');
        }


        if (email == '' || email == undefined) {
            this.displayValError('sys_customer_email', 'Bạn chưa nhập email.', false);
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_customer_email', 'Email chưa đúng định dạng.', false);
            return false;
        }else{
            this.disableValError('sys_customer_email');
        }

        return true;
    },

    customer_page_login: function(email, password) {
        if (email == '' || email == undefined) {
            this.displayValError('sys_customer_login_email', 'Bạn chưa nhập email.', false);
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_customer_login_email', 'Email chưa đúng định dạng.', false);
            return false;
        }else{
            this.disableValError('sys_customer_login_email');
        }
        if (password == '' || password == undefined) {
            this.displayValError('sys_password_customer_login', 'Mật khẩu không được để trống.', false);
            return false;
        }else{
            this.disableValError('sys_password_customer_login');
        }
        return true;
    },

    valid_verify_account_page_customer: function(email, password) {
        if (email == '' || email == undefined) {
            this.displayValError('sys_reg_email_customer_verify', 'Bạn chưa nhập email.');
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_reg_email_customer_verify', 'Email chưa đúng định dạng.');
            return false;
        }else{
            this.disableValError('sys_reg_email_customer_verify');
        }

        if (password == '' || password == undefined) {
            this.displayValError('sys_reg_password_customer_verify', 'Mật khẩu không được để trống.');
            return false;
        }else{
            this.disableValError('sys_reg_password_customer_verify');
        }

        return true;
    },
    /*******************************************************************************************************
     * End QuynhTM
     * *****************************************************************************************************
     */


    valid_verify_account: function(email, password) {
        if (email == '' || email == undefined) {
            this.displayValError('sys_reg_email_verify', 'Bạn chưa nhập email.');
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_reg_email_verify', 'Email chưa đúng định dạng.');
            return false;
        }
        if (password == '' || password == undefined) {
            this.displayValError('sys_reg_password', 'Mật khẩu không được để trống.');
            return false;
        }

        return true;
    },

    customer_login: function(email, password) {
        if (email == '' || email == undefined) {
            this.displayValError('sys_email', 'Bạn chưa nhập email.', false);
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_email', 'Email chưa đúng định dạng.', false);
            return false;
        }
        if (password == '' || password == undefined) {
            this.displayValError('sys_pass', 'Mật khẩu không được để trống.', false);
            return false;
        }
        return true;
    },

    customer_login_popup:function (email, password) {
        if (email == '' || email == undefined) {
            this.displayValError('sys_email_popup', 'Bạn chưa nhập email.', false);
            return false;
        } else if (!LibJS.is_mail(email)) {
            this.displayValError('sys_email_popup', 'Email chưa đúng định dạng.', false);
            return false;
        }
        if (password == '' || password == undefined) {
            this.displayValError('sys_pass_popup', 'Mật khẩu không được để trống.', false);
            return false;
        }

        return true;

    },

    product_shop: function() {
        if(!sendingAjax){
            $("#sys_button_submit").addClass("disabled");
            sendingAjax = true;
            //move các thông tin khi goi lại ham này
            this.disableValError('products_name');
            this.disableValError('products_prices');

            var image = $('#products_images').val();
            var checkUpload = $('#products_images_key_upload').val();
            var title = $('#products_name').val();
            var price = $('#products_prices').val();
            var category_id = $('#sys_category_id').val();
            if (title == '' || title == undefined) {
                this.displayValError('products_name', 'Tiêu đề sản phẩm không được trống.');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }
            if (category_id == 0 || category_id == undefined) {
                this.displayValError('sys_category_id', 'Bạn hãy chọn danh mục sản phẩm.');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }
            /*if ((parseInt(checkUpload) == -1 || checkUpload == undefined) && image == '') {
                alert('Bạn chưa up ảnh sản phẩm.');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }else if (image == '' || image == undefined) {
                alert('Bạn chọn ảnh upload làm ảnh đại diện sản phẩm.');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }*/
            if (price == '' || price == undefined) {
                this.displayValError('products_prices', 'Bạn chưa nhập giá sản phẩm.');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }
            else{
                var number_price =$("#products_prices").autoNumeric("get");

                $("#products_prices_hide").val($("#products_prices").autoNumeric("get"));
            }
            localStorage.removeItem("objDataProduct");
            return true;
        }else{
            alert("Quá trình xử lý đang được thực hiện!");
            return false;
        }
    },

    sales_valid: function() {
        var product_price_sale = $('#product_price_sale').val(),
            product_percent_discount = $('#product_percent_discount').val(),
            product_order_limit_sale =  $('#sys_product_order_limit_sale').val() ,
            product_store_quantity_total =  $('#sys_product_store_quantity_total').val() ,
            sys_campaign_location_hn = $("#sys_campaign_location_hn").is(':checked') ? 1 : 0,
            sys_campaign_location_hcm = $("#sys_campaign_location_hcm").is(':checked') ? 1 : 0,
            sys_campaign_location_dn = $("#sys_campaign_location_dn").is(':checked') ? 1 : 0,
            product_start_time = $("#product_start_time").val(),
            product_end_time = $("#product_end_time").val(),
            apply_service_start_time = $("#apply_service_start_time").val(),
            apply_service_end_time = $("#apply_service_end_time").val(),

            sys_product_type = $("#sys_product_type").val();

        if(product_price_sale == '') {
            this.displayValError('product_price_sale', 'Giá bán sản phẩm không được trống.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(product_percent_discount == '') {
            this.displayValError('product_percent_discount', '% giảm giá không được trống.');
            $('#sys_update').attr('disabled', false);
            return false;
        }else if(product_percent_discount <= 0) {
            this.displayValError('product_percent_discount', '% giảm giá không được nhỏ hơn hoặc bằng 0.');
            $('#sys_update').attr('disabled', false);
            return false;
        }

        if(product_order_limit_sale == '') {
            this.displayValError('sys_product_order_limit_sale', 'Số lượng tối đa 1 lần mua không được trống.');
            $('#sys_update').attr('disabled', false);
            return false;
        } else if(parseInt(product_order_limit_sale) < 1) {
            this.displayValError('sys_product_order_limit_sale', 'Số lượng tối đa 1 lần mua không được nhỏ hơn 1.');
            $('#sys_update').attr('disabled', false);
            return false;
        }

        if(product_store_quantity_total == '') {
            this.displayValError('sys_product_store_quantity_total', 'Số lượng đăng ký bán không được trống.');
            $('#sys_update').attr('disabled', false);
            return false;
        } else if(parseInt(product_store_quantity_total) < 1) {
            this.displayValError('sys_product_store_quantity_total', 'Số lượng đăng ký bán không được nhỏ hơn 1.');
            $('#sys_update').attr('disabled', false);
            return false;
        }

        if(sys_campaign_location_hn == 0 && sys_campaign_location_hcm == 0 && sys_campaign_location_dn == 0) {
            alert('Bạn hãy chọn khu vực hiển thị');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(product_start_time == '') {
            this.displayValError('product_start_time', 'Bạn hãy chọn thời gian bắt đầu.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        if(product_end_time == '') {
            this.displayValError('product_end_time', 'Bạn hãy chọn thời gian kết thúc.');
            $('#sys_update').attr('disabled', false);
            return false;
        }

        if(product_start_time == product_end_time) {
            alert('Thời gian bắt đầu và kết thúc hiển thị trên site không được bằng nhau.');
            return false;
        }

        if(sys_product_type == 1) {
            if(apply_service_start_time == '') {
                this.displayValError('apply_service_start_time', 'Bạn hãy chọn thời gian bắt đầu áp dụng dịch vụ.');
                $('#sys_update').attr('disabled', false);
                return false;
            }
            if(apply_service_end_time == '') {
                this.displayValError('apply_service_end_time', 'Bạn hãy chọn thời gian kết thúc áp dụng dịch vụ.');
                $('#sys_update').attr('disabled', false);
                return false;
            }
            if(product_start_time == product_end_time) {
                alert('Thời gian bắt đầu và kết thúc của phiếu không được bằng nhau.');
                return false;
            }

            var timestampServiceStart = new Date(apply_service_start_time).getTime();
            var timestampProductEnd = new Date(product_start_time).getTime();

            if(timestampServiceStart < timestampProductEnd) {
                alert("Ngày bắt đầu sử dụng dịch vụ không được nhỏ hơn ngày bắt đầu trên site");
                $('#sys_update').attr('disabled', false);
                return false;
            }
        }
        localStorage.removeItem("objDataProduct");
        $('#sys_update').attr('disabled', true);
        $('#sys_button_submit').submit();
        return true;
    },


    group_valid: function() {
        var product_group_name = $('#product_group_name').val();
        if(product_price_sale == '') {
            this.displayValError('product_group_name', 'Tên nhóm sản phẩm không được trống.');
            $('#sys_update').attr('disabled', false);
            return false;
        }
        var statusCheck = false;
        for(var i=0; i<From_Validate.config.listProduct.length; i++) {
            var product_sale_id = From_Validate.config.listProduct[i];
            if($("#chk_product_sale_" + product_sale_id).is(':checked')) {
                var statusCheck = true;
            }
        }
        if(statusCheck) {
            alert('Bạn vui lòng chọn ít nhất một sản phẩm cho nhóm.');
        }
        $('#sys_update').attr('disabled', true);
        $('#sys_button_submit').submit();
        return true;
    },

    detectPercent: function(price_sale) {
        price = $('#sys_product_price').val();
        price_sale = parseInt(price_sale.replace(/[., đ]/g, ''));
        price = parseInt(price.replace(/[., đ]/g, ''));

        if(price > 0 && price_sale > 0 && price_sale < price ) {
            var percent_discount = ( Math.round(100 - ((price_sale/price)*100)) );
            console.log(percent_discount);
            $('#product_percent_discount').val(percent_discount);
            //Them vao local storage
            objStorage.product_percent_discount=percent_discount;
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        } else if(price_sale >= price ) {
            alert('Giá bán không được lớn hơn hoặc bằng giá niêm yết.');
            $('#product_price_sale').val(0);
            $('#product_percent_discount').val(100);
        }
    },

    validPercent: function(price_discount) {
        if (isNaN(price_discount))
        {
            alert("Giá trị % giảm phải là kiểu số.");
            $('#product_percent_discount').val(0);
        } else if(price_discount <= 0) {
            alert("Giá trị % giảm không được nhỏ hơn hoặc bằng 0.");
            $('#product_percent_discount').val(0);
        }else if(price_discount > 100) {
            alert("Giá trị % giảm không được lớn hơn 100.");
            $('#product_percent_discount').val(0);
        }
    },
    product_hot: function() {
        if(!sendingAjax){
            $("#sys_button_submit").addClass("disabled");
            sendingAjax = true;
            //move các thông tin khi goi lại ham này
            this.disableValError('product_hot_time_start');
            this.disableValError('product_hot_time_end');

            var time_start = $('#product_hot_time_start').val();
            if (time_start == '' || time_start == undefined) {
                this.displayValError('product_hot_time_start', 'Bạn phải chọn thời gian bắt đầu cho sản phẩm hot');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }
            var time_end = $('#product_hot_time_end').val();
            if (time_end == '' || time_end == undefined) {
                this.displayValError('product_hot_time_end', 'Bạn phải chọn thời gian kết thúc cho sản phẩm hot');
                $("#sys_button_submit").removeClass("disabled");
                sendingAjax = false;
                return false;
            }

            localStorage.removeItem("objDataProduct");
            return true;
        }else{
            alert("Quá trình xử lý đang được thực hiện!");
            return false;
        }
    },
}

