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
            <div class="box-product" align="center">
                @foreach($treeCategory as $group)
                <div class="box-column3">
                    <a href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}">
                        <img src="{{Croppa::url(Constant::dir_group_category.$group['group_category_image'], 150, 150)}}" height="150" width="150"><br><br>
                        {{$group["group_category_name"]}}
                    </a>
                </div>
                @endforeach
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
    @if($product)
    <div class="box">
        <div class="box-heading"><span class="title-best" style="background-image: none;">Sản phẩm nổi bật</span></div>
        <div class="box-content">
            <div class="box-product" align="center">
                @foreach($product as $k => $v)
                <div class="box-column">
                    <div class="image">
                        <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                            <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 130, 130)}}" alt="{{$v["product_Name"]}}">
                        </a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
                    <div class="price">
                        <span class="price-new">{{number_format($v['product_Price'],0,'.','.')}}đ</span>
                    </div>
                    @if($v['product_bulk_quantity'] > 0)
                        <div class="discount-msg">
                            SL bán buôn: <span>{{$v['product_bulk_quantity']}} & nhiều hơn</span><br />
                            @if($v['product_bulk_price'] > 0)
                                Giá bán buôn: <span>{{number_format($v['product_bulk_price'],0,'.','.')}}</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">{{ceil(($v['product_Price'] - $v['product_bulk_price'])/$v['product_Price']*100)}}%</span>)
                            @endif
                        </div>
                    @endif
                    <div class="cart">
                        <input value="Add to Cart"  class="button btn_add_cart" type="button" data-id="{{$v['product_id']}}">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[{{$v['product_id']}}]" type="text" @if(isset($cart[$v['product_id']])) value="{{$cart[$v['product_id']]['product_num']}}" @else value="1" @endif >
                            </span>
                    </div>
                </div>
                @endforeach
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slideshow0').nivoSlider();
    });
</script>
