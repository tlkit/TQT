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
            <b>PHIẾU NHẬP KHO</b>
        </div>
        <div style="clear: both"></div>
        <div style="float: left;text-align:center;">
            Ngày nhập kho : {{date('d/m/Y',$import['import_create_time'])}}
        </div>
        <div style="clear: both"></div>
        <div style="float:left;text-align: right;width: 100%">No : {{$import['import_code']}}</div>
        <div style="clear: both"></div>
        <div>
            Nhà cung cấp : {{$providers['providers_Name']}}
        </div>
        <br/>
        <div style="clear: both"></div>
        <table border="1" cellspacing="0" cellpadding="1" width="100%">
            <thead>
            <tr>
                <td align="center" width="5%"><b>STT</b></td>
                <td align="center" width="15%"><b>Mã hàng</b></td>
                <td align="center" width="33%"><b>Tên hàng hóa</b></td>
                <td align="center" width="13%"><b>Xuất xứ</b></td>
                <td align="center" width="7%"><b>ĐVT</b></td>
                <td align="center" width="10%"><b>Đơn giá</b></td>
                <td align="center" width="10%"><b>Số lượng</b></td>
                <td align="center" width="12%"><b>Thành tiền</b></td>
            </tr>
            </thead>
            <tbody>
            @foreach($importProduct as $key => $value)
                <tr>
                    <td align="center">{{$key+1}}</td>
                    <td align="center">{{$value['product']['product_Code']}}</td>
                    <td><div style="margin-left: 5px">{{$value['product']['product_Name']}}</div></td>
                    <td align="center">{{$value['product']['product_NameOrigin']}}</td>
                    <td align="center">{{$value['product']['product_NameUnit']}}</td>
                    <td align="right">{{number_format($value['import_product_price'], 0, ',', '.');}}</td>
                    <td align="center">{{$value['import_product_num']}}</td>
                    <td align="right"><b>{{number_format($value['import_product_total'], 0, ',', '.');}}</b></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: center">
                    <b>Tổng tiền hàng</b>
                </td>
                <td colspan="5" style="text-align: right">
                    <b class="red">{{number_format($import['import_price'], 0, ',', '.');}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">
                    <b>Chiết khấu</b>
                </td>
                <td colspan="5" style="text-align: right">
                    <b class="red">{{number_format($import['import_pay_discount'], 0, ',', '.');}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">
                    <b>Tổng nhập</b>
                </td>
                <td colspan="5" style="text-align: right">
                    <b class="red">{{number_format($import['import_pay_total'], 0, ',', '.');}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: left">
                    <i>Bằng chữ : {{FunctionLib::numberToWord($import['import_pay_total'])}}</i>
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