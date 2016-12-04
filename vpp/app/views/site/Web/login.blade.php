<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Đăng ký & Đăng nhập</a>
            </div>
        </div>
        <div class="full-width box-right box-customer clearfix">
            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.login'))}}
            <div class="box-login make-left">
                <div class="box-login-title">
                    Đăng nhập
                </div>
                <div class="mt-10">Xin chào, vui lòng đăng nhập để sử dụng</div>
                <div class="clearfix"></div>
                @if(isset($error_lg))
                    <div class="warning">{{$error_lg}}</div>
                @endif
                <div class="form-group">
                    <label for="" class="clearfix">Tên đăng nhập <sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" name="customers_username">
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Mật khẩu <sup class="red">*</sup></label>
                    <input type="password" class="txt width-535" name="customers_password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-login" value="Đăng nhập">
                </div>
            </div>
            <input type="hidden" name="url" value="{{isset($url) ? $url : '';}}">
            {{Form::close()}}
            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.register'))}}
            <div class="box-login make-right">
                <div class="box-login-title">
                    Đăng ký
                </div>
                <div class="mt-10">Tạo tài khoản mới cho bạn</div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="" class="clearfix">Tên khách hàng<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_FirstName'])) value="{{$param['customers_FirstName']}}" @endif name="customers_FirstName" placeholder="Cá nhân hoặc doanh nghiệp">
                    @if(isset($error['customers_FirstName']))
                        <span class="red">{{$error['customers_FirstName']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Email <sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_Email'])) value="{{$param['customers_Email']}}" @endif name="customers_Email">
                    @if(isset($error['customers_Email']))
                        <span class="red">{{$error['customers_Email']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Số điện thoại<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_Phone'])) value="{{$param['customers_Phone']}}" @endif name="customers_Phone">
                    @if(isset($error['customers_Phone']))
                        <span class="red">{{$error['customers_Phone']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Fax</label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_Fax'])) value="{{$param['customers_Fax']}}" @endif name="customers_Fax">
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Địa chỉ<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_ContactAddress'])) value="{{$param['customers_ContactAddress']}}" @endif name="customers_ContactAddress">
                    @if(isset($error['customers_ContactAddress']))
                        <span class="red">{{$error['customers_ContactAddress']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Xuất HĐGT<sup class="red">*</sup></label>
                    <select name="customers_IsNeededVAT" id="customers_IsNeededVAT" class="txt">
                        <option value="0" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 0)selected="selected" @endif>Không</option>
                        <option value="1" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1)selected="selected" @endif>Có</option>
                    </select>
                </div>
                <div class="form-group mst" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1) @else style="display: none" @endif>
                    <label for="" class="clearfix">Mã số thuế<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_TaxCode'])) value="{{$param['customers_TaxCode']}}" @endif name="customers_TaxCode">
                    @if(isset($error['customers_TaxCode']))
                        <span class="red">{{$error['customers_TaxCode']}}</span>
                    @endif
                </div>
                <div class="form-group dchd" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1) @else style="display: none" @endif>
                    <label for="" class="clearfix">Địa chỉ xuất HĐ<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_BizAddress'])) value="{{$param['customers_BizAddress']}}" @endif name="customers_BizAddress">
                    @if(isset($error['customers_BizAddress']))
                        <span class="red">{{$error['customers_BizAddress']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Tên đăng nhập<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_username'])) value="{{$param['customers_username']}}" @endif name="customers_username">
                    @if(isset($error['customers_username']))
                        <span class="red">{{$error['customers_username']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Mật khẩu<sup class="red">*</sup></label>
                    <input type="password" class="txt width-535" @if(isset($param['customers_password'])) value="{{$param['customers_password']}}" @endif name="customers_password">
                    @if(isset($error['customers_password']))
                        <span class="red">{{$error['customers_password']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="clearfix">Xác nhận mật khẩu<sup class="red">*</sup></label>
                    <input type="text" class="txt width-535" @if(isset($param['customers_password_confirm'])) value="{{$param['customers_password_confirm']}}" @endif name="customers_password_confirm">
                    @if(isset($error['customers_password_confirm']))
                        <span class="red">{{$error['customers_password_confirm']}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-register" value="Đăng ký">
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#customers_IsNeededVAT").on('change',function(){
            if($(this).val() == 1){
                $(".mst, .dchd").show();
            }else{
                $(".mst, .dchd").hide();
            }
        });
    })
</script>