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
            <span style=""><img src="/assets/admin/img/logo.png" alt="" width="60px" height="90px"/></span>
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
    <b>PHIẾU NHẬP KHO</b>
</div>
<div style="float: left;text-align:center;position: relative;line-height: 0.7">
    Ngày nhập kho : {{date('d/m/Y',$import['import_create_time'])}}
</div>
<span style="text-align: right;">No : {{$import['import_code']}}</span>
<div style="clear: both"></div>
<div>
    Nhà cung cấp : {{$providers['providers_Name']}}
</div>
<div style="clear: both"></div>
<table border="0.3" cellspacing="0" cellpadding="3" width="100%">
    <thead class="thin-border-bottom">
    <tr style="">
        <td valign="middle" width="5%" style="text-align: center;"><b>STT</b></td>
        <td class="center" width="15%" style="text-align: center;"><b>Mã hàng</b></td>
        <td class="left" width="30%" style="text-align: center;"><b>Tên hàng hóa</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Xuất sứ</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>ĐVT</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Đơn giá</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Số lượng</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Thành tiền</b></td>
    </tr>
    </thead>
    <tbody>
    @foreach($importProduct as $key => $value)
        <tr>
            <td width="5%" style="text-align: center;">{{$key+1}}</td>
            <td width="15%" style="text-align: center;"><b>{{$value['product']['product_Code']}}</b></td>
            <td width="30%" style=""><div style="margin-left: 5px">{{$value['product']['product_Name']}}</div></td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_OriginID']}}</td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_UnitID']}}</td>
            <td width="10%" style="text-align: right;">{{number_format($value['import_product_price'], 0, ',', '.');}}</td>
            <td width="10%" style="text-align: center;">{{$value['import_product_num']}}</td>
            <td width="10%" style="text-align: right;"><b>{{number_format($value['import_product_total'], 0, ',', '.');}}</b></td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="text-align: center">
            <b>Tổng nhập</b>
        </td>
        <td colspan="5" style="text-align: right">
            <b class="red">{{number_format($import['import_price'], 0, ',', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: left">
            <i>Bằng chữ : {{FunctionLib::numberToWord($import['import_price'])}}</i>
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