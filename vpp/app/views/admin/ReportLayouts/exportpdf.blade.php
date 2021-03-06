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
            <b style="color: #002a80;">CÔNG TY TNHH THƯƠNG MẠI & DỊCH VỤ THIỀU SƠN</b><br/>
            <b style="color: #136194;">VPGD: Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội. </b><br/>
            {{--<b style="color: #136194;">Cơ sở 1 : CC2 - Bắc Linh Đàm - Hoàng Mai - Hà Nội</b><br/>--}}
            {{--<b style="color: #136194;">Cơ sở 2 : 73, Phố Nguyễn Văn Trỗi, Thanh Xuân, Hà Nội</b><br/>--}}
            <b style="color: #136194;">ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline:
                0973323333</b><br/>
            <b style="color: #136194;">Website : http://banbuonvpp.vn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email:
                vpp@banbuonvpp.vn</b><br/>
            {{--<b><span style="color:black">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span></b><br/>--}}
            {{--<b><span style="color:black">Độc lập - Tự do - Hạnh phúc</span></b><br/>--}}
            {{------------------------------}}
        </td>
    </tr>
</table>
<div style="clear: both"></div>
<div style="float: left;text-align: center;line-height: 0.7">
    <b>BẢNG KÊ BÁN HÀNG</b>
</div>
<div style="float: left;text-align:center;position: relative;line-height: 0.7">
    Ngày xuất kho : {{date('d/m/Y',$input['export_time'])}}
    @if($input['bill_code'] != '')
        &nbsp;&nbsp;&nbsp;Kèm HĐGTGT số {{$input['bill_code']}}
    @endif
</div>
<span style="text-align: right;">No : BK{{$input['customers_id']}}{{date('d',$input['export_time'])}}{{date('m',$input['export_time'])}}{{date('y',$input['export_time'])}}</span>

<div style="clear: both"></div>
<div>
    <br/>
    Đơn vị mua hàng : {{$customer['customers_FirstName']}} .
    <br/>
    Địa chỉ : {{$customer['customers_BizAddress']}} .
    @if($customer['customers_TaxCode'] != '')
        <br/>
        MST : {{$customer['customers_TaxCode']}} .
    @endif
</div>
<div style="clear: both"></div>
<table border="0.3" cellspacing="0" cellpadding="1" width="100%">
    <thead>
    <tr style="">
        <td valign="middle" width="5%" style="text-align: center;"><b>STT</b></td>
        <td class="center" width="15%" style="text-align: center;"><b>Mã hàng</b></td>
        <td class="left" width="35%" style="text-align: center;"><b>Tên hàng hóa</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Xuất xứ</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>ĐVT</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Đơn giá</b></td>
        <td class="center" width="5%" style="text-align: center;"><b>SL</b></td>
        <td class="center" width="10%" style="text-align: center;"><b>Thành tiền</b></td>
    </tr>
    </thead>
    <tbody>
    <?php $sub_total = 0;$discount = 0;?>
    @foreach($data as $key => $value)
        <tr>
            <td width="5%" style="text-align: center;">{{$key+1}}</td>
            <td width="15%" style="text-align: center;"><b>{{$value['product']['product_Code']}}</b></td>
            <td width="35%" style="">
                <div style="margin-left: 5px">{{$value['product']['product_Name']}}</div>
            </td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_NameOrigin']}}</td>
            <td width="10%" style="text-align: center;">{{$value['product']['product_NameUnit']}}</td>
            <td width="10%"
                style="text-align: right;">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
            <td width="5%" style="text-align: center;">{{$value['export_product_num']}}</td>
            <td width="10%" style="text-align: right;">
                <b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
            <?php $sub_total += $value['export_product_total'];?>
            <?php $discount += $value['export_product_discount'];?>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: left">
            <b>Cộng tiền hàng</b>
        </td>
        <td colspan="5" style="text-align: right">
            <b class="red">{{number_format($sub_total, 0, '.', '.');}}</b>
        </td>
    </tr>
    @if($discount > 0)
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: left">
                <b>Chiết khấu</b>
            </td>
            <td colspan="5" style="text-align: right">
                <b class="red">{{number_format($discount, 0, '.', '.');}}</b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: left">
                <b>Tổng tiền sau chiết khấu</b>
            </td>
            <td colspan="5" style="text-align: right">
                <b class="red">{{number_format((int)($sub_total - $discount), 0, '.', '.');}}</b>
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
            @if($customer['customers_IsNeededVAT'])
                <?php $vat = (int)(($sub_total - $discount) / 10);?>
            @else
                <?php $vat = 0;?>
            @endif
            <?php ?>
            <b class="red">{{number_format($vat, 0, '.', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: left">
            <b>Tổng tiền thanh toán</b>
        </td>
        <td colspan="5" style="text-align: right">
            <?php $total = $sub_total - $discount + $vat ;?>
            <b class="red">{{number_format($total, 0, '.', '.');}}</b>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: left">
            <i>Bằng chữ : {{FunctionLib::numberToWord($total)}}</i>
        </td>
    </tr>
    </tbody>
</table>
<br/><br/>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td width="33%" style="text-align: center;">
            <span>Người bán hàng</span><br/>
            <span>(Ký, họ tên)</span><br/><br/><br/><br/>
        </td>
        <td width="33%" style="text-align: center;">
        </td>
        <td width="34%" style="text-align: center;">
            <span>Người mua hàng</span><br/>
            <span>(Ký, họ tên)</span><br/><br/><br/><br/>
        </td>
    </tr>
</table>
</body>
</html>