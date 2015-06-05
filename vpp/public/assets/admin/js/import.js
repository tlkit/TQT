/**
 * Created by Tuan on 03/06/2015.
 */
$(document).ready(function(){
    $('.chosen-select').chosen({allow_single_deselect:true});

    $("#providers_id").on('change', function () {
        var providers_id = $(this).val();
        if (parseInt(providers_id) > 0)
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: WEB_ROOT + '/admin/getProviderInfo',
                data: {
                    providers_id: providers_id
                },
                beforeSend: function () {
                    //$("#sys_provider_info").addClass('hidden');
                    $("#sys_provider_info").hide();
                    $("#sys_load").show();
                },
                error: function () {
                    $("#sys_provider_info").html('');
                },
                success: function (data) {
                    $("#sys_load").fadeOut(555, function () {
                        $("#sys_provider_info").html(data.html);
                        $("#sys_provider_info").fadeIn(1111);
                    });
                }
            });
        else
            $("#sys_provider_info").hide(1111);
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
                        response(data.product);
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
        var name = $("#product_name").val();
        var price = $("#input_import_product_price").val();
        var num = $("#import_product_num").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import/addProduct',
            data: {
                name: name,
                price: price,
                num: num
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {

                $("#sys_product_info").html(data.html);
                if (data.success == 1) {
                    $("#product_name").val('');
                    $("#input_import_product_price").val(0);
                    $("#import_product_price").val('');
                    $("#import_product_num").val('');

                }
            }
        });
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
