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
                                id: item.product_id
                            }
                        }));
                    }
                }
            });
        },
        select: function( event, ui ) {
            $("#product_name").val(ui.item.value)
            $("#product_id").val(ui.item.id);
            return false;
        }
        //minLength: 3
    });
    $("#sys_add_product").on('click dbclick',function(){
        var product_id = parseInt($("#product_id").val());
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: WEB_ROOT + '/admin/getProductHotById',
            data: {
                product_id: product_id
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                if(data.success == 1){
                    $(".new_list").prepend(data.html)
                    $(".remove-box").on('click',function(e){
                        $(this).parents('.product-column').remove();
                        e.stopPropagation();
                    })
                }else{
                    bootbox.alert(data.mess)
                }
            }
        });
    });
    $(".remove-box").on('click',function(e){
        $(this).parents('.product-column').remove();
        e.stopPropagation();
    })
    $("#save_product_new").on('click dbclick',function(){
        var ids = [];
        $('.product-column').each(function () {
            ids.push(parseInt($(this).data('id')));
        });
        var object_id = parseInt($("#group_id").val());
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: WEB_ROOT + '/admin/addProductHot',
            data: {
                ids: ids.toString(),
                type:2,
                object_id:object_id

            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                if(data.success == 1){
                    //window.location.href = data.link
                    bootbox.alert('Lưu thành công !!!');
                }else{
                    bootbox.alert(res.mess);
                }
            }
        });
    });
    $("#group_id").on('change',function(){
        var object_id = parseInt($(this).val());
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: WEB_ROOT + '/admin/getProductHotByObject',
            data: {
                object_id: object_id
            },
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                if(data.success == 1){
                    $(".new_list").html(data.html)
                    $(".remove-box").on('click',function(e){
                        console.log('111');
                        $(this).parents('.product-column').remove();
                        e.stopPropagation();
                    })
                }else{
                    bootbox.alert(data.mess)
                }
            }
        });
    });
});