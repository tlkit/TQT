<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Quản lý tài khoản</a>
            </div>
        </div>
        <div class="cl make-left">
            <div class="box-left clearfix">
                <div class="box-left-title">
                    Tài khoản của bạn
                </div>
                <ul class="rs user-list">
                    <li class="active">
                        <i class="icons iRightU"></i><a href="javascript:void(0)">Quản lý tài khoản</a>
                    </li>
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.changePass')}}">Đổi mật khẩu</a>
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
                    <div class="make-left">Quản lý tài khoản</div>
                </div>
                {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.changeInfo'))}}
                <div class="box-right-user clearfix">
                    <div class="user-title">Xin chào, {{$customer['customers_FirstName']}}</div>
                    <div class="user-des mt-20 mb-20">Dưới dây là mục quản lý tài khoản của bạn. Bạn có thể chỉnh sửa thông tin tài khoản và địa chỉ giao nhận hàng.</div>
                    <div class="user-frm clearfix">
                        <div class="user-frm-title">
                            Thông tin tài khoản
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Tên hiển thị <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" value="{{$customer['customers_FirstName']}}" name="customers_FirstName">
                            @if(isset($error['customers_FirstName']))
                                <span class="red">{{$error['customers_FirstName']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Email <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" value="{{$customer['customers_Email']}}" name="customers_Email">
                            @if(isset($error['customers_Email']))
                                <span class="red">{{$error['customers_Email']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Số điện thoại <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" value="{{$customer['customers_Phone']}}" name="customers_Phone">
                            @if(isset($error['customers_Phone']))
                                <span class="red">{{$error['customers_Phone']}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="clearfix">Địa chỉ <sup class="red">*</sup></label>
                            <input type="text" class="txt width-535" value="{{$customer['customers_ContactAddress']}}" name="customers_ContactAddress">
                            @if(isset($error['customers_ContactAddress']))
                                <span class="red">{{$error['customers_ContactAddress']}}</span>
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