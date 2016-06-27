<!DOCTYPE html>
<html class="" dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Home n Office: Office Stationery Supplier Singapore</title>
    <!-- base href="http://www.homenoffice.sg/" -->
    <meta name="description" content="Home n Office is your one stop office stationery supplier, offering basic stationery, accessories, IT products, &amp; high end office equipment in Singapore.">
    <meta name="keywords" content="Home n Office, office stationery, stationery online, stationery supplier">
    <link href="http://www.homenoffice.sg/image/data/cart.png" rel="icon">
    <link href="http://www.homenoffice.sg/" rel="canonical">

    {{ HTML::style('assets/site/css/css.css') }}
    {{ HTML::style('assets/site/css/stylesheet.css') }}
    {{ HTML::style('assets/site/css/ui.css') }}
    {{ HTML::style('assets/site/css/slideshow.css', array('media' => 'screen')) }}
    {{ HTML::script('assets/site/js/jquery-1.js') }}
    {{ HTML::script('assets/site/js/jquery_004.js') }}
    {{ HTML::script('assets/site/js/cart.js') }}
    {{--{{ HTML::script('assets/site/js/jquery.nivo.slider.js') }}--}}
    {{--<link rel="stylesheet" type="text/css" href="vpp_site_files/bootstrap-modal.css">--}}
    {{--<link rel="stylesheet" type="text/css" href="vpp_site_files/bootstrap-theme.css">--}}
    {{--<script type="text/javascript" src="vpp_site_files/bootstrap.js"></script>--}}

    {{--<!--[if IE 7]>--}}
    {{--<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />--}}
    {{--<![endif]-->--}}
    {{--<!--[if lt IE 7]>--}}
    {{--<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />--}}
    {{--<![endif]-->--}}

    <script type="text/javascript">
        function mouseover(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
        function mouseout(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
    </script>
    </head>
<body>
<div id="container">
    <div id="header">
        <div id="logo"><a href="{{URL::route('site.home')}}"><img src="{{asset('assets/vpp_site_files/HOME-N-OFFICE-LOGO.png')}}" title="Home n Office Products Pte Ltd" alt="Home n Office Products Pte Ltd"></a></div>
        <div id="search">
            <div class="iSearchBoxWrapper">
                <div class="button-search"></div>
                <input autocomplete="off" name="search" placeholder="nhập từ khóa để tìm kiếm :)" type="text">
            </div>
        </div>
        <div id="welcome">
            <div id="divLogin" style="float:right">
                @if($customer_login)
                    <input type="button" onclick="window.location='{{URL::route('site.logout')}}'" value="Đăng xuất" id="btnLogin" class="login">
                    <input id="btnProfile" class="account" type="button" onclick="window.location=''" value="Hi, {{$customer_login['customers_username']}}">
                @else
                    <input class="login" id="btnLogin" value="Đăng nhập" onclick="window.location='{{URL::route('site.login')}}'" type="button">
                    <input class="account" id="btnRegister" value="Đăng ký" onclick="window.location='{{URL::route('site.register')}}'" type="button">
                @endif
            </div>
        </div>
    </div>
    <div id="menu">
        <ul>
            <li><a href="{{URL::route('site.home')}}">Trang chủ</a></li>
            <li><a href="{{URL::route('site.group',array('id' => 0,'name' => 'san-pham'))}}">Sản phẩm</a>
                <span id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></span>
                <ul>
                    @foreach($treeCategory as $group)
                    <li onmouseover="mouseover('{{$group["group_category_id"]}}', '{{Croppa::url(Constant::dir_group_category.$group['group_category_icon_hover'], 30, 30)}}');" onmouseout="mouseout('{{$group["group_category_id"]}}', '{{Croppa::url(Constant::dir_group_category.$group['group_category_icon'], 30, 30)}}')" @if(isset($group['child']) && $group['category_status'] == 1) class="has-sub" @endif>
                        <a href="{{URL::route('site.group',array('id' => $group["group_category_id"],'name' => FunctionLib::safe_title($group["group_category_name"])))}}">
                            <img id="icon-{{$group["group_category_id"]}}" src="{{Croppa::url(Constant::dir_group_category.$group['group_category_icon'], 30, 30)}}" valign="middle">{{$group["group_category_name"]}}
                        </a>
                        @if(isset($group['child']) && $group['category_status'] == 1)
                        <ul>
                            @foreach($group['child'] as $k => $child)
                                <li class="">
                                    <a href="{{URL::route('site.cate',array('gid' => $group['group_category_id'],'id' => $k,'name' => FunctionLib::safe_title($child)))}}">{{$child}}</a>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </li>
            <li><a href="javascript:void(0)">Giới thiệu</a></li>
            <li><a href="javascript:void(0)">Liên hệ</a></li>
            {{--<li><a id="icnWishlist" href="http://www.homenoffice.sg/wishlist">My List</a></li>--}}
            <li id="cartLi">
                <a id="icnCart">Giỏ hàng</a>
                <div id="cart" style="margin-left: -33.3167px;">
                    @if($cart)
                        <div class="content">
                            <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
                            <div style="margin-top:-15px;margin-left: 1px;" id="paperclip"></div>
                            <div style="margin-bottom:50px;">
                                <div style="float:left;color:#055993;font-size:16px;margin-left:30px;margin-top:5px;">Giỏ hàng của bạn</div>
                                <div style="float:right;"><input type="button" onclick="window.location=''" value="Thanh toán" id="button"></div>
                            </div>
                            <div class="mini-cart-info">
                                <table>
                                    <tbody>
                                    <?php $sub_total = 0;?>
                                    @foreach($cart as $k => $v)
                                        <tr>
                                            <td class="image">
                                                <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                                                    <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8991389139202-80x80.jpg"></a>
                                            </td>
                                            <td class="name"><a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a>
                                                <small>
                                                    <br>
                                                    Giá bán: {{number_format($v['product_price_buy'],0,'.','.')}}đ<br>
                                                    @if($v['product_price_buy'] < $v['product_Price'])
                                                        Giá bán lẻ: {{number_format($v['product_Price'],0,'.','.')}}đ<br>
                                                        Tiết kiệm: <span id="save">{{ceil(100 - ($v['product_price_buy']/$v['product_Price'])*100)}}%</span><br>
                                                    @endif
                                                </small>
                                            </td>
                                            <td class="quantity">
                                                <input type="text" size="2" value="{{$v['product_num']}}"><br>
                                            <td class="total">{{number_format($v['product_price_buy']*$v['product_num'],0,'.','.')}}đ</td>
                                            <?php
                                            $sub_total += $v['product_price_buy']*$v['product_num']
                                            ?>
                                            <td class="remove"><img alt="Remove" src="{{asset('assets/site/image/delete.png')}}"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mini-cart-total">
                                <table>
                                    <tbody><tr>
                                        <td style="font-size:16px;color:#055993;">Tổng tiền</td>
                                        <td align="right" style="width:388px;font-weight:bold;font-size:14px;">{{number_format($sub_total,0,'.','.')}}đ</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="http://www.homenoffice.sg/index.php?route=checkout/cart"><div class="checkout">Xem giỏ hàng</div></a>
                        </div>
                    @else
                        <div class="content">
                            <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
                            <div id="paperclip" style="margin-top:-15px;margin-left: 1px;"></div>
                            <div class="empty">Giỏ hàng trống !</div>
                        </div>
                    @endif
                </div>
            </li>
        </ul>
    </div>
    <div id="notification"></div>
    {{$content}}
    <div id="footer">
        <div class="column">
            <h3>Need Help?</h3>
            <img class="footer-img" src="{{asset('assets/site/image/help.png')}}">
            <p>Email us at <a id="mailto" href="mailto:enquiry@homenoffice.com.sg">enquiry@homenoffice.com.sg</a> and we will get back to you shortly.</p>
        </div>
        <div class="column">
            <h3>Information</h3>
            <img class="footer-img" src="{{asset('assets/site/image/info2.png')}}">
            <ul>
                <li><a href="http://www.homenoffice.sg/f-a-q">F.A.Q</a></li>
                <li><a href="http://www.homenoffice.sg/privacy-policy">Privacy Policy</a></li>
                <li><a href="http://www.homenoffice.sg/terms-and-conditions">Terms &amp; Conditions</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/contact">Contact Us</a></li> -->
            </ul>
        </div>
        <!-- <div class="column">
        <h3>Delivery</h3>
        <img class="footer-img" src="catalog/view/theme/default/image/delivery.png">
        <ul>
          <li><a href="http://www.homenoffice.sg/returns">Shipping & Returns</a></li>
          <li><a href="http://www.homenoffice.sg/f-a-q">F.A.Q</a></li>
          <li><a href="http://www.homenoffice.sg/index.php?route=information/information&information_id=6">Delivery Information</a></li>
        </ul>
      </div> -->
        <div class="column">
            <h3>My Account</h3>
            <img class="footer-img" src="{{asset('assets/site/image/account.png')}}">
            <ul>
                <li><a href="http://www.homenoffice.sg/account">My Account</a></li>
                <li><a href="http://www.homenoffice.sg/index.php?route=account/order">My Invoices</a></li>
                <li><a href="http://www.homenoffice.sg/wishlist">My Wishlist</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/newsletter">Newsletter</a></li> -->
            </ul>
        </div>
        <div class="column">
            <h3>Brochures</h3>
            <img class="footer-img" src="{{asset('assets/site/image/brochure.png')}}">
            <ul>
                <li><a href="http://www.homenoffice.sg/catalogs-brochures">Catalogs / Brochures</a></li>
            </ul>
        </div>
        <div class="column"></div>
    </div>
</div>
<div id="footer-bar"></div>
<div id="powered" align="center">
    <img id="footer-logo" src="{{asset('assets/site/image/footer-logo.png')}}"><br>
    Copyright 2016 © Home n Office Products Pte Ltd. All Rights Reserved.
</div>
<a style="display: none;" href="#" id="toTop"><span id="toTopHover"></span>To Top</a>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).on("scroll", function () {
            var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

            if (pageOffetTop > 200) {
                $("#toTop").show();
            } else
                $("#toTop").hide();
        });
        $("#toTop").on("click", function () {
            $("html, body").animate({scrollTop: 0}, 500);
            return false;
        });
        $('.sys_quantity').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
</script>
</body>
</html>