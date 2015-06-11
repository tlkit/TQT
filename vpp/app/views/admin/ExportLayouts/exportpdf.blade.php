<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hệ thống xuất nhập kho bán buôn văn phòng phẩm</title>
</head>
<body link="blue" style="font-family: Arial">
<table border="0" cellspacing="0" cellpadding="0" valign="top">
    <tr style="">
        <td width="70" valign="top">
            <br/>
            <span style=""><img src="/assets/admin/img/logo.jpg" alt="" width="60px" height="90px"/></span>
        </td>
        <td width="530" valign="top" style="text-align: left">
            <br/>
            <b style="color: #002a80;">CÔNG TY TNHH THƯƠNG MẠI & VÀ DỊCH VỤ THIỀU SƠN</b><br/>
            <b style="color: #136194;">Trụ sở : Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, Hà Nội</b><br/>
            <b style="color: #136194;">Cơ sở 1 : CC2 - Bắc Linh Đàm - Hoàng Mai - Hà Nội</b><br/>
            <b style="color: #136194;">Cơ sở 2 : 73, Phố Nguyễn Văn Trỗi, Thanh Xuân, Hà Nội</b><br/>
            <b style="color: #136194;">ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline: 0973323333</b><br/>
            <b style="color: #136194;">Website : http://banbuonvpp.vn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Email: vpp@banbuonvpp.vn</b><br/>
            {{--<b><span style="color:black">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span></b><br/>--}}
            {{--<b><span style="color:black">Độc lập - Tự do - Hạnh phúc</span></b><br/>--}}
            {{------------------------------}}
        </td>
    </tr>
</table>
<div style="clear: both"></div>
<div style="float: left;text-align: center;line-height: 0.7">
    <b>PHIẾU XUẤT KHO</b>
</div>
<div style="float: left;text-align:center;position: relative;line-height: 0.7">
    Ngày xuất kho : {{date('d/m/Y',$export['export_create_time'])}}
</div>
<span style="text-align: right;">No : {{$export['export_code']}}</span>
<div style="clear: both"></div>
<div>
    <br/>
    Đơn vị nhận hàng : {{$export['export_customers_name']}}
    <br/>
    Địa chỉ giao hàng : {{$export['export_customers_address']}}
    <br/>
    Người liên hệ : {{$export['export_user_customer']}} .
    @if($export['export_customer_phone'])
        Điện thoại : {{$export['export_customer_phone']}}
    @endif
</div>
<div style="clear: both"></div>
<table border="0.3" cellspacing="0" cellpadding="3" width="100%">
    <thead>
    <tr style="">
        <td valign="middle" width="5%" style="text-align: center;"><b>STT</b></td>
        <td class="center" width="15%" style="text-align: center;"><b>Mã hàng</b></td>
        <td class="left" width="35%" style="text-align: center;"><b>Tên hàng hóa</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Xuất sứ</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>ĐVT</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Đơn giá</b></td>
        <td class="center" width="5%" style="text-align: center;"><b>SL</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Thành tiền</b></td>
    </tr>
    </thead>
    <tbody>
    @foreach($exportProduct as $key => $value)
        <tr>
            <td width="5%" style="text-align: center;">{{$key+1}}</td>
            <td width="15%" style="text-align: center;"><b>{{$value['product']['product_Code']}}</b></td>
            <td width="35%" style=""><div style="margin-left: 5px">{{$value['product']['product_Name']}}</div></td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_NameOrigin']}}</td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_NameUnit']}}</td>
            <td width="10%" style="text-align: right;">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
            <td width="5%" style="text-align: center;">{{$value['export_product_num']}}</td>
            <td width="10%" style="text-align: right;"><b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: left" >
            <b>Cộng tiền hàng</b>
        </td>
        <td colspan="5" style="text-align: right">
            <b class="red">{{number_format($export['export_subtotal'], 0, ',', '.');}}</b>
        </td>
    </tr>
    @if($export['export_discount'] > 0)
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: left">
                <b>Chiết khấu</b>
            </td>
            <td colspan="5" style="text-align: right">
                <b class="red">{{number_format($export['export_discount'], 0, ',', '.');}}</b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: left">
                <b>Tổng tiền hàng</b>
            </td>
            <td colspan="5" style="text-align: right">
                <b class="red">{{number_format($export['export_total'], 0, ',', '.');}}</b>
            </td>
        </tr>
    @endif
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: left">
            <b>Thuế GTGT</b>
        </td>
        <td colspan="5" style="text-align: right">
            <b class="red">{{number_format($export['export_vat'], 0, ',', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: left">
            <b>Tổng thanh toán</b>
        </td>
        <td colspan="5" style="text-align: right">
            <b class="red">{{number_format($export['export_total_pay'], 0, ',', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: left">
            <i>Bằng chữ : {{FunctionLib::numberToWord($export['export_total_pay'])}}</i>
        </td>
    </tr>
    </tbody>
</table>
<br/><br/>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td width="33%" style="text-align: center;">
            <span>Thủ kho</span><br/>
            <span>(Ký, họ tên)</span><br/><br/><br/><br/>
        </td>
        <td width="33%" style="text-align: center;">
            <span>Người giao hàng</span><br/>
            <span>(Ký, họ tên)</span><br/><br/><br/><br/>
        </td>
        <td width="34%" style="text-align: center;">
            <span>Người nhận hàng</span><br/>
            <span>(Ký, họ tên)</span><br/><br/><br/><br/>
        </td>
    </tr>
</table>
</body>
</html>