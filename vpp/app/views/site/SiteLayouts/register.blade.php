<div id="content">
    <div id="register-content">
        <div id="banner"><img src="{{asset('assets/site/image/new.png')}}"></div>

        <p style="margin-top:15px;">Nếu bạn đã có tài khoản vui lòng đăng nhập<a href="http://www.homenoffice.sg/login"> tại đây</a>.</p>
        {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.register'))}}            <!-- <h2>Your Personal Details</h2> -->
            <!-- <div class="content"> -->
            <table class="form">
                <tbody><tr>
                    <td>Tên khách hàng <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_FirstName'])) value="{{$param['customers_FirstName']}}" @endif name="customers_FirstName" placeholder="Cá nhân hoặc doanh nghiệp">
                        @if(isset($error['customers_FirstName']))
                        <span class="error">{{$error['customers_FirstName']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Email <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_Email'])) value="{{$param['customers_Email']}}" @endif name="customers_Email">
                        @if(isset($error['customers_Email']))
                            <span class="error">{{$error['customers_Email']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Số điện thoại <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_Phone'])) value="{{$param['customers_Phone']}}" @endif name="customers_Phone">
                        @if(isset($error['customers_Phone']))
                            <span class="error">{{$error['customers_Phone']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td><input type="text" @if(isset($param['customers_Fax'])) value="{{$param['customers_Fax']}}" @endif name="customers_Fax"></td>
                </tr>
                <tr>
                    <td>Địa chỉ <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_ContactAddress'])) value="{{$param['customers_ContactAddress']}}" @endif name="customers_ContactAddress">
                        @if(isset($error['customers_ContactAddress']))
                            <span class="error">{{$error['customers_ContactAddress']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Xuất HĐGT</td>
                    <td>
                        <select name="customers_IsNeededVAT" id="customers_IsNeededVAT">
                            <option value="0" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 0)selected="selected" @endif>Không</option>
                            <option value="1" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1)selected="selected" @endif>Có</option>
                        </select>
                    </td>
                </tr>
                <tr class="mst" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1) @else style="display: none" @endif>
                    <td>Mã số thuế <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_TaxCode'])) value="{{$param['customers_TaxCode']}}" @endif name="customers_TaxCode">
                        @if(isset($error['customers_TaxCode']))
                            <span class="error">{{$error['customers_TaxCode']}}</span>
                        @endif
                    </td>
                </tr>
                <tr class="dchd" @if(isset($param['customers_IsNeededVAT']) && $param['customers_IsNeededVAT'] == 1) @else style="display: none" @endif>
                    <td>Địa chỉ xuất HĐ <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_BizAddress'])) value="{{$param['customers_BizAddress']}}" @endif name="customers_BizAddress">
                        @if(isset($error['customers_BizAddress']))
                            <span class="error">{{$error['customers_BizAddress']}}</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="form">
                <tbody>
                <tr>
                    <td><!-- <span class="required">*</span> --> Tên đăng nhập <span class="required">*</span></td>
                    <td>
                        <input type="text" @if(isset($param['customers_username'])) value="{{$param['customers_username']}}" @endif name="customers_username">
                        @if(isset($error['customers_username']))
                            <span class="error">{{$error['customers_username']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Mật khẩu <span class="required">*</span></td>
                    <td>
                        <input type="password" @if(isset($param['customers_password'])) value="{{$param['customers_password']}}" @endif name="customers_password">
                        @if(isset($error['customers_password']))
                            <span class="error">{{$error['customers_password']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><!-- <span class="required">*</span> --> Xác nhận mật khẩu <span class="required">*</span></td>
                    <td>
                        <input type="password" @if(isset($param['customers_password_confirm'])) value="{{$param['customers_password_confirm']}}" @endif value="" name="customers_password_confirm">
                        @if(isset($error['customers_password_confirm']))
                            <span class="error">{{$error['customers_password_confirm']}}</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- </div> -->
            <!-- <h2>Newsletter</h2> -->
            <!-- <div class="content"> -->
            <!-- <table class="form">
              <tr>
                <td>Subscribe Newsletter</td>
                <td>            Yes <input type="radio" name="newsletter" value="1" />

                  No <input type="radio" name="newsletter" value="0" checked="checked" />

                  </td>
              </tr>
            </table> -->
            <input type="hidden" value="0" name="newsletter">
            <!-- </div> -->
            <div class="buttons">
                <div class="left">
                    <input type="submit" class="button" value="Đăng ký">
                </div>
            </div>
        {{Form::close()}}
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