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
                            <img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Energizer Battery E91 E92-130x130.jpg" alt="{{$v["product_Name"]}}">
                        </a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
                    <div class="price">
                        <span class="price-new">{{number_format($v['product_Price'],0,'.','.')}}đ</span>
                    </div>
                    <div class="discount-msg">
                        SL bán buôn: <span>20 & hơn</span>
                        <br />
                        Giá bán buôn: <span>$2.65</span>
                        &nbsp;&nbsp;(Tiết kiệm: <span id="save">19%</span>)
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
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
