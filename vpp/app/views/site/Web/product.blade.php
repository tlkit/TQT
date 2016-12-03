<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="{{URL::route('site.cate',array('gid' => $group['group_category_id'],'id' => $category['categories_id'],'name' => FunctionLib::safe_title($category['categories_Name'])))}}">{{$category['categories_Name']}}</a>
            </div>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">{{$product['product_Name']}}</a>
            </div>
        </div>
        <div class="cl make-left">
            @if($productHot)
                <div class="box-left clearfix mt-30">
                    <div class="box-left-title">
                        Sản phẩm hot
                    </div>
                    <div class="slide-hot" style="margin-top: 20px">
                        @foreach($productHot as $k => $v)
                            <div class="deal-dx clearfix">
                                <div class="dx-image make-left">
                                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                        <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 80, 80)}}" alt="{{$v["product_Name"]}}">
                                    </a>
                                </div>
                                <div class="dx-des make-left">
                                    <div class="dx-title">
                                        <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a>
                                    </div>
                                    <?php $rate = rand(3,5);?>
                                    <div class="rate-deal">
                                        @for($i = 1;$i <= 5;$i++)
                                            <i class="icons iRate @if( $i <= $rate) checked @endif"></i>
                                        @endfor
                                    </div>
                                    <div class="price-deal">
                                <span class="price-dx-deal">
                                    {{number_format($v['product_Price'],0,'.','.')}}<span>đ</span>
                                </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($productTag)
                <div class="box-left clearfix mt-30">
                    <div class="box-left-title">
                        Từ khóa nổi bật
                    </div>
                    <div class="box-tag clearfix">
                        @foreach($productTag as $k => $v)
                            <div class="tag-content make-left"><a href="{{URL::route('site.tag',array('id' => $v["product_sort_id"],'name' => FunctionLib::safe_title($v["product_sort_label"])))}}">{{$v["product_sort_label"]}}</a></div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="cr make-right bg">
            <div class="container-detail clearfix">
                <div class="box-img make-left">
                    <div class="wrap-img clearfix">
                        <img src="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 340, 340)}}" alt="{{$product['product_Name']}}">
                    </div>
                    <div class="list-img">
                        <img src="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 60, 60)}}" data-img="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 340, 340)}}" alt="{{$product['product_Name']}}">
                        <?php $aryImage = json_decode($product['product_Image'],true);?>
                        @if($aryImage)
                            @foreach($aryImage as $image)
                                <img src="{{Croppa::url(Constant::dir_product.$image,60,60)}}" data-img="{{Croppa::url(Constant::dir_product.$image, 340, 340)}}" alt="{{$product['product_Name']}}">
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="box-content make-left">
                    <div class="title-product">{{$product['product_Name']}}</div>
                    <div class="clearfix">
                        <?php $rate = rand(3,5);?>
                        <div class="rate-deal make-left">
                            @for($i = 1;$i <= 5;$i++)
                                <i class="icons iRate @if( $i <= $rate) checked @endif"></i>
                            @endfor
                        </div>
                        {{--<div class="make-left rate-num">(13 lượt đánh giá)</div>--}}
                    </div>
                    <div class="lbl-product">Mã sản phẩm: <span class="fc-grey-4">{{$product['product_Code']}}</span></div>
                    <div class="lbl-product">Tình trạng: <i class="icons iOn"></i> <span class="fs-14 fc-green-1 txt-uppercase fb">Còn hàng</span></div>
                    @if($product['product_bulk_quantity'] > 0)
                        <div class="lbl-price-bulk">SL bán buôn: {{$product['product_bulk_quantity']}} & nhiều hơn</div>
                        @if($product['product_bulk_price'] > 0)
                            <div class="lbl-price-bulk">Giá bán buôn: {{number_format($product['product_bulk_price'],0,'.','.')}}  (Tiết kiệm: {{ceil(($product['product_Price'] - $product['product_bulk_price'])/$product['product_Price']*100)}}%)</div>
                        @endif
                    @endif
                    <div class="product-price-sale">{{number_format($product['product_Price'],0,'.','.')}}<span>đ</span></div>
                    <div>
                        <div class="product-number make-left">
                            <label for="">Số lượng :   </label>
                            <input type="text" value="1" size="2" name="quantity[{{$product['product_id']}}]" id="qty">
                        </div>
                        <div class="btn btn-detail-muangay make-left ml-20 btn_add_cart" data-id="{{$product['product_id']}}">
                            <i class="wrap-icon"><i class="icons iCart2"></i></i>
                            Thêm vào giỏ
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="tab-pane make-left">
                    <div class="tab-label active">
                        Mô tả chi tiết
                        <i class="icons iRight"></i>
                    </div>
{{--                    <div class="tab-label">
                        Đánh giá
                        <i class="icons iRight"></i>
                    </div>
                    <div class="tab-label">
                        Bình luận
                        <i class="icons iRight"></i>
                    </div>--}}
                </div>
                <div class="tab-content make-left">
                    <div id="clearfix">
                        {{$product['product_Description']}}
                    </div>
                </div>
            </div>
        </div>
        @if($productRelate)
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Có thể bạn quan tâm</div>
                </div>
                <div class="box-product-new clearfix">
                    <div class="slide-hott">
                        @foreach($productRelate as $k => $v)
                        <div class="product-column make-left">
                            <div class="wrap-img">
                                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                    <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 192, 192)}}" alt="" align="middle">
                                </a>
                                <div class="hover-cart btn_add_cart" data-id="{{$v["product_id"]}}">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart" data-id="{{$v["product_id"]}}"></i>
                                </div>
                            </div>
                            <div class="product-des">
                                <div class="product-title">
                                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a>
                                </div>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($productView)
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Sản phẩm bạn đã xem</div>
                </div>
                <div class="box-product-new clearfix">
                    <div class="slide-hott">
                        @foreach($productView as $k => $v)
                        <div class="product-column make-left">
                            <div class="wrap-img">
                                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                    <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 192, 192)}}" alt="{{$v["product_Name"]}}" align="middle">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#qty').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        $(".slide-hott").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-hot").slick({
            //rows:3,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            vertical: true,
            verticalSwiping: true,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
    })
</script>