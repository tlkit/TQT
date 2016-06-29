<div id="content">
    <div class="login-content">
        <div class="left">
            <!-- <h2>Returning Customer</h2> -->
            <img src="{{asset('assets/site/image/return-cust.png')}}">
            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.login'))}}
                    <!-- <div class="content"> -->
                @if(isset($error))
                <div class="warning">{{$error}}</div>
                @endif
                <div style="margin-top:15px">
                    <!-- <p>I am a returning customer</p> -->
                    <label>Tên đăng nhập</label>
                    <input type="text" value="" name="customers_username">
                    <br>
                    <br>
                    <label>Mật khẩu</label>
                    <input type="password" value="" name="customers_password">
                    <br>
                    <br>
                    <input type="submit" class="button" value="Đăng nhập">
                </div>
            <input type="hidden" name="url" value="{{$url}}">
                <!-- </div> -->
            {{Form::close()}}
        </div>
        <div class="right">
            <!-- <h2>New Customer</h2> -->
            <img src="{{asset('assets/site/image/new.png')}}">
            <!-- <div class="content"> -->
            <div style="margin-top:60px">
                <!-- <p><b>Register Account</b></p> -->
                <p>Bằng cách tạo một tài khoản bạn sẽ có thể mua sắm nhanh hơn, cập nhật về tình trạng của đơn hàng , và theo dõi các đơn hàng bạn đã thực hiện trước đó</p>
                <input type="button" onclick="window.location='{{URL::route('site.register')}}'" class="button" value="Đăng ký">
            </div>
            <!-- </div> --></div>
    </div>
</div>