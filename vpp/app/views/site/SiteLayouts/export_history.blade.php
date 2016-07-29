<div id="content">
    <h1>Lịch sử xuất hàng</h1>
    @foreach($exports as $export)
    <div class="order-list">
        <div class="order-id"><b>Mã xuất kho:</b> #{{$export['export_code']}}</div>
        <div class="order-status"><b>Trạng thái:</b> {{$aryStatus[$export['export_status']]}}</div>
        <div class="order-content">
            <div>
                <b>Ngày xuất kho:</b> {{date('d/m/Y',$export['export_create_time'])}}<br>
            </div>
            <div><b>Khách hàng:</b> {{$export['export_customers_name']}}<br>
                <b>Tổng tiền:</b> {{number_format($order['export_total_pay'],0,'.','.')}}</div>
            <div class="order-info">
                <a href="{{URL::route('site.export_detail',array('id' => $order['export_id']))}}">
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