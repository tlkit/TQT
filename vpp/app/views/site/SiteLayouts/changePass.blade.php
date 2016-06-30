<div id="content">
    <h1>Thay đổi mật khẩu</h1>
    {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.changePass'))}}
        <div class="content">
            <table class="form">
                <tbody><tr>
                    <td style="width: 180px;"><span class="required">*</span> Mật khẩu hiện tại:</td>
                    <td>
                        <input type="password" value="" name="customers_password_old">
                        @if(isset($error['customers_password_old']))
                            <span class="error">{{$error['customers_password_old']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Mật khẩu mới:</td>
                    <td><input type="password" value="" name="customers_password">
                        @if(isset($error['customers_password']))
                            <span class="error">{{$error['customers_password']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Xác nhận mật khẩu:</td>
                    <td><input type="password" value="" name="customers_password_confirm">
                        @if(isset($error['customers_password_confirm']))
                            <span class="error">{{$error['customers_password_confirm']}}</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <div class="left"><input type="button" onclick="window.location=''" class="button" value="Quay về"></div>
            <div class="right"><input type="submit" class="button" value="Tiếp tục"></div>
        </div>
    {{Form::close()}}
</div>