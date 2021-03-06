{{ HTML::style('assets/site/css/slick.css') }}
{{ HTML::script('assets/site/js/slick.min.js') }}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css"/>
<div id="content">
    @if($banner)
    <div class="slideshow">
        <div id="slideshow0" class="nivoSlider" style="height: 374px">
            @foreach($banner as $ban)
            <a class="nivo-imageLink" href="{{$ban['banner_url']}}">
                <img src="{{Croppa::url(Constant::dir_banner.$ban['banner_image'], 1024, 374)}}" alt="{{$ban['banner_name']}}">
            </a>
            @endforeach
        </div>
    </div>
    @endif
    <div class="box">
        <div class="box-heading"><span class="seeall"><a href="{{URL::route('site.group',array('id' => 0,'name' => 'san-pham'))}}">Xem tất cả</a></span><span class="title" style="margin-left:390px">Danh mục</span></div>
        <div class="box-content">
            <div class="sys_box_category">
                @foreach($treeCategory as $group)
                <div>
                    <a href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}" style="text-align: center">
                        <img style="margin-left: 25px" src="{{Croppa::url(Constant::dir_group_category.$group['group_category_image'], 200, 200)}}" height="200" width="200"><br>
                        <div style="margin-left: 25px">{{$group["group_category_name"]}}</div>
                    </a>
                </div>
                @endforeach
{{--                <div style="clear:both"></div>--}}
            </div>
        </div>
    </div>
    @if($product)
    <div class="box">
        <div class="box-heading"><span class="title-best" style="background-image: none;">Sản phẩm nổi bật</span></div>
        <div class="box-content">
            <div class="sys_box_product">
                @foreach($product as $k => $v)
                    <div class="">
                        <div class="image" style="padding-left: 25px">
                            <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                                <img width="200" height="200" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 200, 200)}}" alt="{{$v["product_Name"]}}">
                            </a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name" style="margin: 15px 0px 0px 0px;height: 50px"><a style="margin-left: 15px" href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
                        <div style="text-align:left;margin-left: 15px" class="barcode"><small>{{$v['product_Code']}}</small></div>
                        <div class="price" style="margin-left: 15px">
                            <span class="price-new">{{number_format($v['product_Price'],0,'.','.')}}đ</span>
                        </div>
                        <div class="discount-msg" style="min-height: 37px;margin-left: 15px">
                            @if($v['product_bulk_quantity'] > 0)
                            SL bán buôn: <span>{{$v['product_bulk_quantity']}} & nhiều hơn</span><br />
                            @if($v['product_bulk_price'] > 0)
                                Giá bán buôn: <span>{{number_format($v['product_bulk_price'],0,'.','.')}}</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">{{ceil(($v['product_Price'] - $v['product_bulk_price'])/$v['product_Price']*100)}}%</span>)
                            @endif
                            @endif
                        </div>
                        <div class="cart" style="margin-left: 15px">
                            <input value="Đặt mua"  class="button btn_add_cart" type="button" data-id="{{$v['product_id']}}" style="padding-left: 48px">
                        <span class="counter" style="margin-left: 0px">
                            <input style="background-color: rgb(5, 113, 175);" name="quantity[{{$v['product_id']}}]" type="text" @if(isset($cart[$v['product_id']])) value="{{$cart[$v['product_id']]['product_num']}}" @else value="1" @endif >
                        </span>
                        </div>
                    </div>
                @endforeach
                    {{--<div style="clear:both"></div>--}}
            </div>
        </div>
    </div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slideshow0').nivoSlider();
        $('.sys_box_category').slick({
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,

        });
        $('.sys_box_product').slick({
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            autoplay: false,
            autoplaySpeed: 2000,

        });
/*        $('.sys_box_category').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1
        });*/
    });
</script>
