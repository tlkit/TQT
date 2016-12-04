<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Đổi mật khẩu</a>
            </div>
        </div>
        <div class="cl make-left">
            <div class="box-left clearfix">
                <div class="box-left-title">
                    Tài khoản của bạn
                </div>
                <ul class="rs user-list">
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.changeInfo')}}">Quản lý tài khoản</a>
                    </li>
                    <li class="active">
                        <i class="icons iRightU"></i><a href="javascript:void(0)">Đổi mật khẩu</a>
                    </li>
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.order_history')}}">Quản lý đơn hàng</a>
                    </li>
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.export_history')}}">Lịch sử xuất kho</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cr make-right">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Đổi mật khẩu</div>
                </div>
                {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.changePass'))}}
                <div class="box-right-user clearfix">
                    <div class="user-title">Xin chào, {{$customer_login['customers_FirstName']}}</div>
                    <div class="user-des mt-20 mb-20">Dưới dây là mục đổi mật khẩu. Bạn có thể đổi mật khẩu cho tài khoản của ban.</div>
                    <div class="user-frm clearfix">
                        <div class="user-frm-title">
                            Thông tin xác nhận
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Mật khẩu hiện tại <sup class="red">*</sup></label>
                            <input type="password" class="txt width-535" name="customers_password_old">
                            @if(isset($error['customers_password_old']))
                                <br>
                                <span class="red">{{$error['customers_password_old']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Mật khẩu mới <sup class="red">*</sup></label>
                            <input type="password" class="txt width-535" name="customers_password">
                            @if(isset($error['customers_password']))
                                <br>
                                <span class="red">{{$error['customers_password']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Xác nhận mật khẩu <sup class="red">*</sup></label>
                            <input type="password" class="txt width-535"  name="customers_password_confirm">
                            @if(isset($error['customers_password_confirm']))
                                <br>
                                <span class="red">{{$error['customers_password_confirm']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Lưu lại" class="btn btn-submit">
                        </div>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>