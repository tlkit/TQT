<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 7/3/14
 * Time: 9:41 AM
 * To change this template use File | Settings | File Templates.
 */
class CGlobal
{
    static $css_ver = 1.789;
    static $js_ver = 1.098;

    //Config phan trang.
    const PAGIN_LIMIT_DEFAULT = 30;

    static $status = array(
                1 => 'Hiện',
                0 => 'Ẩn',
    );

    static $category = array(
        1 => 'Nhà đất',
        2 => 'Nội, Ngoại thất',
        3 => 'Ô tô, xe máy',
        4 => 'Thời trang',
        5 => 'Mẹ và Bé',
        6 => 'Điện máy',
        7 => 'Việc làm',
        8 => 'Ẩm thực',
        9 => 'Dịch vụ và Giải trí',
        10 => 'Tổng hợp'
    );

    static $books = array(
        1 => 'Truyện kiếm hiêp',
        2 => 'Sách kinh doanh'
    );

    const money_per_up = 5000;
    const per_card = 0.87;
    const price_range_one = 150000;
    const price_range_two = 300000;
    const price_range_three = 500000;
    const price_range_four = 1000000;
    const price_range_five = 2000000;

    const orders_status_donhangmoi = 1;
    const orders_status_dangxuly = 2;
    const orders_status_huy = 3;
    const orders_status_dahoanthanh = 3;

    const orders_status_payment_finish = 1;
    const orders_status_payment_notfinish = 2;
    const orders_status_payment_cancel = 3;

    const orders_status_delivery_chuagiao = 1;
    const orders_status_delivery_chuanbigiao = 2;
    const orders_status_delivery_tienhanhgiao = 3;
    const orders_status_delivery_dagiao = 4;

    const orders_delivery_mc_giaohang = 3;
    const orders_delivery_giaohang = 2;
    const orders_delivery_cuahang = 1;
    const orders_delivery_plaza = 3;
    const orders_delivery_fee = 15000;

    const orders_payment_online = 1;
    const orders_payment_home = 2;
    const orders_payment_shop = 3;
    const orders_payment_wallet = 4;

    const orders_refund_denghi = 1;
    const orders_refund_xacnhan = 2;
    const orders_refund_duyet = 3;
    const orders_refund_khachnhan = 4;
    const orders_refund_huy = -1;

    const category_travel = 4;

    const pay_supplier_chuathanhtoan = 1;
    const pay_supplier_dathanhtoan = 2;

    //Const trang thai thanh toan sohapay
    const orders_payment_status_success = 1;
    const orders_payment_status_fail = 1;

    //Set title website
    public static $pageTitle = '';

    public static $aryProvince  = array(
//        1 => 'Toàn quốc',
        Area::app_obj_hn => 'Hà Nội',
        Area::app_obj_hcm => 'Hồ Chí Minh',
        Area::app_obj_dn => 'Đà Nẵng'
    );

    public static $actionLogOrders = array(
        1 => 'Đã tạo đơn hàng',
        2 => 'Đã gửi SMS',
        3 => 'Đã gửi email',
        4 => 'Đã active coupon'
    );

    public static $typeLogOrders = array(
        1 => 'Tạo đơn hàng từ frontend',
        2 => 'Tạo đơn hàng từ shop',
        3 => 'Tạo đơn hàng từ Admin'
    );

    public static $sourceLogOrders = array(
        1 => 'mua hàng từ trang chi tiết',
    );

    public static $arySortHome = array(
        1 => 'feed_home_campain_update',
        2 => 'campaign_count_view',
        3 => 'campaign_min_price_asc',
        4 => 'campaign_min_price_desc',
        5 => 'feed_home_score',
    );

    public static $aryTypeCard = array(
        'vinaphone' => 'Vinaphone',
        'mobifone' => 'Mobifone',
        'viettel' => 'Viettel',
        'vcoin' => 'VCOIN',
        'oncash' => 'Oncash',
    );

    public static $aryPaymentType = array(
        1 => 'Thẻ Visa/master',
        2 => 'Thẻ ATM',
        6 => 'Ví điện tử'
    );

    public static $aryBonusUp = array(
        50000 => array(
            'card' => 0,
            'money' => 0,
        ),
        100000 => array(
            'card' => 0,
            'money' => 5,
        ),
        200000 => array(
            'card' => 0,
            'money' => 10,
        ),
        500000 => array(
            'card' => 10,
            'money' => 40,
        ),
        1000000 => array(
            'card' => 30,
            'money' => 80,
        ),
        2000000 => array(
            'card' => 80,
            'money' => 200,
        ),
        5000000 => array(
            'card' => 300,
            'money' => 800,
        ),
        10000000 => array(
            'card' => 900,
            'money' => 2000,
        ),
    );

    public static $POS_HEAD = 1;
    public static $POS_END = 2;
    
    public static $extraHeaderCSS = '';
    public static $extraHeaderJS = '';
    public static $extraFooterCSS = '';
    public static $extraFooterJS = '';

    public static $optionStatus = array(
                                    0=>'Ẩn',
                                    1=>'Hiện'
    );

    public static $color_code = array(
        1 => '#EBCA7D',
        2 => '#9DE053',
        3 => '#E9BCB4',
        4 => '#E8C25B',
        5 => '#F19DBF',
        6 => '#7993A0',
        7 => '#3D9BF3',
        8 => '#51BF81',
        9 => '#B487FB',
        10 => '#A87D85',
        11 => '#5F9B8F',
        12 => '#AC8455',
        13 => '#ED8C4C',
        14 => '#E95F7D',
        15 => '#AD7895'
    );

    public static $arySort = array(
        'mac-dinh' => array(
            'name' => 'Sắp xếp theo',
            'order' => 'product_sale_time_up',
            'sort' => 'DESC'
        ),
        'moi-nhat' => array(
            'name' => 'Mới nhất',
            'order' => 'product_sale_time_up',
            'sort' => 'DESC'
        ),
        'gia-giam' => array(
            'name' => 'Giá giảm',
            'order' => 'product_price_sale',
            'sort' => 'DESC'
        ),
        'gia-tang' => array(
            'name' => 'Giá tăng',
            'order' => 'product_price_sale',
            'sort' => 'ASC'
        )
    );

    public static $arrBusiness = array(
        0 => 'Ngành nghề kinh doanh',
        1 => 'Bán hàng',
        2 => 'Bán hàng kỹ thuật',
        3 => 'Bán lẻ/Bán sỉ',
        4 => 'Bảo hiểm',
        5 => 'Bất động sản',
        6 => 'Biên phiên dịch',
        7 => 'Dệt may/Da giày',
        8 => 'Dịch vụ khách hàng',
        9 => 'Dược Phẩm/Công nghệ sinh học',
        10 => 'Giáo dục/Đào tạo',
        11 => 'Hàng không/Du lịch/Khách sạn',
        12 => 'Internet/Online Media',
        13 => 'Kiến trúc/Thiết kế nội thất',
        14 => 'Mỹ thuật/Thiết kế',
        15 => 'Tài chính/Đầu tư',
        16 => 'Thời trang/Lifestyle',
        17 => 'Thực phẩm & Đồ uống',
        18 => 'Tư vấn',
        19 => 'Viễn Thông',
        20 => 'Điện/Điện tử'
    );

    public static $orders_status = array(
        -1 => 'Khời tạo đơn hàng',
        0 => 'Đặt hàng chưa thành công',
        1 => 'Đơn hàng mới',
        2 => 'Đang xử lý',
        3 => 'Đã hủy',
        4 => 'Hoàn thành',
    );
    public static $orders_status_fillter = array(
        1 => 'Đơn hàng mới',
        2 => 'Đang xử lý',
        3 => 'Đã hủy',
        4 => 'Hoàn thành',
    );
    public static $orders_type = array(
        1 => 'Hàng',
        2 => 'Phiếu'
    );
    public static $orders_payment_method = array(
        1 => 'Thanh toán online', //Thanh toan online.
        2 => 'Thanh toán tận nơi', //Thanh toan tan noi
        3 => 'Thanh toán tại cửa hàng', //Thanh toan tai địa điểm lấy hàng.
        4 => 'Thanh toán bằng ví muachung', //Thanh toan tai địa điểm lấy hàng.
    );

    public static $orders_payment_method2 = array(
        1 => 'Online', //Thanh toan online.
        2 => 'COD', //Thanh toan tan noi
        3 => 'Tại cửa hàng', //Thanh toan tai địa điểm lấy hàng.
        4 => 'Ví muachung', //Thanh toan tai địa điểm lấy hàng.
    );
    
    public static $orders_delivery = array(
        1 => 'Đến cửa hàng', //Đến văn phòng lấy hàng.
        2 => 'Giao tận nhà', //Giao hàng tận nơi.
        3 => 'Giao hàng tận nhà + ship', //Giao hàng tận nơi + phí ship.
    );

    public static $orders_status_payment = array(
        self::orders_status_payment_finish => 'Đã thanh toán',
        self::orders_status_payment_notfinish => 'Chưa thanh toán',
        self::orders_status_payment_cancel => 'Hoàn tiền'
    );

    public static $orders_status_delivery = array(
        1 => 'Chưa giao',
        2 => 'Chuẩn bị giao',
        3 => 'Tiến hành giao',
        4 => 'Đã giao'
    );


    public static $refund_type = array(
        1 => 'Online',
        2 => 'Chuyển khoản',
        3 => 'Tiền mặt',
        4 => 'Gold'
    );

    const refund_type_online = 1;
    const refund_type_transfer = 2;
    const refund_type_money = 3;
    const refund_type_gold = 4;

    public static $refund_status = array(
        1 => 'Đề nghị',
        2 => 'Xác nhận hoàn',
        3 => 'Duyệt hoàn tiền',
        4 => 'Khách đã nhận tiền',
        -1 => 'Hủy hoàn');

    /*
     * QuynHTM add
     * Tình trạng của Coupon
     */
    const coupon_status_no_action = 1;///chờ kích hoạt
    const coupon_status_action = 2;//đã sử dụng
    const coupon_status_dealine = 3;//hêt hạn
    const coupon_status_block = 4;//bị khóa, đóng băng
    const coupon_status_cannel = 5;//bị hủy

    public static $coupon_status = array(
        self::coupon_status_no_action => 'Chờ kích hoạt',
        self::coupon_status_action => 'Đã sử dụng',
        self::coupon_status_dealine => 'Hết hạn',
        self::coupon_status_block => 'Bị khóa',
        self::coupon_status_cannel => 'Hủy'
    );


    public static $dayInWeek = array(
        2 => 'Thứ hai',
        3 => 'Thứ ba',
        4 => 'Thứ tư',
        5 => 'Thứ năm',
        6 => 'Thứ sáu',
        7 => 'Thứ bảy',
        8 => 'Chủ nhật'
    );

    public static $arrCategoryTravel = array(6, 13, 14, 25);

    public static $aryBankFee = array(
        0 => 'Miễn phí',
        7000 => '7.000 VNĐ',
        21000 => '21.000 VNĐ'
    );

    public static $aryUseCoupon = array(
        0 => 'Tất cả',
        1 => 'Đã sử dụng',
        2 => 'Chưa sử dụng'
    );

}