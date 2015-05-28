<div class="form-box" id="login-box">
    <div class="header">Đăng Nhập</div>
    {{ Form::open(array('class'=>'form-signin')) }}
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" id="user_name" name="user_name" placeholder="Tên đăng nhập" class="form-control" maxlength="30" @if(isset($code))@if($code == 202) @if (isset($username)) value = "{{$username}}" @endif @endif @endif>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Mật khẩu" class="form-control" maxlength="32">
            </div>
            @if(isset($error))
                @if($error)
                    <p><span style=" color:red">{{ $error }}</span></p>
                @endif
            @endif
            <div class="form-group">
                <input type="checkbox" name="remember_me"/> Ghi nhớ
            </div>
        </div>
        <div class="footer">
            <button type="submit" name="submit" class="btn bg-olive btn-block" value="1">Đăng nhập</button>
        </div>
    {{ Form::close() }}
</div>