<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hệ thống xuất nhập kho bán buôn văn phòng phẩm</title>
</head>
<body link="blue" style="font-family: Arial">
<table border="0" cellspacing="0" cellpadding="0" valign="top">
    <tr style="">
        <td width="60" valign="top">
            <br/>
            <span style=""><img src="/assets/admin/img/logo.jpg" alt="" width="40px" height="60px"/></span>
        </td>
        <td width="540" valign="top" style="text-align: left">
            <br/>
            <b style="color: #002a80;">CÔNG TY TNHH THƯƠNG MẠI & DỊCH VỤ THIỀU SƠN</b><br/>
            <b style="color: #136194;">VPGD: Số 35, Phố Nguyễn Văn Trỗi, Phương Liệt, Thanh Xuân, Hà Nội.</b><br/>
            {{--<b style="color: #136194;">Cơ sở 1 : CC2 - Bắc Linh Đàm - Hoàng Mai - Hà Nội</b><br/>--}}
            {{--<b style="color: #136194;">Cơ sở 2 : 73, Phố Nguyễn Văn Trỗi, Thanh Xuân, Hà Nội</b><br/>--}}
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
<table cellspacing="0" cellpadding="2" width="100%">
    <thead>
    <tr style="">
        <td valign="middle" width="5%" style="text-align: center;border: 0.1em solid grey"><b>STT</b></td>
        <td class="center" width="15%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>Mã hàng</b></td>
        <td class="left" width="35%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>Tên hàng hóa</b></td>
        <td class="center" width="10%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>Xuất xứ</b></td>
        <td class="center" width="10%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>ĐVT</b></td>
        <td class="center" width="10%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>Đơn giá</b></td>
        <td class="center" width="5%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>SL</b></td>
        <td class="center" width="10%" style="text-align: center;border-top: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>Thành tiền</b></td>
    </tr>
    </thead>
    <tbody>
    @foreach($exportProduct as $key => $value)
        <tr>
            <td width="5%" style="text-align: center;border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{$key+1}}</td>
            <td width="15%" style="text-align: center;text-align: center;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{$value['product']['product_Code']}}</td>
            <td width="35%" style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><div style="margin-left: 5px;">{{$value['product']['product_Name']}}</div></td>
            <td width="10%" style="text-align: center;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{$value['product']['product_NameOrigin']}}</td>
            <td width="10%" style="text-align: center;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{$value['product']['product_NameUnit']}}</td>
            <td width="10%" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
            <td width="5%" style="text-align: center;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">{{$value['export_product_num']}}</td>
            <td width="10%" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"><b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
        </tr>
    @endforeach
    <tr>
        <td style="border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="text-align: left;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey" >
            <b>Cộng tiền hàng</b>
        </td>
        <td colspan="5" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <b class="red">{{number_format($export['export_subtotal'], 0, ',', '.');}}</b>
        </td>
    </tr>
    @if($export['export_discount'] > 0)
        <tr>
            <td style="border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
            <td style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
            <td style="text-align: left;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
                <b>Chiết khấu</b>
            </td>
            <td colspan="5" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
                <b class="red">{{number_format($export['export_discount'], 0, ',', '.');}}</b>
            </td>
        </tr>
        <tr>
            <td style="border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
            <td style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
            <td style="text-align: left;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
                <b>Tổng tiền hàng</b>
            </td>
            <td colspan="5" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
                <b class="red">{{number_format($export['export_total'], 0, ',', '.');}}</b>
            </td>
        </tr>
    @endif
    <tr>
        <td style="border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="text-align: left;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <b>Thuế GTGT</b>
        </td>
        <td colspan="5" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <b class="red">{{number_format($export['export_vat'], 0, ',', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td style="border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="border-right: 0.1em solid grey;border-bottom: 0.1em solid grey"></td>
        <td style="text-align: left;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <b>Tổng thanh toán</b>
        </td>
        <td colspan="5" style="text-align: right;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <b class="red">{{number_format($export['export_total_pay'], 0, ',', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: left;border-left: 0.1em solid grey;border-right: 0.1em solid grey;border-bottom: 0.1em solid grey">
            <i>Bằng chữ : {{FunctionLib::numberToWord($export['export_total_pay'])}}</i>
        </td>
    </tr>
    </tbody>
</table>
@if($export['export_note'] && $export['export_note'] != '')
<p><i>Ghi chú : {{$export['export_note']}}</i></p>
@endif
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