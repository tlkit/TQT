<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">{{$treeCategory[$id]['group_category_name']}}</a>
            </div>
        </div>
        <div class="cl make-left">
            <div class="box-left clearfix">
                <div class="box-left-title">
                    {{$treeCategory[$id]['group_category_name']}}
                </div>
                @if(isset($treeCategory[$id]['child']) && $treeCategory[$id]['category_status'] == 1)
                    <ul class="rs cate-list">
                        @foreach($treeCategory[$id]['child'] as $k => $child)
                            <li>
                                <a href="{{URL::route('site.cate',array('gid' => $id,'id' => $k,'name' => FunctionLib::safe_title($child)))}}">{{$child}}<i class="icons iRightC make-right"></i></a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="box-left clearfix mt-30">
                <div class="box-left-title">
                    Khuyến mại
                </div>
                <div class="slide-deal-km clearfix">
                    <div class="box-deal mt-20 clearfix">
                        <div class="wrap-img clearfix">
                            <img src="{{asset('assets/site/image/product-1.png', false)}}" alt="">
                        </div>
                        <div class="box-countdown"></div>
                        <div class="box-description">
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
                            <div class="btn btn-muangay mb-20" id="">
                                <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                Thêm vào giỏ
                            </div>
                        </div>
                    </div>
                    <div class="box-deal mt-20 clearfix">
                        <div class="wrap-img clearfix">
                            <img src="{{asset('assets/site/image/product-1.png', false)}}" alt="">
                        </div>
                        <div class="box-countdown"></div>
                        <div class="box-description">
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
                            <div class="btn btn-muangay mb-20" id="">
                                <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                Thêm vào giỏ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="cr make-right bg">
            <div class="container-list clearfix">
                <div class="nav-filter">
                    <div class="filter-view make-left">
                        <i class="icons iGrid"></i> Grid
                    </div>
                    <div class="filter-view make-left">
                        <i class="icons iList"></i> List
                    </div>
                    <div class="frm-sx make-left">
                        <label for="">Sắp xếp :   </label>
                        <select name="" id="">
                            <option value="">12</option>
                            <option value="">24</option>
                            <option value="">36</option>
                        </select>
                        <i class="icons iDown3"></i>
                    </div>
                    <div class="frm-sx make-left">
                        <label for="">Hiển thị :   </label>
                        <select name="" id="">
                            <option value="">12</option>
                            <option value="">24</option>
                            <option value="">36</option>
                        </select>
                        <i class="icons iDown3"></i>
                    </div>
                    <div class="pagination make-right">
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#limit, #sort").on('change', function () {
            var sort = $("#sort").val();
            var limit = parseInt($("#limit").val());
            var link = window.location.origin + window.location.pathname + '?sort=' + sort + '&limit=' + limit;
            window.location.href = link;
        });
    })
</script>