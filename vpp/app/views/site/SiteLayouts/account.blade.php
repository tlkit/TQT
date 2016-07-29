<div id="content">
    <h1>Tài khoản của tôi</h1>
    <h2>Hi, {{$customer_login['customers_FirstName']}}</h2>
    <div class="account-info">
        <h2>Tài khoản</h2>
        <div class="content">
            <ul>
                <li><a href="{{URL::route('site.changeInfo')}}">Sửa thông tin tài khoản</a></li>
                <li><a href="{{URL::route('site.changePass')}}">Đổi mật khẩu</a></li>
            </ul>
        </div>
        <h2>Đơn hàng</h2>
        <div class="content">
            <ul>
                <li><a href="{{URL::route('site.order_history')}}">Lịch sử đơn hàng</a></li>
                <li><a href="{{URL::route('site.export_history')}}">Lịch sử xuất kho</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/your-downloads">Downloads</a></li>
                 -->
                <!-- <li><a href="http://www.homenoffice.sg/returns">View your return requests</a></li> -->
                <!-- <li><a href="http://www.homenoffice.sg/transactions">Your Transactions</a></li>
                <li><a href="http://www.homenoffice.sg/index.php?route=account/recurring">Recurring payments</a></li> -->
            </ul>
        </div>
        <!-- <h2>Newsletter</h2>
        <div class="content">
          <ul>
            <li><a href="http://www.homenoffice.sg/newsletter">Subscribe / unsubscribe to newsletter</a></li>
          </ul>
        </div> -->
    </div>
</div>