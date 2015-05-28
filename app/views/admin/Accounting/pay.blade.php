<ol class="breadcrumb">
    <li><a href="{{URL::route('admin.dashboard')}}">DashBoard</a></li>
    <li><a href="{{URL::route('accounting.warning')}}">Cảnh báo thanh toán</a></li>
    <li class="active">Thanh toán</li>
</ol>
<h1 class="text-center"><small>Chi tiết thanh toán cho NCC {{$supplier['supplier_full_name']}}</small></h1>
<div class="col-sm-12 padding-top-5" id="sys_content">
    <div class="padding-bottom-2 font_14 font_bold">Các đơn hàng cần thanh toán</div>
    {{ Form::open(array('class'=>'form-horizontal','method'=>'post','id'=>'frm_pay_supplier','route' => array('accounting.postPaySupplier',$supplier['supplier_id']))) }}
    <table class="table table-bordered">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Ngày KH coupon</th>
            <th class="text-center">ID Deal</th>
            <th class="text-center">ID Đơn hàng</th>
            <th class="text-center">Coupon</th>
            <th class="text-center">Số tiền</th>
            <th class="text-center">Charge phí trả MC</th>
            <th class="text-center">Tiền phải trả</th>
            <th class="text-center"><input class="selecctall" checked type="checkbox" style="margin-top: -5px"></th>
        </tr>
        <?php $i = 1;$sum = 0;?>

        @foreach($coupons as $key => $coupon)
            @foreach($coupon as $k => $v)
            <tr>
                <td align="center">{{$i}}</td>
                <td align="center">{{date('d-m-Y',$v['pay_supplier_coupon_active_time'])}}</td>
                <td align="center">{{$v['pay_supplier_coupon_item_id']}}</td>
                <td align="center">{{$v['pay_supplier_coupon_order_id']}}</td>
                <td align="center">{{$v['pay_supplier_coupon_coupon']}}</td>
                <td align="right">{{number_format($v['pay_supplier_coupon_money'],0,",",".")}}</td>
                <td align="right">
                    <span id="sys_money_fee_{{$v['pay_supplier_coupon_id']}}">
                        @if($k == 0 && isset($charge[$key]))
                        {{number_format(($v['pay_supplier_coupon_fee_change'] + $charge[$key]),0,",",".")}}
                        @else
                        {{number_format($v['pay_supplier_coupon_fee_change'],0,",",".")}}
                        @endif
                    </span>
                </td>
                <td align="right">
                    <span id="sys_money_pay_{{$v['pay_supplier_coupon_id']}}">
                        @if($k == 0 && isset($charge[$key]))
                        {{number_format(($v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'] - $charge[$key]),0,",",".")}}
                        <?php $sum += $v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'] - $charge[$key];?>
                        @else
                        {{number_format(($v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change']),0,",",".")}}
                        <?php $sum += $v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'];?>
                        @endif
                    </span>
                </td>
                <td align="center"><input id="{{$v['pay_supplier_coupon_id']}}" data-order="{{$v['pay_supplier_coupon_order_id']}}" data-coupon-money="{{$v['pay_supplier_coupon_money']}}" data-fee-coupon="{{$v['pay_supplier_coupon_fee_change']}}" data-fee-order="@if(isset($charge[$key])) {{$charge[$key]}} @else 0 @endif" data-pay="@if($k == 0 && isset($charge[$key])) {{$v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'] - $charge[$key]}} @else {{$v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change']}} @endif" data-flag="@if($k == 0)1 @else 0 @endif" class="checkbox_items" type="checkbox" value="{{$v['pay_supplier_coupon_id']}}" name="checkbox_items[]" checked></td>
            </tr>
            <?php $i++;?>
            @endforeach
        @endforeach
        <tr>
            <td colspan="7" align="right" class="font_bold">Tổng tiền</td>
            <td align="right" class="font_bold text-danger"><span id="sys_sum_pay" data-value="{{number_format($sum,0,",",".")}}">{{number_format($sum,0,",",".")}}</span></td>
            <td align="center"><input class="selecctall" checked type="checkbox"></td>
        </tr>
    </table>
    {{ Form::close() }}
    <div class="col-sm-12 text-right padding-bottom-5">
    <a  class="btn btn-warning" id="sys_pay_supplier"><i class="glyphicon glyphicon-credit-card"></i> Thanh toán</a>
    </div>
</div>
