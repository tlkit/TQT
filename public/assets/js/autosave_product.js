
var objStorage = localStorage.getItem("objDataProduct");

function setDataStorage(product_short_desc, product_desc) {
    CKEDITOR.instances.product_extra_short_desc.setData(product_short_desc);
    CKEDITOR.instances.product_extra_desc.setData(product_desc);
}
CKEDITOR.instances.product_extra_short_desc.on('key', function (e) {
    delaySomethings(function(){
        objStorage.product_extra_short_desc = CKEDITOR.instances.product_extra_short_desc.getData();;
        localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
    },500);
});
CKEDITOR.instances.product_extra_desc.on('key', function (e) {
    delaySomethings(function(){
        objStorage.product_extra_desc = CKEDITOR.instances.product_extra_desc.getData();;
        localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
    },500);
});
localStorage.removeItem("objDataProduct");
$(function(){
    if(statusStorage == 1) {
        if(objStorage) {
            objStorage=JSON.parse(objStorage);
//            $("#products_name").val(objStorage.products_name);
//            $('#sys_category_id').val(objStorage.category_id).prop('selected', true);
//            $("#products_prices").val(objStorage.products_prices);
//            $('#sys_product_type').val(objStorage.product_type).prop('selected', true);
//            setDataStorage(objStorage.product_extra_short_desc, objStorage.product_extra_desc);
        }else{
            objStorage={
                products_name:"",
                category_id:0,
                product_extra_short_desc:"",
                product_extra_desc:"",
                products_prices:"",
                product_type: 1
            };
        }
        $("#products_name").on("keyup",function(){
            var $thisText = $(this);
            delaySomethings(function(){
                objStorage.products_name=$thisText.val();
                localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
            },0);
        });
        $("#sys_category_id").on("change",function(){
            var $thisText = $(this);
            delaySomethings(function(){
                objStorage.category_id=$thisText.val();
                localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
            },0);
        });
        $("#product_extra_desc").on("keyup",function(){
            var $thisText = $(this);
            delaySomethings(function(){
                objStorage.product_extra_desc = getDataDesc();
                localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
            },500);
        });
        $("#products_prices").on("keyup",function(){
            var $thisText = $(this);
            delaySomethings(function(){
                objStorage.products_prices=$thisText.val();
                localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
            },0);
        });
        $("#sys_product_type").on("change",function(){
            var $thisText = $(this);
            delaySomethings(function(){
                objStorage.product_type=$thisText.val();
                localStorage.setItem("objDataProduct",JSON.stringify(objStorage));
            },0);
        });
    }

    $("#deleteDraft").on("click",function(){
        localStorage.removeItem("objDataProduct");
    });
});


