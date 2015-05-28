<table class="table table-bordered">
    <tr>
        <th class="text-center">STT</th>
        <th>Tên NCC</th>
        <th class="text-center">TT gần nhất</th>
        <th class="text-center">TT lần tiếp theo</th>
        <th class="text-center">Đang cầm của NCC (VNĐ)</th>
        <th class="text-center">Chậm (ngày)</th>
        @if($pay_accounting)
        <th class="text-center">Thanh toán</th>
        @endif
    </tr>
    <?php $i = 1;?>
    @foreach($data as $key => $value)
    <tr>
        <td align="center">{{$i}}</td>
        <td>{{$value['supplier_full_name']}}</td>
        <td align="center">@if($value['time_pay_recent']){{date('d-m-Y',$value['time_pay_recent'])}} @else -- @endif</td>
        <td align="center">{{date('d-m-Y',$value['time_pay_next'])}}</td>
        <td align="right">{{number_format($value['sum_pay'],0,",",".")}}</td>
        <td align="center">{{$value['late']}}</td>
        @if($pay_accounting)
        <td align="center"><a href="{{URL::route('accounting.pay',array('id'=>$value['supplier_id']))}}"><i class="glyphicon glyphicon-credit-card"></i></a></td>
        @endif
    </tr>
    <?php $i++;?>
    @endforeach
</table>