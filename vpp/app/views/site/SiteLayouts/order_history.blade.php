<div id="content">
    <h1>Lịch sử đơn hàng</h1>
    @foreach($orders as $order)
    <div class="order-list">
        <div class="order-id"><b>Mã đơn hàng:</b> #{{$order['order_id']}}</div>
        <div class="order-status"><b>Trạng thái:</b> {{$aryStatus[$order['order_status']]}}</div>
        <div class="order-content">
            <div>
                <b>Ngày đặt hàng:</b> {{date('d/m/Y',$order['order_create_time'])}}<br>
            </div>
            <div><b>Khách hàng:</b> {{$order['customers_name']}}<br>
                <b>Tổng tiền:</b> {{number_format($order['order_price_total'],0,'.','.')}}</div>
            <div class="order-info">
                <a href="{{URL::route('site.order_detail',array('id' => $order['order_id']))}}">
                    <img title="View" alt="View" src="{{asset('assets/site/image/info.png')}}">
                </a>
            </div>
        </div>
    </div>
    @endforeach
    <div class="buttons">
        <div class="right"><input type="button" onclick="window.location='{{URL::route('site.account')}}'" class="button" value="Tiếp tục"></div>
    </div>
</div>