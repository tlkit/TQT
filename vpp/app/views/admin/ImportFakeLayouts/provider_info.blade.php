@if($provider)
<li>
    <i class="ace-icon fa fa-caret-right blue"></i>Mã nhà cung cấp : <b class="blue">{{$provider['providers_Code']}}</b>
</li>
<li>
    <i class="ace-icon fa fa-caret-right blue"></i>Số điện thoại : <b class="red">{{$provider['providers_Phone']}}</b>
</li>
<li>
    <i class="ace-icon fa fa-caret-right blue"></i>Website : <b class="red">{{$provider['providers_Website']}}</b>
</li>
@endif