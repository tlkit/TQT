<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0)" style="font-family: 'Calligraffitti', cursive;">Admin VPP</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">
            @if(isset($error))
                {{$error}}
            @else
                Sign in to start your session
            @endif
        </p>
        {{ Form::open(array('class'=>'form-signin')) }}
            <div class="form-group has-feedback">
                <input name="user_name" @if(isset($username)) value="{{$username}}" @endif type="text" class="form-control" placeholder="User"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="user_password" type="password" class="form-control" placeholder="Password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        {{Form::close()}}

        {{--<div class="social-auth-links text-center">--}}
            {{--<p>- OR -</p>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>--}}
        {{--</div><!-- /.social-auth-links -->--}}

        {{--<a href="#">I forgot my password</a><br>--}}
        {{--<a href="register.html" class="text-center">Register a new membership</a>--}}

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>