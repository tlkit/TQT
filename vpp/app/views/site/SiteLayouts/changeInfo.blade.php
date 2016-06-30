<div id="content">
    <h1>Thông tin tài khoản</h1>
    {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'site.changeInfo'))}}
        <div class="content">
            <table class="form">
                <tbody>
                <tr>
                    <td><span class="required">*</span> Tên:</td>
                    <td>
                        <input type="text" value="{{$customer['customers_FirstName']}}" name="customers_FirstName">
                        @if(isset($error['customers_FirstName']))
                            <span class="error">{{$error['customers_FirstName']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span> E-Mail:</td>
                    <td>
                        <input type="text" value="{{$customer['customers_Email']}}" name="customers_Email">
                        @if(isset($error['customers_Email']))
                            <span class="error">{{$error['customers_Email']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Điện thoại:</td>
                    <td>
                        <input type="text" value="{{$customer['customers_Phone']}}" name="customers_Phone">
                        @if(isset($error['customers_Phone']))
                            <span class="error">{{$error['customers_Phone']}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Địa chỉ:</td>
                    <td>
                        <input type="text" value="{{$customer['customers_ContactAddress']}}" name="customers_ContactAddress">
                        @if(isset($error['customers_ContactAddress']))
                            <span class="error">{{$error['customers_ContactAddress']}}</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <div class="left"><input type="button" onclick="window.location=''" class="button" value="Quay lại"></div>
            <div class="right">
                <input type="submit" class="button" value="Tiếp tục">
            </div>
        </div>
    {{Form::close()}}
</div>