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
            <b>BẢNG GIÁ</b>
        </div>
        <div style="float: left;text-align:center;width: 100%">
            Ngày xuất : {{date('d/m/Y',time())}}
        </div>
        <div style="clear: both"></div>
        <div>
            <br/>
            Đơn vị : {{$customer['customers_FirstName']}}
            @if($customer['customers_Phone'] || $customer['customers_Email'])
                <br/>
                @if($customer['customers_Phone'])
                    Điện thoại : {{$customer['customers_Phone']}}.
                @endif
                @if($customer['customers_Email'])
                    Email : {{$customer['customers_Email']}}.
                @endif
            @endif

            @if($customer['customers_ContactAddress'])
            <br/>
            Địa chỉ : {{$customer['customers_ContactAddress']}}
            @endif
        </div>
        <div style="clear: both"></div>
        <br>
        <table cellspacing="0" cellpadding="1" width="100%" border="1">
            <thead>
            <tr style="">
                <td style="text-align: center" width="5%"><b>STT</b></td>
                <td style="text-align: center" width="15%"><b>Mã hàng</b></td>
                <td style="text-align: center" width="35%"><b>Tên hàng hóa</b></td>
                <td style="text-align: center" width="10%"><b>Xuất xứ</b></td>
                <td style="text-align: center" width="10%"><b>ĐVT</b></td>
                <td style="text-align: center" width="10%"><b>Đơn giá</b></td>
                <td style="text-align: center" width="5%"><b>SL</b></td>
                <td style="text-align: center" width="15%"><b>Thành tiền</b></td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;$total = 0;?>
            @foreach($list as $key => $value)
                <tr>
                    <?php $total_item = $value['product_price']*$value['product_num'];?>
                    <td style="text-align: center">{{$i+1}}</td>
                    <td style="text-align: center">{{$value['product_Code']}}</td>
                    <td><div style="margin-left: 5px;">{{$value['product_Name']}}</div></td>
                    <td style="text-align: center">{{$value['product_NameOrigin']}}</td>
                    <td style="text-align: center">{{$value['product_NameUnit']}}</td>
                    <td style="text-align: right">{{number_format($value['product_price'], 0, ',', '.');}}</td>
                    <td style="text-align: center">{{$value['product_num']}}</td>
                    <td style="text-align: right">{{number_format($total_item, 0, ',', '.');}}</td>
                </tr>
                <?php $i++; $total += $total_item;?>
            @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: left;">
                        <b style="padding-left: 5px">Cộng tiền hàng</b>
                    </td>
                    <td colspan="5" style="text-align: right;">
                        <b class="red">{{number_format($total, 0, ',', '.');}}</b>
                    </td>
                </tr>
                <?php $vat = $customer['customers_IsNeededVAT'] ? (int)($total*10/100) : 0;?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: left;">
                        <b style="padding-left: 5px">Thuế GTGT</b>
                    </td>
                    <td colspan="5" style="text-align: right;">
                        <b class="red">{{number_format($vat, 0, ',', '.');}}</b>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: left;">
                        <b style="padding-left: 5px">Tổng thanh toán</b>
                    </td>
                    <td colspan="5" style="text-align: right;">
                        <b class="red">{{number_format($total+$vat, 0, ',', '.');}}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: left;">
                        <i>Bằng chữ : {{FunctionLib::numberToWord($total+$vat)}}</i>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>