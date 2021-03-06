<!DOCTYPE html>
<html class="" dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Bán buôn văn phòng phẩm</title>
    <!-- base href="http://www.homenoffice.sg/" -->
    <meta name="description" content="Thiều Sơn Company chuyên bán buôn bán lẻ các sản phẩm văn phòng phẩm">
    <meta name="keywords" content="Thiều Sơn, văn phòng phẩm, bán buôn">
    <link rel="icon" type="image/png" href="{{asset('assets/site/image/favicon.png')}}" />
    <link href="{{URL::current()}}" rel="canonical">

    {{ HTML::style('assets/site/css/slick.css') }}
    {{ HTML::style('assets/site/css/style.css') }}
    {{ HTML::script('assets/site/js/jquery-1.js') }}
    {{ HTML::script('assets/site/js/slick.min.js') }}
    {{ HTML::script('assets/site/js/countdown/jquery.plugin.min.js') }}
    {{ HTML::script('assets/site/js/countdown/jquery.countdown.min.js') }}
    {{ HTML::script('assets/site/js/countdown/jquery.countdown-vi.js') }}
    {{ HTML::script('assets/js/jquery.cookie.js'); }}
    {{ HTML::script('assets/site/js/cart.js') }}
    {{ HTML::script('assets/site/js/head.js') }}

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-89058527-1', 'auto');
        ga('send', 'pageview');

    </script>


</head>
<body>
<div class="container-page">
    <div id="header">
        <div class="header-top clearfix">
            @if($customer_login)
            <div class="make-right pl-30 user-login">
                <a href="javascript:void(0)" class="fc-grey-1">Hi ! {{$customer_login['customers_username']}}</a>
                <div class="user-login-info">
                    <i class="icon-down2"></i>
                    <div class="user-login-item">
                        <i class="icons iUsers"></i>
                        <a href="{{URL::route('site.changeInfo')}}">Quản lý tài khoản</a>
                    </div>
                    <div class="user-login-item">
                        <i class="icons iLists"></i>
                        <a href="{{URL::route('site.order_history')}}">Quản lý đơn hàng</a>
                    </div>
                    {{--<div class="user-login-item active">
                        <i class="icons iHearts"></i>
                        <a href="">Danh sách yêu thích</a>
                    </div>--}}
                    <div class="user-login-item">
                        <i class="icons iOut"></i>
                        <a href="{{URL::route('site.logout')}}">Đăng xuất</a>
                    </div>
                </div>
            </div>
            @else
                <div class="make-right pl-30"><a href="{{URL::route('site.register')}}" class="fc-grey-1">Đăng ký</a></div>
                <div class="make-right pl-30"><a href="{{URL::route('site.login')}}" class="fc-grey-1">Đăng nhập</a></div>
            @endif
            {{--<div class="make-right pl-30"><a href="" class="fc-grey-1">Yêu thích</a></div>--}}
        </div>
        <div class="header-mid clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}"><i class="iLogo"></i></a>
            <div class="mid-cart make-right">
                <a href="{{URL::route('cart.checkout_cart')}}">
                    <i class="icons iCart make-left"></i>
                    <div class="cart-count make-left">
                        <div class="fs-14 fc-blue-1">Giỏ hàng</div>
                    </div>
                    <div class="number-cart" id="" data-count="{{count($cart)}}">{{count($cart)}}</div>
                </a>
                <div class="cart-hover">
                    <div class="cart-hover-content">
                        @if($cart)
                        <?php $sub_total = 0;?>
                        @foreach($cart as $k => $v)
                        <div class="cart-item clearfix mb-20 row_{{$v['product_id']}}">
                            <div class="wrap-img make-left">
                                <a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">
                                    <img title="{{$v['product_Name']}}" alt="{{$v['product_Name']}}" src="{{Croppa::url(Constant::dir_product.$v['product_Avatar'], 60, 60)}}"></a>
                                </a>
                            </div>
                            <div class="cart-item-des make-left ml-10">
                                <div class="cart-item-title"><a href="{{URL::route('site.product',array('id' => $k,'name'=>FunctionLib::safe_title($v['product_Name'])))}}">{{$v['product_Name']}}</a></div>
                                <div class="price-cart-item">
                                <span class="price-dx-deal">
                                    {{number_format($v['product_price_buy'],0,'.','.')}}<span>đ</span>
                                </span>
                                </div>
                                <i class="icons iTrack sys_remove" data-id="{{$v['product_id']}}"></i>
                            </div>
                        </div>
                        <?php
                        $sub_total += $v['product_price_buy']*$v['product_num']
                        ?>
                        @endforeach
                        <div class="divider"></div>
                        <div class="cart-total mb-20">
                            Tạm tính : <span class="price">{{number_format($sub_total,0,'.','.')}}<span>đ</span></span>
                        </div>
                        <div class="cart-view">
                            <a href="{{URL::route('cart.checkout_cart')}}" class="btn-view-cart">Xem giỏ hàng</a>
                        </div>
                        @else
                            <div>Không có sản phẩm nào trong giỏ hàng !!!</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mid-searchbox clearfix">
                <div class="lbl-search make-left">
                    <div class="txt-cate-search make-left">
                        Tất cả
                    </div>
                    <div class="make-left">
                        <i class="icons iDown"></i>
                    </div>
                    <div class="search-cate">
                        <div class="search-item active" data-id="0">Tất cả</div>
                        @foreach($treeCategory as $group)
                        <div class="search-item" data-id="{{$group["group_category_id"]}}">{{$group["group_category_name"]}}</div>
                        @endforeach
                    </div>
                </div>
                <div class="frm-search make-left fs-14">
                    <label for="sys_keyword">
                        <input id="sys_keyword" name="keyword" placeholder="Nhập từ khóa để tìm kiếm..." autocomplete="off" value="" data-id="0" type="text">
                    </label>
                    <button class="btn-search sys_btn_search" type="button"><i class="icons iSearch"></i></button>
                </div>
            </div>
        </div>
        <div class="header-nav clearfix">
            <ul class="menu-nav rs">
                <a class="nav-title" href="{{URL::route('site.home')}}"><li class="menu-nav-title">Trang chủ</li></a>
                <li class="nav-title menu-nav-title has-sub">
                    Sản phẩm
                    <i class="icon-down"></i>
                    <div class="sub-menu clearfix">
                        <div class="height-15 make-left">
                        </div>
                        <div class="nav-content make-left clearfix">
                            <ul class="rs parent-cate">
                                <?php $i = 1?>
                                @foreach($treeCategory as $group)
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    {{$group["group_category_name"]}}
                                    <ul class="rs">
                                        @if(isset($group['child']) && $group['category_status'] == 1)
                                            @foreach($group['child'] as $k => $child)
                                                <li>
                                                    <a  href="{{URL::route('site.cate',array('gid' => $group['group_category_id'],'id' => $k,'name' => FunctionLib::safe_title($child)))}}" title="{{$child}}">{{$child}}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                @if($i%5 == 0)
                                    <div class="clearfix"></div>
                                @endif
                                <?php $i++?>
                                @endforeach
                            </ul>
                            {{--<img src="{{asset('assets/site/image/img-nav.png', false)}}" alt="" class="img-cate">--}}
                        </div>
                    </div>
                </li>
                <a class="nav-title" href="{{URL::route('site.companyInfo')}}"><li class="menu-nav-title">Giới thiệu</li></a>
                <a class="nav-title" href="{{URL::route('site.news')}}"><li class="menu-nav-title">Tin tức</li></a>
                <a class="nav-title" href="{{URL::route('site.contact')}}"><li class="menu-nav-title">Liên hệ</li></a>
            </ul>
            <a href="{{URL::route('site.download')}}" class="nav-download"><img src="{{asset('assets/site/image/btn-download.png', false)}}" alt="" class="img-cate"></a>
        </div>
    </div>
    {{$content}}
    <div id="footer">
        <div class="container clearfix">
            <div class="footer-top clearfix">
                <ul class="rs company-info make-left">
                    <div class="footer-title">Địa chỉ</div>
                    <li class="clearfix">
                        <i class="icons iHome make-left"></i>
                        <div class="make-left">Số 64, Phố Yên Bái 2, Phường Phố Huế, Quận Hai Bà Trưng, Hà Nội</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iPhone make-left"></i>
                        <div class="make-left">(04) 6657 2888 | (04) 6688 0415</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iMail make-left"></i>
                        <div class="make-left">vpp@banbuonvpp.vn</div>
                    </li>
                </ul>
                <ul class="rs company-ext make-left">
                    <div class="footer-title">Chính sách</div>
                    @if($page_menu)
                        @foreach($page_menu as $me)
                            @if($me['page_status'] == 1 && $me['page_type'] == 1)
                                <a href="{{URL::route('site.page',array('id' => $me['page_id'],'name' => FunctionLib::safe_title($me['page_name'])))}}">
                                    <li class="clearfix">
                                        <i class="icons iLi make-left"></i>

                                        <div class="make-left">{{$me['page_name']}}</div>
                                    </li>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <ul class="rs company-ext make-left">
                    <div class="footer-title">Hỗ trợ</div>
                    @if($page_menu)
                        @foreach($page_menu as $me)
                            @if($me['page_status'] == 1 && $me['page_type'] == 2)
                                <a href="{{URL::route('site.page',array('id' => $me['page_id'],'name' => FunctionLib::safe_title($me['page_name'])))}}">
                                    <li class="clearfix">
                                        <i class="icons iLi make-left"></i>

                                        <div class="make-left">{{$me['page_name']}}</div>
                                    </li>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <div class="make-right footer-km">
                    <div class="footer-title">Nhận tin khuyến mại</div>
                    <div class="km-des clearfix">Đăng ký để nhận tin khuyến mãi và ưu đãi mới nhất từ chúng tôi</div>
                    <div class="frm-mail clearfix">
                        <div class="txt-mail make-left">
                            <input type="text" class="input-email-km">
                        </div>
                        <div class="btn-mail-km make-left">
                            <i class="icons iBay"></i>
                        </div>
                    </div>
                    <div class="social clearfix">
                        <div class="social-icon make-left"><i class="icons iFacebook"></i></div>
                        <div class="social-icon make-left"><i class="icons iTwice"></i></div>
                        <div class="social-icon make-left"><i class="icons iGoogle"></i></div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom clearfix">
                Copyright 2016 © ThieuSon Co., Ltd. All Rights Reserved.
                <i class="icons iAmerica make-right"></i>
                <i class="icons iVisa make-right"></i>
                <i class="icons iPaypal make-right"></i>
            </div>
        </div>
    </div>
    <div class="fix-wrap">
        <div class="container">
            <a href="{{URL::route('site.download')}}" class="baogia"><img src="{{asset('assets/site/image/download.png')}}" alt="báo giá"></a>
            <div class="fix__title">Quý khách gọi hàng hoặc liên hệ dịch vụ vui lòng liên lạc</div>
            <div class="fix__contact">
                <div class="fix__phone"><i class="icon iCall"></i><span class="fix__phone__txt">04 6657 2888 / 04 6686 0415</span></div>
                <div class="fix__email">Hoặc email: <i class="icon iEmail"></i><span class="fix__email__txt">vpp@banbuonvpp.vn</span></div>
            </div>
{{--            <a href="#" class="message">
                <span class="message__txt">Hỗ trợ trực tuyến:</span>
                <span class="message__count">1</span>
            </a>--}}
        </div>
    </div>
    <a style="display: none;" href="javascript:void(0)" id="toTop"><i class="icons iTop"></i></a>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=777931142319139";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".lbl-search").on('click', function (e) {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open')
            } else {
                $(this).addClass('open')
            }
            e.stopPropagation();
        });
        $(".search-item").on('click',function(){
            $(".search-item").removeClass('active');
            $(this).addClass('active');
            $(".txt-cate-search").html($(this).html());
        });
        $('body').on('click',function(){
            $(".lbl-search").removeClass('open')
        });

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

        $("#sys_keyword").on('keypress', function (event) {
            if (event.which == 13 || event.keyCode == 13) {
                var g = 0;
                var key = $(this).val().trim();
                $(".search-item").each(function () {
                    if($(this).hasClass('active')){
                        g = $(this).data('id');
                    }
                });
                if(key.length < 3){
                    return false;
                }else{
                    window.location.href = '/tim-kiem.html?q=' + key + '&g=' + g;
                }

            }
        });
        $(".sys_btn_search").on('click',function(){
            var g = 0;
            var key = $("#sys_keyword").val().trim();
            $(".search-item").each(function () {
                if($(this).hasClass('active')){
                    g = $(this).data('id');
                }
            });
            if(key.length < 3){
                return false;
            }else{
                window.location.href = '/tim-kiem.html?q=' + key + '&g=' + g;
            }
        })
        <!--Start of Tawk.to Script-->
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/585cad32ddb8373fd2b23b5c/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
        <!--End of Tawk.to Script-->
    });
</script>
</body>
</html>