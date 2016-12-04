<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Quản lý đơn hàng</a>
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
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.changePass')}}">Đổi mật khẩu</a>
                    </li>
                    <li class="">
                        <i class="icons iRightU"></i><a href="{{URL::route('site.order_history')}}">Quản lý đơn hàng</a>
                    </li>
                    <li class="active">
                        <i class="icons iRightU"></i><a href="javascript:void(0)">Lịch sử xuất kho</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cr make-right">
            <div class="box-right clearfix">
                <div class="box-right-title">
                    <div class="make-left">Quản lý đơn hàng</div>
                </div>
                <div class="box-right-user clearfix">
                    <div class="user-title">Xin chào, Nguyễn Anh Tuấn</div>
                    <div class="user-des mt-20 mb-20">Dưới dây là mục quản lý đơn hàng của bạn.</div>
                    @if($orders)
                    <div class="user-frm clearfix">
                        <div class="order-frm-title">
                            Theo dõi đơn hàng
                            <span><i>(Bạn hiện có {{count($orders)}} đơn hàng)</i></span>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Mã xuất kho</th>
                                <th>Ngày xuất kho</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                            </tr>
                            </thead>
                            @foreach($exports as $export)
                            <tr>
                                <td align="center"><a href="javascript:void(0)">{{$export['export_code']}}</a></td>
                                <td>
                                    {{date('d/m/Y',$export['export_create_time'])}}
                                    <br>
                                    {{date('H:i',$export['export_create_time'])}}
                                </td>
                                <td>
                                    {{$aryStatus[$export['export_status']]}}
                                </td>
                                <td align="right">
                                    {{number_format($order['export_total_pay'],0,'.','.')}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>