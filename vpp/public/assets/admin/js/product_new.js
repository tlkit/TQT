/**
 * Created by tuann on 11/29/2016.
 */
$(document).ready(function(){
    $("#product_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getProductByName',
                data: {
                    product_name: $("#product_name").val()
                },
                beforeSend: function () {
                    //$('#sys_product_group_create').removeAttr('onclick');
                },
                complete: function () {
                    //$('#sys_product_group_create').attr('onclick', 'sales.showListProductSale();');
                },
                error: function () {
                },
                success: function (data) {
                    if (data.success) {
                        //response(data.product);
                        response($.map(data.product, function(item) {
                            return {
                                value: item.product_Name,
                                quantity: item.product_Quantity
                            }
                        }));
                    }
                }
            });
        },
        select: function( event, ui ) {
            $("#product_name").val(ui.item.value)
            $("#product_Quantity").val(ui.item.quantity);
            return false;
        }
        //minLength: 3
    });
});