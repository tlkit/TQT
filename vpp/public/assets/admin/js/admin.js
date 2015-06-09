var Admin = {
    deleteItem: function(id,type) {
        if(confirm('Bạn có muốn xóa Item này không?')) {
            $('#img_loading_'+id).show();

            if(type == 1){ //xoa NCC
               var url_ajax = WEB_ROOT + '/admin/providers/deleteItem';
            }
            else if(type == 2){ //xoa san pham
                var url_ajax = WEB_ROOT + '/admin/product/deleteItem';
            }
            else if(type == 3){ //xoa danh mục
                var url_ajax = WEB_ROOT + '/admin/categories/deleteItem';
            }
            $.ajax({
                type: "post",
                url: url_ajax,
                data: {id : id},
                dataType: 'json',
                success: function(res) {
                    $('#img_loading_'+id).hide();
                    if(res.isIntOk == 1){
                        alert('Bạn đã thực hiện thành công');
                        window.location.reload();
                    }else{
                        alert('Không thể thực hiện được thao tác.');
                    }
                }
            });
        }
    },
    changeOptionPersonnel: function(){
        var personnel_check_creater = $('#personnel_check_creater').val();
        if(parseInt(personnel_check_creater) == 1){
            $('#show_personnel_user_name').show();
        }else{
            $('#show_personnel_user_name').hide();
        }
    },
    updateCategoryCustomer: function(customer_id,category_id){
        $('#img_loading_'+category_id).show();
        var category_price_discount = $('#category_price_discount_id_'+category_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateCategory',
            data: {customer_id : customer_id, category_id:category_id, category_price_discount : category_price_discount},
            dataType: 'json',
            success: function(res) {
                $('#img_loading_'+category_id).hide();
                if(res.isIntOk == 1){
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                }else{
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    },
    updateProductCustomer: function(customer_id,product_id){
        $('#img_loading_'+product_id).show();
        var product_price_discount = $('#product_price_discount_id_'+product_id).val();
        $.ajax({
            type: "post",
            url: WEB_ROOT + '/admin/discountCustomers/updateProduct',
            data: {customer_id : customer_id, product_id:product_id, product_price_discount : product_price_discount},
            dataType: 'json',
            success: function(res) {
                $('#img_loading_'+product_id).hide();
                if(res.isIntOk == 1){
                    /*alert('Bạn đã thực hiện thành công');
                    window.location.reload();*/
                }else{
                    alert('Không thể thực hiện được thao tác.');
                }
            }
        });
    }
}