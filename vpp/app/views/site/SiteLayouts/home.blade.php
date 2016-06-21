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
        <div class="box-heading"><span class="seeall"><a href="http://www.homenoffice.sg/index.php?route=product/category">Xem tất cả</a></span><span class="title" style="margin-left:390px">Danh mục</span></div>
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

    <div class="box">
        <div class="box-heading"><span class="title-best" style="background-image: none;">Sản phẩm nổi bật</span></div>
        <div class="box-content">
            <div class="box-product" align="center">
                <div class="box-column">
                    <div class="image">
                        <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                    <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                    <div class="price">
                        <span class="price-new">$3.45</span>
                    </div>
                    <div class="saving-point">
                        Retail Price: $4.00<br>
                        You Save: <span id="save">14%</span>
                    </div>
                    <div class="discount-msg">
                        Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                    </div>
                </div>
                <div class="box-column">
                    <div class="image">
                        <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                    <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                    <div class="price">
                        <span class="price-new">$3.45</span>
                    </div>
                    <div class="saving-point">
                        Retail Price: $4.00<br>
                        You Save: <span id="save">14%</span>
                    </div>
                    <div class="discount-msg">
                        Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                    </div>
                </div>
                <div class="box-column">
                    <div class="image">
                        <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                    <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                    <div class="price">
                        <span class="price-new">$3.45</span>
                    </div>
                    <div class="saving-point">
                        Retail Price: $4.00<br>
                        You Save: <span id="save">14%</span>
                    </div>
                    <div class="discount-msg">
                        Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                    </div>
                </div>
                <div class="box-column">
                    <div class="image">
                        <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                    <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                    <div class="price">
                        <span class="price-new">$3.45</span>
                    </div>
                    <div class="saving-point">
                        Retail Price: $4.00<br>
                        You Save: <span id="save">14%</span>
                    </div>
                    <div class="discount-msg">
                        Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                    </div>
                </div>
                <div class="box-column">
                    <div class="image">
                        <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                    <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                    <div class="price">
                        <span class="price-new">$3.45</span>
                    </div>
                    <div class="saving-point">
                        Retail Price: $4.00<br>
                        You Save: <span id="save">14%</span>
                    </div>
                    <div class="discount-msg">
                        Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slideshow0').nivoSlider();
    });
</script>