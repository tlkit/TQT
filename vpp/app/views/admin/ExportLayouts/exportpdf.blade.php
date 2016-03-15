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
                    <b style="color: #136194;">VPGD: Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội.</b><br/>
                    <b style="color: #136194;">ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline:
                        0973323333</b><br/>
                    <b style="color: #136194;"><span style="padding-right: 20px;color: #136194;">Website : http://banbuonvpp.vn</span>  Email:
                        vpp@banbuonvpp.vn</b><br/>
                </td>
            </tr>
        </table>
        <div style="clear: both"></div>
        <div style="float: left;text-align: center;width: 100%">
            <b>PHIẾU XUẤT KHO</b>
        </div>
        <div style="clear: both"></div>
        <div style="float: left;text-align:center;width: 100%">
            Ngày xuất kho : {{date('d/m/Y',$export['export_create_time'])}}
        </div>
        <div style="clear: both"></div>
        <div style="float:left;width: 100%;text-align: right">No : {{$export['export_code']}}</div>
        <div style="clear: both"></div>
        <div style="float: left;line-height: 0.5">
            <p>Đơn vị nhận hàng : {{$export['export_customers_name']}}</p>
            <p>Địa chỉ giao hàng : {{$export['export_customers_address']}}</p>
            <p>Người liên hệ : {{$export['export_user_customer']}}</p>
            @if($export['export_customer_phone'])
            <p>Điện thoại : {{$export['export_customer_phone']}}</p>
            @endif
        </div>
        <div style="clear: both"></div>
        <table cellspacing="0" cellpadding="1" width="100%" border="1">
            <thead>
            <tr style="">
                <td align="center" width="5%"><b>STT</b></td>
                <td align="center" width="10%"><b>Mã hàng</b></td>
                <td align="center" width="33%"><b>Tên hàng hóa</b></td>
                <td align="center" width="13%"><b>Xuất xứ</b></td>
                <td align="center" width="7%"><b>ĐVT</b></td>
                <td align="center" width="10%"><b>Đơn giá</b></td>
                <td align="center" width="5%"><b>SL</b></td>
                <td align="center" width="12%"><b>Thành tiền</b></td>
            </tr>
            </thead>
            <tbody>
            @foreach($exportProduct as $key => $value)
                <tr>
                    <td align="center">{{$key+1}}</td>
                    <td align="center">{{$value['product']['product_Code']}}</td>
                    <td><div style="margin-left: 5px;">{{$value['product']['product_Name']}}</div></td>
                    <td align="center">{{$value['product']['product_NameOrigin']}}</td>
                    <td align="center">{{$value['product']['product_NameUnit']}}</td>
                    <td align="right">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
                    <td align="center">{{$value['export_product_num']}}</td>
                    <td align="right"><b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>
                    <b style="margin-left: 5px;">Cộng tiền hàng</b>
                </td>
                <td colspan="5" align="right">
                    <b>{{number_format($export['export_subtotal'], 0, ',', '.');}}</b>
                </td>
            </tr>
            @if($export['export_discount'] > 0)
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <b style="margin-left: 5px;">Chiết khấu</b>
                    </td>
                    <td colspan="5" align="right">
                        <b>{{number_format($export['export_discount'], 0, ',', '.');}}</b>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <b style="margin-left: 5px;">Tổng tiền hàng</b>
                    </td>
                    <td colspan="5" align="right">
                        <b>{{number_format($export['export_total'], 0, ',', '.');}}</b>
                    </td>
                </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td>
                    <b style="margin-left: 5px;">Thuế GTGT</b>
                </td>
                <td colspan="5" align="right">
                    <b>{{number_format($export['export_vat'], 0, ',', '.');}}</b>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <b style="margin-left: 5px;">Tổng thanh toán</b>
                </td>
                <td colspan="5" align="right">
                    <b>{{number_format($export['export_total_pay'], 0, ',', '.');}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <i>Bằng chữ : {{FunctionLib::numberToWord($export['export_total_pay'])}}</i>
                </td>
            </tr>
            </tbody>
        </table>
        @if($export['export_note'] && $export['export_note'] != '')
        <p><i>Ghi chú : {{$export['export_note']}}</i></p>
        @else
            <br/>
        @endif
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