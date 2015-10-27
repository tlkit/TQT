<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hệ thống xuất nhập kho bán buôn văn phòng phẩm</title>
    <style type="text/css">

        * {
            font-family: "DejaVu Serif","Times-Roman";
            font-size: 13px;
            color: black;
        }

    </style>
</head>
<body>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr style="">
        <td style="width: 15%">
            <span style=""><img src="{{URL::asset('assets/admin/img/logo.jpg')}}" alt=""/></span>
        </td>
        <td style="text-align: left;width: 85%" valign="top">
            <b style="color: #002a80;">CÔNG TY TNHH THƯƠNG MẠI & DỊCH VỤ THIỀU SƠN</b><br/>
            <b style="color: #136194;">VPGD: Số 35, Phố Nguyễn Văn Trỗi, Phương Liệt, Thanh Xuân, Hà Nội.</b><br/>
            <b style="color: #136194;">ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline:
                0973323333</b><br/>
            <b style="color: #136194;"><span style="padding-right: 20px;color: #136194;">Website : http://banbuonvpp.vn</span>  Email:
                vpp@banbuonvpp.vn</b><br/>
        </td>
    </tr>
</table>
<div style="clear: both"></div>
<div style="float: left;text-align: center;width: 100%">
    <b>BẢNG KÊ BÁN HÀNG</b>
</div>
<div style="clear: both"></div>
<div style="float: left;text-align:center;width: 100%">
    <span>Ngày xuất : {{date('d/m/Y',$sale_list['sale_list_create_time'])}}</span>
    @if($sale_list['sale_list_bill'] != '')
        <span style="padding-left: 20px">Kèm HĐGTGT số {{$sale_list['sale_list_bill']}}</span>
    @endif
</div>
<div style="clear: both"></div>
<div style="float:left;width: 100%;text-align: right">No : {{$sale_list['sale_list_code']}}</div>
<div style="clear: both"></div>
<div style="float: left;line-height: 0.5">
    <p>Đơn vị mua hàng : {{$customer['customers_FirstName']}}</p>
    <p>Địa chỉ : {{$customer['customers_BizAddress']}}</p>
    @if($customer['customers_TaxCode'] != '')
        <p>MST : {{$customer['customers_TaxCode']}} .</p>
    @endif
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="1" width="100%" border="1">
    <thead>
    <tr style="">
        <td width="5%" style="text-align: center;"><b>STT</b></td>
        <td width="10%" style="text-align: center;"><b>Mã hàng</b></td>
        <td width="35%" style="text-align: center;"><b>Tên hàng hóa</b></td>
        <td width="12%" style="text-align: center;"><b>Xuất xứ</b></td>
        <td width="10%" style="text-align: center;"><b>ĐVT</b></td>
        <td width="10%" style="text-align: center;"><b>Đơn giá</b></td>
        <td width="5%" style="text-align: center;"><b>SL</b></td>
        <td width="13%" style="text-align: center;"><b>Thành tiền</b></td>
    </tr>
    </thead>
    <tbody>
    <?php $sub_total = 0;$discount = 0;?>
    @foreach($product as $key => $value)
        <tr>
            <td style="text-align: center;">{{$key+1}}</td>
            <td style="text-align: center;">{{$value['product']['product_Code']}}</td>
            <td style="">
                <div style="margin-left: 5px">{{$value['product']['product_Name']}}</div>
            </td>
            <td style="text-align: center;">{{$value['product']['product_NameOrigin']}}</td>
            <td style="text-align: center;">{{$value['product']['product_NameUnit']}}</td>
            <td style="text-align: right;">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
            <td style="text-align: center;">{{$value['export_product_num']}}</td>
            <td style="text-align: right;">
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
<br/>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td width="33%" style="text-align: center;">
            <span>Người bán hàng</span><br/>
            <span>(Ký, họ tên)</span>
        </td>
        <td width="33%" style="text-align: center;">
        </td>
        <td width="34%" style="text-align: center;">
            <span>Người mua hàng</span><br/>
            <span>(Ký, họ tên)</span>
        </td>
    </tr>
</table>
</body>
</html>