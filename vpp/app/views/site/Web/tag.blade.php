<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">{{$tag['product_sort_label']}}</a>
            </div>
        </div>
        <div id="banner-event" class=" make-left clearfix">
            <a href="javascript:void(0)">
                <img src="{{Croppa::url(Constant::dir_banner.$tag['product_sort_banner'], 1170)}}" alt="{{$tag['product_sort_label']}}">
            </a>
        </div>
        <div class="full-width make-right bg mt-30">
            <div class="container-list clearfix">
                <div class="list-product-grid">
                    @foreach($product as $k => $v)
                    <div class="product-box make-left">
                        <div class="wrap-img make-left">
                            <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 260, 260)}}" alt="{{$v["product_Name"]}}">
                            </a>
                            <div class="hover-cart btn_add_cart" data-id="{{$v["product_id"]}}">
                                <i class="icons iCart3"></i>
                            </div>
                            <div class="hover-like" data-id="{{$v["product_id"]}}">
                                <i class="icons iHeart"></i>
                            </div>
                        </div>
                        <div class="box-description make-left">
                            <div class="title-deal"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}"></a>{{$v["product_Name"]}}</div>
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
                            @if($v['product_bulk_quantity'] > 0)
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>{{$v['product_bulk_quantity']}} hoặc nhiều hơn</b></div>
                                @if($v['product_bulk_price'] > 0)
                                    <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>{{number_format($v['product_bulk_price'],0,'.','.')}}</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>