@if($productNew)
    @foreach($productNew as $k => $v)
        @if($k < 4)
            <div class="product-column make-left">
                <div class="wrap-img">
                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                        <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 192, 192)}}" alt="{{$v["product_Name"]}}" alt="" align="middle">
                    </a>
                    <div class="hover-cart">
                        <i class="icons iCart3"></i>
                    </div>
                    <div class="hover-like">
                        <i class="icons iHeart"></i>
                    </div>
                </div>
                <div class="product-des">
                    <div class="product-title"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
                    <?php $rate = rand(3,5);?>
                    <div class="rate-deal">
                        @for($i = 1;$i <= 5;$i++)
                            <i class="icons iRate @if( $i <= $rate) checked @endif"></i>
                        @endfor
                    </div>
                    <div class="price-deal">
                                        <span class="price-sale-deal">
                                            {{number_format($v['product_Price'],0,'.','.')}}<span>đ</span>
                                        </span>
                        {{--<span class="price-original-deal pl-20">
                            1.900.000<span>đ</span>
                        </span>--}}
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif