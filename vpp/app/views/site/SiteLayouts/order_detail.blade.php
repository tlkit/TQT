<div id="content">
    <h1>Thông tin đơn hàng</h1>
    <table class="list">
        <thead>
        <tr>
            <td class="left">Chi tiết</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 100%;" class="left">          <b>Mã đơn hàng:</b> #{{$order['order_id']}}<br>
                <b>Ngày đặt hàng:</b> {{date('d/m/Y',$order['order_create_time'])}}</td>
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
                {{$order['customers_name']}}<br>
                {{$order['customers_phone']}}<br>
                {{$order['customers_address']}}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="list">
        <thead>
        <tr>
            <td class="left">Sản phẩm</td>
            <td class="right">Quantity</td>
            <td class="right">Đơn giá(VNĐ)</td>
            <td class="right">Thành tiền(VNĐ)</td>
        </tr>
        </thead>
        <tbody>
        @foreach($item as $i)
        <tr>
            <td class="left">{{$i['product_name']}}</td>
            <td class="right">{{$i['product_num']}}</td>
            <td class="right">{{number_format($i['product_price'],0,'.','.')}}</td>
            <td class="right">{{number_format($i['order_item_price'],0,'.','.')}}</td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td class="right"><b>Tổng thanh toán:</b></td>
            <td class="right">{{number_format($order['order_price_total'],0,'.','.')}}</td>
        </tr>
        </tfoot>
    </table>
    <div class="buttons">
        <div class="right">
            <input type="button" onclick="window.location='{{URL::route('site.order_history')}}'" class="button" value="Tiếp tục">
        </div>
    </div>
</div>