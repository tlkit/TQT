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
    <div class="barcode" style="margin-bottom: 25px;">{{$product['product_Code']}}</div>
    <div class="product-info">
        <div class="left">

            <div class="image">
                <a href="{{Croppa::url(Constant::dir_product.$product['product_Avatar'])}}" title="{{$product['product_Name']}}" class="cloud-zoom" id='zoom1' rel="adjustX: 10, adjustY:-4, tint:'#000000',tintOpacity:0.2, zoomWidth:360">
                    <img src="{{Croppa::url(Constant::dir_product.$product['product_Avatar'], 228, 228)}}" title="{{$product['product_Name']}}" alt="" id="image" />
                </a>
            </div>
            <div class="image-additional">
                <?php $aryImage = json_decode($product['product_Image'],true);?>
                @if($aryImage)
                @foreach($aryImage as $image)
                        <a href="{{Croppa::url(Constant::dir_product.$image)}}" title="{{$product['product_Name']}}" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '{{Croppa::url(Constant::dir_product.$image,228,228)}}' ">
                            <img src="{{Croppa::url(Constant::dir_product.$image,74,74)}}" title="{{$product['product_Name']}}" alt="" id="image" onclick="largelink('{{Croppa::url(Constant::dir_product.$image,500,500)}}')"/>
                        </a>
                @endforeach
                @endif
            </div>
        </div>
        <div class="right">
            <div class="price"><!--          -->
                <!-- <img src="catalog/view/theme/default/image/save.png"><br/> -->
                <h2>Giá bán :</h2>
                <span class="price-new">{{number_format($product['product_Price'])}}Đ</span>
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
                @if($product['product_bulk_quantity'] > 0)
                <div class="discount">
                    <ul>
                        <li>SL bán buôn: <span>{{$product['product_bulk_quantity']}} & nhiều hơn</span><br />
                            @if($product['product_bulk_price'] > 0)
                            Giá bán buôn: <span>{{number_format($product['product_bulk_price'],0,'.','.')}}</span>&nbsp;&nbsp;(Tiết kiệm: <span id="save">{{ceil(($product['product_Price'] - $product['product_bulk_price'])/$product['product_Price']*100)}}%</span>)
                            @endif
                        </li>
                    </ul>
                </div>
                @endif
            </div>
            <div class="cart">
                <div>
          <span id="lblQty">Số lượng<span>&nbsp;&nbsp;
          <input type="text" value="1" size="2" name="quantity[{{$product['product_id']}}]" id="qty">
          <br><br>

			<input class="button btn_add_cart" type="button" data-id="{{$product['product_id']}}" id="button-cart" value="Đặt mua">
        </span></span></div>
            </div>
            <!--        -->
        </div>
    </div>
    @if($product_relate)
    <div class="box">
        <div class="box-heading"><span class="title">Sản phẩm liên quan</span></div>
        <div class="box-content">
            <div align="center" class="box-product">
                @foreach($product_relate as $k => $v)
                <div class="box-column2" style="width:29%;">
                    <div class="image">
                        <a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">
                            <img src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 130, 130)}}" alt="{{$v["product_Name"]}}" style="padding:10px" />
                        </a>
                        <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                               -->
                    </div>
                    <div class="name"><a href="{{URL::route('site.product',array('id' => $v["product_id"],'name' => FunctionLib::safe_title($v["product_Name"])))}}">{{$v["product_Name"]}}</a></div>
                    <div style="text-align:left" class="barcode"><small>{{$v['product_Code']}}</small></div>
                    <div class="price">
                        <span class="price-new">{{number_format($v['product_Price'])}}</span>
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
                        <input value="Đặt mua"  class="button btn_add_cart" type="button" data-id="{{$v['product_id']}}">
                        <span class="counter2">
                            <input style="background-color: rgb(5, 113, 175);" name="quantity[{{$v['product_id']}}]" type="text" @if(isset($cart[$v['product_id']])) value="{{$cart[$v['product_id']]['product_num']}}" @else value="1" @endif class="sys_quantity">
                        </span>
                    </div>
                </div>
                @endforeach
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
    @endif
    <div style="clear:both"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#qty').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })
</script>