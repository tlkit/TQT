@foreach($products as $product)
    <div class="product-column" data-id="{{$product['product_id']}}">
        <div class="btn-danger" style="text-align: right;padding: 3px;background-color: #d9d9d9">
            <a href="javascript:void(0)" class="remove-box"><i class="ace-icon fa fa-remove bigger-110 white"></i></a>
        </div>
        <div style="width: 260px;height: 260px;margin-bottom: 10px">
            <img src="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 260, 260)}}" alt="{{$product['product_Name']}}">
        </div>
        <div style="width: 260px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap"><i><strong>{{$product['product_Name']}}</strong></i></div>
    </div>
@endforeach