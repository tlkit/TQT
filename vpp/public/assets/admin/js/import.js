/**
 * Created by Tuan on 03/06/2015.
 */
var restore = 0;
$(document).ready(function(){

    $('[data-rel=popover]').popover({container: 'body'});

    $('#providers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});

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

    $('#import_product_num').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

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
                        //response(data.product);
                        response($.map(data.product, function(item) {

                            return {
                                value: item.product_Name
                            }
                        }));
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
                $('[data-rel=popover]').popover({container: 'body'});
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


    $(".sys_open_delete").on('click', function () {
        restore = 0;
        var import_code = $(this).attr('data-code');
        $("#import_" + import_code).modal('show');
    });
    $(".sys_open_restore").on('click', function () {
        restore = 1;
        var import_code = $(this).attr('data-code');
        $("#import_" + import_code).modal('show');
    });
    $(".sys_delete_import").on('click',function(){
        var $this = $(this);
        var import_id = $(this).attr('data-id');
        var import_code = $(this).attr('data-code');
        var import_note = $("#import_note_" + import_code).val();
        var import_status = $("#import_status").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import/remove',
            data: {
                import_id: import_id,
                import_note: import_note,
                restore: restore
            },
            beforeSend: function () {
                $('.modal').modal('hide')
            },
            error: function () {
                bootbox.alert('Lỗi hệ thống');
            },
            success: function (data) {
                if(data.success == 1){
                    if(import_status == 1){
                        $this.parents('tr').html('');
                    }else{
                        console.log($this);
                        $this.parents('tr').addClass('orange bg-warning');
                        $this.parents('td').html('');

                    }
                    if(restore == 1){
                        window.location.href = data.link;
                        return false;
                    }
                }
                bootbox.alert(data.html);
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
    },
    removeItem:function(product_id){

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/import/removeProduct',
            data: {
                product_id: product_id
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                $('[data-rel=popover]').popover({container: 'body'});
                $("#sys_product_info").html(data.html);
            }
        });
    }
}
