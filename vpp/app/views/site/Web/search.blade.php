<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Tìm kiếm</a>
            </div>
        </div>
        <div class="cl make-left">
            <div class="box-left clearfix">
                <div class="box-left-title">
                   Danh mục
                </div>
                <ul class="rs cate-list">
                    @foreach($treeCategory as $group)
                    <li class="">
                        <a href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}">{{$group["group_category_name"]}}<i class="icons iRightC make-right"></i></a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @if($productKm)
                <div class="box-left clearfix mt-30">
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
            @if($productRelate)
                <div class="box-left clearfix mt-30">
                    <div class="box-left-title">
                        Đề xuất
                    </div>
                    <div class="sys_dx_deal" style="height: 300px;overflow: hidden">
                        @foreach($productRelate as $k => $v)
                            <div class="deal-dx clearfix">
                                <div class="dx-image make-left">
                                    <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}"><img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 80, 80)}}" alt="{{$v["product_Name"]}}"></a>
                                </div>
                                <div class="dx-des make-left">
                                    <div class="dx-title"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
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
                    <div class="dx-xemthem sys_xemthem">
                        <a href="javascript:void(0)">Xem thêm <i class="icons iDown2"></i></a>
                    </div>
                    <div class="dx-xemthem sys_thunho" style="display: none">
                        <a href="javascript:void(0)">Thu nhỏ <i class="icons iUp"></i></a>
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
            <div class="container-list clearfix">
                <div class="box-right clearfix">
                    <div class="box-right-title">
                        <div class="make-left fs-24">
                            "{{$keyword}}"
                            <span class="sub-title"> có {{$total}} kết quả tìm thấy</span>
                        </div>
                        {{--<div class="frm-sx make-right mr-25">
                            <label class="sub-title" for="">Sắp xếp :   </label>
                            <select id="sort">
                                @foreach(Constant::$sort as $k => $v)
                                    <option value="{{$k}}" @if($k == $param['sort']) selected="selected" @endif>{{$v['label']}}</option>
                                @endforeach
                            </select>
                            <i class="icons iDown3" style="top: 25px"></i>
                        </div>--}}
                    </div>
                    <div class="list-product-grid">
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>100 hoặc nhiều hơn</b></div>
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>52.000</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <a href="">
                                    <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                </a>
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal"><a href="">Máy in giấy Deli387</a></div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>100 hoặc nhiều hơn</b></div>
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>52.000</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>100 hoặc nhiều hơn</b></div>
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>52.000</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>100 hoặc nhiều hơn</b></div>
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>52.000</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                        <div class="product-box make-left">
                            <div class="wrap-img make-left">
                                <img src="{{asset('assets/site/image/list-1.png', false)}}" alt="">
                                <div class="hover-cart">
                                    <i class="icons iCart3"></i>
                                </div>
                                <div class="hover-like">
                                    <i class="icons iHeart"></i>
                                </div>
                            </div>
                            <div class="box-description make-left">
                                <div class="title-deal">Máy in giấy Deli387</div>
                                <div class="rate-deal">
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate checked"></i>
                                    <i class="icons iRate"></i>
                                </div>
                                <div class="price-deal">
                            <span class="price-sale-deal">
                                900.000<span>đ</span>
                            </span>
                            <span class="price-original-deal pl-20">
                                1.900.000<span>đ</span>
                            </span>
                                </div>
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>100 hoặc nhiều hơn</b></div>
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>52.000</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                <div class="btn btn-muangay mt-20 make-left" id="">
                                    <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                    Thêm vào giỏ
                                </div>
                                <div class="btn btn-like ml-20 mt-20 make-left" id="">
                                    <i class="icons iHeart2"></i>
                                    Yêu thích
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pagination make-right mt-20 mb-30 mr-25">
                        <ul class="rs">
                            <li class="page-prev-next">
                                <a href=""><i class="icons iPrev"></i></a>
                            </li>
                            <li class="active"><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li class="page-prev-next">
                                <a href=""><i class="icons iNext"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ HTML::script('assets/site/js/home.js') }}
<script type="text/javascript">
/*    $(document).ready(function(){
        $("#sort").on('change', function () {
            var sort = $("#sort").val();
            var link = window.location.origin + window.location.pathname + '?sort=' + sort + '&limit=' + limit;
            window.location.href = link;
        });
    })*/
</script>