<div id="page-content">
    <div class="container clearfix">
        @if($banner)
            <div id="banner" class="mt-20 make-left clearfix">
                @foreach($banner as $ban)
                    <a href="{{$ban['banner_url']}}">
                        <img src="{{Croppa::url(Constant::dir_banner.$ban['banner_image'], 1170, 367)}}" alt="{{$ban['banner_name']}}">
                    </a>
                @endforeach
            </div>
        @endif
        <div class="cl make-left mt-20">
            @if($productKm)
            <div class="box-left clearfix">
                <div class="box-left-title">
                    Khuyến mại
                </div>
                <div class="slide-deal-km clearfix">
                    @foreach($productKm as $k => $v)
                    <div class="box-deal mt-20 clearfix">
                        <div class="wrap-img clearfix">
                            <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 225, 225)}}" alt="{{$v["product_Name"]}}">
                            </a>
                        </div>
                        <div class="box-countdown sys_countdown" data-times="{{date('Y',$v['product_landing_end'])}},{{date('m',$v['product_landing_end'])}},{{date('d',$v['product_landing_end'])}},{{date('H',$v['product_landing_end'])}},{{date('i',$v['product_landing_end'])}},{{date('s',$v['product_landing_end'])}}"></div>
                        <div class="box-description">
                            <div class="title-deal">
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
{{--                                <span class="price-original-deal pl-20">
                                    1.900.000<span>đ</span>
                                </span>--}}
                            </div>
                            <div class="btn btn-muangay mb-20 btn_add_cart" id="" data-id="{{$v["product_id"]}}">
                                <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                Thêm vào giỏ
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <div class="box-left clearfix mt-30">
                <div class="box-left-title">
                    Đề xuất
                </div>
                <div class="deal-dx clearfix">
                    <div class="dx-image make-left">
                        <a href=""><img src="{{asset('assets/site/image/product-2.png', false)}}" alt=""></a>
                    </div>
                    <div class="dx-des make-left">
                        <div class="dx-title"><a href="">Máy in giấy Deli387</a></div>
                        <div class="rate-deal">
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate"></i>
                        </div>
                        <div class="price-deal">
                                <span class="price-dx-deal">
                                    900.000<span>đ</span>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="deal-dx clearfix">
                    <div class="dx-image make-left">
                        <a href=""><img src="{{asset('assets/site/image/product-2.png', false)}}" alt=""></a>
                    </div>
                    <div class="dx-des make-left">
                        <div class="dx-title"><a href="">Máy in giấy Deli387</a></div>
                        <div class="rate-deal">
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate"></i>
                        </div>
                        <div class="price-deal">
                                <span class="price-dx-deal">
                                    900.000<span>đ</span>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="deal-dx clearfix">
                    <div class="dx-image make-left">
                        <a href=""><img src="{{asset('assets/site/image/product-2.png', false)}}" alt=""></a>
                    </div>
                    <div class="dx-des make-left">
                        <div class="dx-title"><a href="">Máy in giấy Deli387</a></div>
                        <div class="rate-deal">
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate checked"></i>
                            <i class="icons iRate"></i>
                        </div>
                        <div class="price-deal">
                                <span class="price-dx-deal">
                                    900.000<span>đ</span>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="dx-xemthem">
                    <a href="">Xem thêm <i class="icons iDown2"></i></a>
                </div>
            </div>
            <div class="box-left clearfix mt-30">
                <div class="box-left-title">
                    Từ khóa nổi bật
                </div>
                <div class="box-tag clearfix">
                    <div class="tag-content make-left"><a href="">fđfd dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd5656 dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd 656565 dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd 565656 dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd  6565656 5656dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd6565 dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd 65656 dgdg</a></div>
                    <div class="tag-content make-left"><a href="">fđfd 66 dgdg</a></div>
                </div>
            </div>
        </div>
        <div class="cr make-right mt-20">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Sản phẩm mới</div>
                    <div class="make-right list-cate-new">
                        <div class="slide-cate">
                            <span class="cate-item make-left active sys_group_new" data-id="0">Tất cả</span>
                            @foreach($treeCategory as $group)
                            <span class="cate-item make-left sys_group_new" data-id="{{$group['group_category_id']}}">{{$group["group_category_name"]}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="box-product-new clearfix">
                    @if($productNew)
                        @foreach($productNew as $k => $v)
                            @if($k < 4)
                            <div class="product-column make-left">
                                <div class="wrap-img">
                                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                        <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 192, 192)}}" alt="{{$v["product_Name"]}}" alt="" align="middle">
                                    </a>
                                    <div class="hover-cart btn_add_cart" data-id="{{$v["product_id"]}}">
                                        <i class="icons iCart3"></i>
                                    </div>
                                    <div class="hover-like" data-id="{{$v["product_id"]}}">
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
                </div>
            </div>
        </div>
        @if($productBuy)
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Sản phẩm bán chạy</div>
                </div>
                <div class="box-product-hot clearfix">
                    <div class="slide-hot">
                        @foreach($productBuy as $k => $v)
                            <div class="product-hot make-left">
                                <div class="hot-image make-left">
                                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}"><img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 110, 110)}}" alt="{{$v["product_Name"]}}" alt="{{$v["product_Name"]}}"></a>
                                </div>
                                <div class="product-hot-des make-left">
                                    <div class="product-hot-title"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
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
            </div>
        </div>
        @endif
        @if($productHot)
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Sản phẩm hot</div>
                </div>
                <div class="box-product-hot clearfix">
                    <div class="slide-hott">
                        @foreach($productHot as $k => $v)
                        <div class="product-column make-left">
                            <div class="wrap-img">
                                <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                    <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 260, 260)}}" alt="{{$v["product_Name"]}}" align="middle">
                                </a>
                                <div class="hover-cart btn_add_cart" data-id="{{$v["product_id"]}}">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like" data-id="{{$v["product_id"]}}">
                                    <i class="icons iHeart"></i>
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
        <div class="cr make-right clearfix mt-30" align="center">
            <img src="{{asset('assets/site/image/banner-2.png', false)}}" alt="">
        </div>
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Tin tức</div>
                    <div class="make-right"><a href="" class="new-all">Xem tất cả ></a></div>
                </div>
                <div class="box-news">
                    <div class="box-news-content make-left">
                        <div class="img-news">
                            <a href=""><img src="{{asset('assets/site/image/news-1.png', false)}}" alt=""></a>
                        </div>
                        <div class="news-title"><a href="">Làm việc nhiều không tăng năng suất chỉ khiến bạn 24343 3343</a></div>
                        <div class="news-auth">By Admin | 26 tháng 11 năm 2016</div>
                        <div class="news-short-desc">Một doanh nhân thành công vẫn có thể làm việc với số giờ thông thường mà vẫn tẩn hưởng cuộc sống.</div>
                        <div class="news-link">
                            <a href="">Xem thêm <i class="icons iNextz"></i></a>
                        </div>
                    </div>
                    <div class="box-news-content make-left">
                        <div class="img-news">
                            <img src="{{asset('assets/site/image/news-1.png', false)}}" alt="">
                        </div>
                        <div class="news-title">Làm việc nhiều không tăng năng suất chỉ khiến bạn 24343 3343</div>
                        <div class="news-auth">By Admin | 26 tháng 11 năm 2016</div>
                        <div class="news-short-desc">Một doanh nhân thành công vẫn có thể làm việc với số giờ thông thường mà vẫn tẩn hưởng cuộc sống.</div>
                        <div class="news-link">
                            <a href="">Xem thêm <i class="icons iNextz"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cr make-right mt-30">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Tin tức</div>
                </div>
                <div class="box-brand clearfix">
                    <div class="slide-brand" style="text-align: center">
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                        <div class="brand-img make-left"><img src="{{asset('assets/site/image/brand-1.png', false)}}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ HTML::script('assets/site/js/home.js') }}