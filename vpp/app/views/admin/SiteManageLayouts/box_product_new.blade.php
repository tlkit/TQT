<div class="product-column" data-id="{{$product['product_id']}}">
    <div class="btn-danger" style="text-align: right;padding: 3px;background-color: #d9d9d9">
        <a href="javascript:void(0)" class="remove-box"><i class="ace-icon fa fa-remove bigger-110 white"></i></a>
    </div>
    <div style="width: 192px;height: 192px;margin-bottom: 10px">
        <img src="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 192, 192)}}" alt="{{$product['product_Name']}}">
    </div>
    <div style="width: 192px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><i><strong>{{$product['product_Name']}}</strong></i></div>
</div>