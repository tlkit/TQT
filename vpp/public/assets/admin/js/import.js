/**
 * Created by Tuan on 03/06/2015.
 */
$(document).ready(function(){
    $('.chosen-select').chosen({allow_single_deselect:true});

    $("#providers_id").on('change',function(){
        console.log($(this).val());
    });
    $("#import_product_price").on('keyup', function (event) {
        Import.fomatNumber('import_product_price');
    });

    $("#product_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getProductByName',
                data: {},
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
                        console.log(data.product);
                        response(data.product);;
                        //response($.map(data.product, function(item) {
                        //
                        //    return {
                        //        label: item,
                        //        value: 1
                        //    }
                        //}));
                    }
                }
            });
        }
        //minLength: 3
    });

    $("#sys_add_product").on('click',function(){
        console.log($("#product_name").val());
    })

});

var Import = {
    fomatNumber:function (id) {
        var re = parseInt(parseInt($("#" + id).val().replace(/\./g, ''))) || 0;
        if (re > 1000000000) {
            re = 1000000000;
        }
        jQuery('#input_' + id).val(re);
        number.numberFormatNew(re, id);
    }
}
