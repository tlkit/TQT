<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    {{ HTML::style('assets/site/css/style.css') }}
    {{ HTML::script('assets/site/js/jquery-1.js') }}
    {{ HTML::style('assets/site/css/slick.css') }}
    {{ HTML::script('assets/site/js/slick.min.js') }}
</head>
<body>
<div class="container-page">
    <div id="header">
        <div class="header-top clearfix">
            {{--<div class="make-right pl-30"><a href="" class="fc-grey-1">Đăng ký</a></div>
            <div class="make-right pl-30"><a href="" class="fc-grey-1">Đăng nhập</a></div>--}}
            <div class="make-right pl-30 user-login">
                <a href="" class="fc-grey-1">Hi ! Nguyễn Anh Tuấn</a>
                <div class="user-login-info">
                    <i class="icon-down2"></i>
                    <div class="user-login-item active">
                        <i class="icons iUsers"></i>
                        <a href="">Quản lý tài khoản</a>
                    </div>
                    <div class="user-login-item">
                        <i class="icons iLists"></i>
                        <a href="">Quản lý đơn hàng</a>
                    </div>
                    <div class="user-login-item active">
                        <i class="icons iHearts"></i>
                        <a href="">Danh sách yêu thích</a>
                    </div>
                    <div class="user-login-item active">
                        <i class="icons iOut"></i>
                        <a href="">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div class="make-right pl-30"><a href="" class="fc-grey-1">Yêu thích</a></div>
        </div>
        <div class="header-mid clearfix">
            <a class="make-left" href=""><i class="iLogo"></i></a>
            <div class="mid-cart make-right">
                <a href="">
                    <i class="icons iCart make-left"></i>
                    <div class="cart-count make-left">
                        <div class="fs-14 fc-blue-1">Giỏ hàng</div>
                    </div>
                    <div class="number-cart" id="" data-count="1">1</div>
                </a>
                <div class="cart-hover">
                    <div class="cart-hover-content">
                        <div class="cart-item clearfix mb-20">
                            <div class="wrap-img make-left"></div>
                            <div class="cart-item-des make-left ml-10">
                                <div class="cart-item-title"><a href="">Máy in giấy Deli387 4444 444</a></div>
                                <div class="price-cart-item">
                                <span class="price-dx-deal">
                                    900.000<span>đ</span>
                                </span>
                                </div>
                                <i class="icons iTrack"></i>
                            </div>
                        </div>
                        <div class="cart-item clearfix mb-20">
                            <div class="wrap-img make-left"></div>
                            <div class="cart-item-des make-left ml-10">
                                <div class="cart-item-title"><a href="">Máy in giấy Deli387 4444 444</a></div>
                                <div class="price-cart-item">
                                <span class="price-dx-deal">
                                    900.000<span>đ</span>
                                </span>
                                </div>
                                <i class="icons iTrack"></i>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="cart-total mb-20">
                            Tạm tính : <span class="price"> 1.000.000<span>đ</span></span>
                        </div>
                        <div class="cart-view">
                            <a href="" class="btn-view-cart">Xem giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mid-searchbox clearfix">
                <div class="lbl-search make-left">
                    <div class="txt-cate-search make-left" title="Dụng cụ vệ sinh - chất tẩy rửa">
                        Dụng cụ vệ sinh - chất tẩy rửa
                    </div>
                    <div class="make-left">
                        <i class="icons iDown"></i>
                    </div>
                    <div class="search-cate">
                        <div class="search-item active" id="0">Tất cả</div>
                        <div class="search-item" id="591">Thực Phẩm</div>
                        <div class="search-item" id="322">Mobile &amp; Tablet</div>
                        <div class="search-item" id="1773">Điện gia dụng</div>
                        <div class="search-item" id="321">Điện tử &amp; Công nghệ</div>
                        <div class="search-item" id="1">Thời trang</div>
                        <div class="search-item" id="139">Sức khỏe &amp; Sắc đẹp</div>
                    </div>
                </div>
                <div class="frm-search make-left fs-14">
                    <label for="sys_keyword">
                        <input id="sys_keyword" name="keyword" placeholder="Nhập từ khóa để tìm kiếm..." autocomplete="off" value="" data-id="0" type="text">
                    </label>
                    <button class="btn-search" type="button"><i class="icons iSearch"></i></button>
                </div>
            </div>
        </div>
        <div class="header-nav clearfix">
            <ul class="menu-nav rs">
                <li class="menu-nav-title"><a class="nav-title" href="">Trang chủ</a></li>
                <li class="menu-nav-title has-sub">
                    <a href="" class="nav-title">Sản phẩm</a>
                    <i class="icon-down"></i>
                    <div class="sub-menu clearfix">
                        <div class="height-15 make-left">

                        </div>
                        <div class="nav-content make-left clearfix">
                            <ul class="rs parent-cate">
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                                <div class="clearfix"></div>
                                <li class="parent-cate-title fs-14 fc-grey-2 make-left">
                                    Sản phẩm từ giấy
                                    <ul class="rs">
                                        <li><a href="">Giấy in- Giấy Photo</a></li>
                                        <li><a href="">Giấy nhớ - Giấy phân trang</a></li>
                                        <li><a href="">Bìa màu - Bìa Mica</a></li>
                                        <li><a href="">Giấy in ảnh - Giấy niêm phong</a></li>
                                        <li><a href="">Giấy Fax - Film Fax - Giấy than</a></li>
                                        <li><a href="">Decan - Nhãn dán</a></li>
                                    </ul>
                                </li>
                            </ul>
                            {{--<img src="{{asset('assets/site/image/img-nav.png', false)}}" alt="" class="img-cate">--}}
                        </div>
                    </div>
                </li>
                <li class="menu-nav-title"><a class="nav-title" href="">Giới thiệu</a></li>
                <li class="menu-nav-title"><a class="nav-title" href="">Tin tức</a></li>
                <li class="menu-nav-title"><a class="nav-title" href="">Liên hệ</a></li>
            </ul>
            <a href="" class="nav-download"><img src="{{asset('assets/site/image/btn-download.png', false)}}" alt="" class="img-cate"></a>
        </div>
    </div>
    <div id="page-content">
        <div class="container clearfix">
            <div class="breadcrumb clearfix">
                <a class="make-left" href="">Trang chủ</a>
                <div class="make-left">
                    <i class="icons iRightB"></i><a href="">Chăm sóc mặt</a>
                </div>
                <div class="make-left">
                    <i class="icons iRightB"></i><a href="">Chăm sóc mặt</a>
                </div>
            </div>
            <div class="full-width box-right box-like">
                <div class="box-like-title clearfix">
                    Sản phẩm yêu thích
                </div>
                <div class="box-like-product">
                    <div class="wrap-img make-left">
                        <img src="{{asset('assets/site/image/like-1.png', false)}}" alt="">
                    </div>
                    <div class="product-des make-left ml-20">
                        <div class="product-title"><a href="">Bàn làm việc chất gỗ tốt</a></div>
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
                    </div>
                    <div class="make-right mt-30 mr-25 btn">
                        <i class="icons iDel"></i>
                    </div>
                    <div class="btn make-right mr-25 mt-20 btn-buy-like">
                        Thêm vào giỏ hàng
                    </div>
                </div>
                <div class="box-like-product">
                    <div class="wrap-img make-left">
                        <img src="{{asset('assets/site/image/like-1.png', false)}}" alt="">
                    </div>
                    <div class="product-des make-left ml-20">
                        <div class="product-title"><a href="">Bàn làm việc chất gỗ tốt</a></div>
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
                    </div>
                    <div class="make-right mt-30 mr-25 btn">
                        <i class="icons iDel"></i>
                    </div>
                    <div class="btn make-right mr-25 mt-20 btn-buy-like">
                        Thêm vào giỏ hàng
                    </div>
                </div>
                <div class="box-like-product">
                    <div class="wrap-img make-left">
                        <img src="{{asset('assets/site/image/like-1.png', false)}}" alt="">
                    </div>
                    <div class="product-des make-left ml-20">
                        <div class="product-title"><a href="">Bàn làm việc chất gỗ tốt</a></div>
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
                    </div>
                    <div class="make-right mt-30 mr-25 btn">
                        <i class="icons iDel"></i>
                    </div>
                    <div class="btn make-right mr-25 mt-20 btn-buy-like">
                        Thêm vào giỏ hàng
                    </div>
                </div>
                <div class="box-like-product">
                    <div class="wrap-img make-left">
                        <img src="{{asset('assets/site/image/like-1.png', false)}}" alt="">
                    </div>
                    <div class="product-des make-left ml-20">
                        <div class="product-title"><a href="">Bàn làm việc chất gỗ tốt</a></div>
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
                    </div>
                    <div class="make-right mt-30 mr-25 btn">
                        <i class="icons iDel"></i>
                    </div>
                    <div class="btn make-right mr-25 mt-20 btn-buy-like">
                        Thêm vào giỏ hàng
                    </div>
                </div>
                <div class="box-like-product">
                    <div class="wrap-img make-left">
                        <img src="{{asset('assets/site/image/like-1.png', false)}}" alt="">
                    </div>
                    <div class="product-des make-left ml-20">
                        <div class="product-title"><a href="">Bàn làm việc chất gỗ tốt</a></div>
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
                    </div>
                    <div class="make-right mt-30 mr-25 btn">
                        <i class="icons iDel"></i>
                    </div>
                    <div class="btn make-right mr-25 mt-20 btn-buy-like">
                        Thêm vào giỏ hàng
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
                </ul>
                <ul class="rs company-ext make-left">
                    <div class="footer-title">Hỗ trợ</div>
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
                    <li class="clearfix">
                        <i class="icons iLi make-left"></i>
                        <div class="make-left">Chính sách thanh toán</div>
                    </li>
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

</div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#banner").slick({
            prevArrow : '<div class="banner-home-prev"><i class="icons icon-banner-home-prev"></i></div>',
            nextArrow : '<div class="banner-home-next"><i class="icons icon-banner-home-next"></i></div>'
        });
        $(".slide-deal-km").slick({
            prevArrow : '<div class="deal-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="deal-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-cate").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            variableWidth:true,
            prevArrow : '<div class="cate-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="cate-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-hot").slick({
            rows: 2,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-hott").slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-brand").slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow : '<div class="brand-prev"><i class="icons iPrev2"></i></div>',
            nextArrow : '<div class="brand-next"><i class="icons iNext2"></i></div>'
        });
    })
</script>