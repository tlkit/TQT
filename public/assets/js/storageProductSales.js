var objStorage = localStorage.getItem("objDataProductSales");
localStorage.removeItem("objDataProductSales");
$(function(){
    if(statusStorageSale == 1) {
        if(objStorage) {
            objStorage=JSON.parse(objStorage);
//            $("#product_price_sale").val(objStorage.product_price_sale);
//            $("#product_percent_discount").val(objStorage.product_percent_discount);
//            $("#sys_product_order_limit_sale").val(objStorage.product_order_limit_sale);
//            if(objStorage.campaign_location_hn == 1) {
//                $("#sys_campaign_location_hn").attr('checked', 'checked');
//            }
//            if(objStorage.campaign_location_hcm == 1) {
//                $("#sys_campaign_location_hcm").attr('checked', 'checked');
//            }
//            $('#sys_product_sale_status').val(objStorage.product_sale_status).prop('selected', true);
//            $("#product_start_time").val(objStorage.product_start_time);
//            $("#sales_start_time_hour").val(objStorage.sales_start_time_hour);
//            $("#product_end_time").val(objStorage.product_end_time);
//            $("#sales_end_time_hour").val(objStorage.sales_end_time_hour);
//            $("#apply_service_start_time").val(objStorage.apply_service_start_time);
//            $("#apply_service_start_hour").val(objStorage.apply_service_start_hour);
//            $("#apply_service_end_time").val(objStorage.apply_service_end_time);
//            $("#apply_service_end_hour").val(objStorage.apply_service_end_hour);
//            for(var j=0; j<objStorage.store_supplier.length; j++) {
//                $("#store_supplier_"+j).val(objStorage.store_supplier[j]);
//            }
        }else{
            objStorage={
                product_price_sale:"",
                product_percent_discount:"",
                product_order_limit_sale:"",
                campaign_location_hn:"",
                campaign_location_hcm:"",
                product_sale_status:1,
                product_start_time:"",
                sales_start_time_hour:"",
                product_end_time:"",
                sales_end_time_hour:"",
                apply_service_start_time:"",
                apply_service_start_hour:"",
                apply_service_end_time:""
            };
        }
    }

    $("#product_price_sale").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_price_sale=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#product_percent_discount").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_percent_discount=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#sys_product_order_limit_sale").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_order_limit_sale=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });

    $("#sys_campaign_location_hn").on("click",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            if($("#sys_campaign_location_hn").is(":checked")) {
                objStorage.campaign_location_hn = 1;
            } else {
                objStorage.campaign_location_hn = 0;
            }
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });

    $("#sys_campaign_location_hcm").on("click",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            if($("#sys_campaign_location_hcm").is(":checked")) {
                objStorage.campaign_location_hcm = 1;
            } else {
                objStorage.campaign_location_hcm = 0;
            }
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });

    $("#sys_product_sale_status").on("change",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_sale_status=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#product_start_time").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_start_time=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#sales_start_time_hour").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.sales_start_time_hour=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#product_end_time").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.product_end_time=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#sales_end_time_hour").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.sales_end_time_hour=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#apply_service_start_time").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.apply_service_start_time=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#apply_service_start_hour").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.apply_service_start_hour=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#apply_service_end_time").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.apply_service_end_time=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
    $("#apply_service_end_hour").on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            objStorage.apply_service_end_hour=$thisText.val();
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });

    $('.list_amount_supplier').on("keyup",function(){
        var $thisText = $(this);
        delaySomethings(function(){
            var arrAmountStore = [];
            for(var i=0; i<storeSupplier.length; i++) {
                arrAmountStore[storeSupplier[i].store_supplier_id] = $('#store_supplier_'+storeSupplier[i].store_supplier_id).val();
                console.log(arrAmountStore);
            }
            objStorage.store_supplier=arrAmountStore;
            localStorage.setItem("objDataProductSales",JSON.stringify(objStorage));
        },0);
    });
});