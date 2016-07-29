<div id="content">
    <h1>Thông tin xuất kho</h1>
    <table class="list">
        <thead>
        <tr>
            <td class="left">Chi tiết</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 100%;" class="left">          <b>Mã xuất kho:</b> #{{$export['export_code']}}<br>
                <b>Ngày xuất kho:</b> {{date('d/m/Y',$export['export_create_time'])}}</td>
        </tr>
        </tbody>
    </table>
    <table class="list">
        <thead>
        <tr>
            <td class="left">Thông tin giao hàng</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="left">
                {{$export['export_customers_name']}}<br>
                {{$export['export_customers_address']}}<br>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="list">
        <thead>
        <tr>
            <td class="left">Mã SP</td>
            <td class="left">Sản phẩm</td>
            <td class="right">Quantity</td>
            <td class="right">Đơn giá(VNĐ)</td>
            <td class="right">Thành tiền(VNĐ)</td>
        </tr>
        </thead>
        <tbody>
        @foreach($item as $value)
        <tr>
            <td class="left">{{$value['product']['product_Code']}}</td>
            <td class="left">{{$value['product']['product_Name']}}</td>
            <td class="right">{{$value['export_product_num']}}</td>
            <td class="right">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
            <td class="right">{{number_format($value['export_product_total'], 0, ',', '.');}}</td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td class="right"><b>Tổng tiền hàng:</b></td>
            <td class="right">{{number_format($export['export_subtotal'], 0, ',', '.');}}}</td>
        </tr>
        @if($export['export_discount'] > 0)
        <tr>
            <td colspan="3"></td>
            <td class="right"><b>Chiết khấu:</b></td>
            <td class="right">{{number_format($export['export_discount'], 0, ',', '.');}}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="right"><b>Tổng tiền:</b></td>
            <td class="right">{{number_format($export['export_total'], 0, ',', '.');}}}</td>
        </tr>
        @endif
        <tr>
            <td colspan="3"></td>
            <td class="right"><b>Thuế GTGT:</b></td>
            <td class="right">{{number_format($export['export_vat'], 0, ',', '.');}}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="right"><b>Tổng thanh toán:</b></td>
            <td class="right">{{number_format($export['export_total_pay'], 0, ',', '.');}}}</td>
        </tr>
        </tfoot>
    </table>
    <div class="buttons">
        <div class="right">
            <input type="button" onclick="window.location='{{URL::route('site.export_history')}}'" class="button" value="Tiếp tục">
        </div>
    </div>
</div>