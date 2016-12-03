@if($cart)
    <?php $sub_total = 0;?>
    @foreach($cart as $k => $v)
        <div class="cart-item clearfix mb-20 row_{{$v['product_id']}}">
            <div class="wrap-img make-left">
                <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                    <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 60, 60)}}"></a>
                </a>
            </div>
            <div class="cart-item-des make-left ml-10">
                <div class="cart-item-title"><a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a></div>
                <div class="price-cart-item">
                                <span class="price-dx-deal">
                                    {{number_format($v['product_price_buy'],0,'.','.')}}<span>đ</span>
                                </span>
                </div>
                <i class="icons iTrack sys_remove" data-id="{{$v['product_id']}}"></i>
            </div>
        </div>
        <?php
        $sub_total += $v['product_price_buy']*$v['product_num']
        ?>
    @endforeach
    <div class="divider"></div>
    <div class="cart-total mb-20">
        Tạm tính : <span class="price sys_total_order">{{number_format($sub_total,0,'.','.')}}<span>đ</span></span>
    </div>
    <div class="cart-view">
        <a href="{{URL::route('cart.checkout_cart')}}" class="btn-view-cart">Xem giỏ hàng</a>
    </div>
@else
    <div>Không có sản phẩm nào trong giỏ hàng !!!</div>
@endif