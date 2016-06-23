{{ HTML::style('assets/site/css/refine_styles.css') }}
{{ HTML::style('assets/site/css/cloud-zoom.css') }}
{{ HTML::script('assets/site/js/cloud-zoom.1.0.2.js') }}
<div id="column-left">
    <div class="span-4 last" id="lnav-container">
        <div class="span-4" id="lnav-content-container">
            <div id="lnav-inner-container">
                <h2 style="text-transform:uppercase;">Danh mục</h2>
                <div class="lnav-horizontal-divider"></div>

                <div rel="show" id="lnav-categories-container" class="lnav-category-container">
                    {{--                    <div class="lnav-banner">
                                            <h3 style="display: block;">Category</h3>
                                            <div class="expand-collapse-container lnav-collapse" style="display: block;"></div>
                                            <div class="expand-collapse-container lnav-expand active" style="display: none;"></div>
                                        </div><!--lnav-banner-->--}}
                    <div class="lnav-link-container">
                        <ul class="box-category">
                            @foreach($treeCategory as $group)
                                <li>
                                    <img style="margin-right:5px;" src="{{asset('assets/site/image/bullet-point.png')}}">
                                    <a href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}">{{$group["group_category_name"]}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!--lnav-link-container-->
                </div><!--End Category-->
            </div><!--End-inner-container-->
        </div><!--End-content-container-->
    </div>
</div>

<div id="content">
    <h1 style="font-weight:bold; margin-top:25px; margin-bottom:0px;">{{$product['product_Name']}}</h1>
    <div class="barcode" style="margin-bottom: 25px;"></div>
    <div class="product-info">
        <div class="left">

            <div class="image"><a href="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-1000x1000.jpg" title="{{$product['product_Name']}}" class="cloud-zoom" id='zoom1' rel="adjustX: 10, adjustY:-4, tint:'#000000',tintOpacity:0.2, zoomWidth:360"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-228x228.jpg" title="{{$product['product_Name']}}" alt="" id="image" /></a></div>


            <div class="image-additional">

                <a href="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-1000x1000.jpg" title="{{$product['product_Name']}}" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: 'http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-228x228.jpg' "><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-74x74.jpg" title="{{$product['product_Name']}}" alt="" id="image" onclick="largelink('http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Deep Colours-500x500.jpg')"/></a>


                <a href="http://www.homenoffice.sg/image/cache/data/Product Pictures/sinar-spectra-colour-paper-80gsm-a4-pastel-a3409-1000x1000.jpg" title="{{$product['product_Name']}}" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: 'http://www.homenoffice.sg/image/cache/data/Product Pictures/sinar-spectra-colour-paper-80gsm-a4-pastel-a3409-228x228.jpg' "><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/sinar-spectra-colour-paper-80gsm-a4-pastel-a3409-74x74.jpg" title="{{$product['product_Name']}}" alt="" onclick="largelink('http://www.homenoffice.sg/image/cache/data/Product Pictures/sinar-spectra-colour-paper-80gsm-a4-pastel-a3409-500x500.jpg')" /></a>


            </div>
        </div>
        <div class="right">
            <div class="price"><!--          -->
                <!-- <img src="catalog/view/theme/default/image/save.png"><br/> -->
                <span class="price-new">{{number_format($product['product_Price'])}}</span>
                <br />
            </div>
            <div class="description">
                <!--                 <span>Product Code:</span> Deep<br />
                                <span>Availability:</span> In Stock -->
                <h2>{{$product['product_Name']}}</h2>
                @if($product['product_Description'] != '')
                <ul>
                    <li>{{$product['product_Description']}}</li>
                </ul>
                @endif
            </div>
            <div class="price2">
                <div id="discount-title" style="display:none">Different Price Tiers</div>
                <div class="discount">
                    <ul>
                        <li>SL bán buôn: <span>5 & nhiều hơn</span><br />Giá bán buôn: <span>$9.60</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">20%</span>)</li>
                    </ul>
                </div>
            </div>
            <div class="cart">
                <div>
          <span id="lblQty">Số lượng<span>&nbsp;&nbsp;
          <input type="text" value="1" size="2" name="quantity" id="qty">
          <input type="hidden" value="4497" size="2" name="product_id">
          <br><br>

			<input type="button" class="button" id="button-cart" value="Add to Cart" onclick="ga('send', 'event', 'Product Page', 'Add to Cart', 'HnO 3-Tier Brochure Holder DL Portrait');">
        </span></span></div>
            </div>
            <!--        -->
        </div>
    </div>
    <div class="box">
        <div class="box-heading"><span class="title">Sản phẩm liên quan</span></div>
        <div class="box-content">
            <div align="center" class="box-product">
                <div class="box-column2" style="width:29%;">
                    <div class="image"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Pastel Colours-130x130.jpg" alt="Sinar Spectra Colour Paper 80gsm A4 Pastel" style="padding:10px" /></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel">Sinar Spectra Colour Paper 80gsm A4 Pastel</a></div>
                    <div class="barcode"><small></small></div>
                    <div class="price">
                        <span class="price-new">{{number_format($product['product_Price'])}}</span>
                    </div>
                    <div class="discount-msg">
                        SL bán buôn: <span>5 & nhiều hơn</span><br />Giá bán buôn: <span>$6.40</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">20%</span>)
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
                    </div>
                </div>
                <div class="box-column2" style="width:29%;">
                    <div class="image"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Pastel Colours-130x130.jpg" alt="Sinar Spectra Colour Paper 80gsm A4 Pastel" style="padding:10px" /></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel">Sinar Spectra Colour Paper 80gsm A4 Pastel</a></div>
                    <div class="barcode"><small></small></div>
                    <div class="price">
                        <span class="price-new">{{number_format($product['product_Price'])}}</span>
                    </div>
                    <div class="discount-msg">
                        SL bán buôn: <span>5 & nhiều hơn</span><br />Giá bán buôn: <span>$6.40</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">20%</span>)
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
                    </div>
                </div>
                <div class="box-column2" style="width:29%;">
                    <div class="image"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/Sinar Pastel Colours-130x130.jpg" alt="Sinar Spectra Colour Paper 80gsm A4 Pastel" style="padding:10px" /></a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="http://www.homenoffice.sg/sinar-spectra-colour-paper-80gsm-a4-pastel">Sinar Spectra Colour Paper 80gsm A4 Pastel</a></div>
                    <div class="barcode"><small></small></div>
                    <div class="price">
                        <span class="price-new">{{number_format($product['product_Price'])}}</span>
                    </div>
                    <div class="discount-msg">
                        SL bán buôn: <span>5 & nhiều hơn</span><br />Giá bán buôn: <span>$6.40</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">20%</span>)
                    </div>
                    <div class="cart">
                        <input value="Add to Cart"  class="button" type="button">
                            <span class="counter2">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1" class="sys_quantity">
                            </span>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#qty').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })
</script>