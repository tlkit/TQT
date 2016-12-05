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
                            <li class="">
                                <a href="{{URL::route('site.cate',array('gid' => $id,'id' => $k,'name' => FunctionLib::safe_title($child)))}}">{{$child}}<i class="icons iRightC make-right"></i></a>
                            </li>
                        @endforeach
                    </ul>
                @endif
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
            <div class="mt-30">
                <div class="fb-page" data-href="https://www.facebook.com/vppthieuson" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/vppthieuson" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/vppthieuson">Văn phòng phẩm Thiều Sơn</a></blockquote></div>
            </div>
        </div>
        <div class="cr make-right bg">
            <div class="container-list clearfix">
                <div class="nav-filter">
                    <div class="filter-view make-left sys_filter_view" data-value="1">
                        <i class="icons iGrid @if($type_view == 1) active @endif"></i><span style="margin-left: 5px">Grid</span>
                    </div>
                    <div class="filter-view make-left sys_filter_view" data-value="2">
                        <i class="icons iList @if($type_view == 2) active @endif"></i><span style="margin-left: 5px">List</span>
                    </div>
                    <div class="frm-sx make-left">
                        <label for="">Sắp xếp :</label>
                        <select id="sort">
                            @foreach(Constant::$sort as $k => $v)
                                <option value="{{$k}}" @if($k == $param['sort']) selected="selected" @endif>{{$v['label']}}</option>
                            @endforeach
                        </select>
                        <i class="icons iDown3"></i>
                    </div>
                    <div class="frm-sx make-left">
                        <label for="">Hiển thị :</label>
                        <select id="limit">
                            @foreach(Constant::$limit as  $v)
                                <option value="{{$v}}" @if($v == $param['limit']) selected="selected" @endif>{{$v}}</option>
                            @endforeach
                        </select>
                        <i class="icons iDown3"></i>
                    </div>
                    <div class="make-right">
                        {{$paging}}
                    </div>
                </div>
                <div class="sys_view_content @if($type_view == 1) list-product-grid @else list-product @endif">
                    @foreach($data as $k => $v)
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
                            <div class="title-deal">
                                <a href="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 260, 260)}}">{{$v["product_Name"]}}</a>
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
                            @if($v['product_bulk_quantity'] > 0)
                                <div class="fs-14 fc-grey-3 price-bulk">Số lượng bán buôn : <b>{{$v['product_bulk_quantity']}} hoặc nhiều hơn</b></div>
                                @if($v['product_bulk_price'] > 0)
                                <div class="fs-14 fc-grey-3 price-bulk">Giá bán buôn : <b>{{number_format($v['product_bulk_price'],0,'.','.')}}</b><span style="text-decoration: underline;font-size: 12px">đ</span></div>
                                @endif
                            @endif
                            <div class="btn btn-muangay mt-20 make-left btn_add_cart" data-id="{{$v["product_id"]}}" id="">
                                <i class="wrap-icon"><i class="icons iCart2"></i></i>
                                Thêm vào giỏ
                            </div>
                            <div class="btn btn-like ml-20 mt-20 make-left" data-id="{{$v["product_id"]}}" id="">
                                <i class="icons iHeart2"></i>
                                Yêu thích
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="clearfix"></div>
                <div class="make-right mt-20 mb-30 mr-25">
                    {{$paging}}
                </div>
            </div>
        </div>
    </div>
</div>
{{ HTML::script('assets/site/js/list.js') }}