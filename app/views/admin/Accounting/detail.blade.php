<ol class="breadcrumb">
    <li><a href="{{URL::route('admin.dashboard')}}">DashBoard</a></li>
    <li><a href="{{URL::route('accounting.managePaySupplier')}}">Quản lý thanh toán</a></li>
    <li class="active">Chi tiết thanh toán</li>
</ol>
@if($supplier)
<h3 class="text-center">Chi tiết thanh toán cho {{$supplier['supplier_full_name']}}</h3>
@endif
@if($pay)
<h2 class="text-center"><small> Ngày {{date('d-m-Y',$pay['pay_supplier_pay_time'])}}</small></h2>
@endif
{{ Form::open(array('class'=>'form-horizontal')) }}
<div class="col-sm-12 text-right padding-bottom-2" id="sys_group_btn">

    <button type="submit" name="submit" class="btn btn-default" id="export_excel" value="1"><i class="glyphicon glyphicon-floppy-save"></i> Xuất Excel</button>
    <button onclick="print_specific_div_content()" type="button" name="printer" class="btn btn-default" id="printer_data" value="1"><i class="fa fa-print"></i> IN</button>
</div>
{{ Form::close() }}
@if($pay && $coupons)
    <table class="table table-bordered" id="tbl_data">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Ngày KH coupon</th>
            <th class="text-center">ID Deal</th>
            <th class="text-center">ID Đơn hàng</th>
            <th class="text-center">Coupon</th>
            <th class="text-center">Số tiền</th>
            <th class="text-center">Charge phí trả MC</th>
            <th class="text-center">Tiền phải trả</th>
            <th class="text-center">Hình thức thanh toán</th>
            <th class="text-center">Ngày NCC nhận tiền</th>
            <th class="text-center">Trạng thái</th>
        </tr>
        <?php $i = 1;?>
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
                        @else
                        {{number_format(($v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change']),0,",",".")}}
                        @endif
                    </span>
                </td>
                <td align="center">{{CGlobal::$orders_payment_method2[$v['orders_payment_method']]}}@if((int)$v['orders_payment_method'] == 1 && (int)$v['orders_payment_type'] > 0) ({{CGlobal::$aryPaymentType[(int)$v['orders_payment_type']]}}) @endif</td>
                <td align="center">{{date('d-m-Y',$pay['pay_supplier_pay_time'])}}</td>
                <td align="center">{{$aryPayStatus[$pay['pay_supplier_status']]}}</td>
            </tr>
            <?php $i++;?>
            @endforeach
        @endforeach
        <tr>
            <td colspan="5" align="right" class="font_bold">Tổng tiền</td>
            <td align="right" class="font_bold text-danger">{{number_format($pay['pay_supplier_money'],0,",",".")}}</td>
            <td align="right" class="font_bold text-danger">{{number_format($pay['pay_supplier_fee_change'],0,",",".")}}</td>
            <td align="right" class="font_bold text-danger">{{number_format($pay['pay_supplier_real_money'],0,",",".")}}</td>
            <td align="right" class="font_bold text-danger"></td>
            <td align="right" class="font_bold text-danger"></td>
        </tr>
    </table>
@else
    <div class="alert alert-warning"><b>Không có giao dịch nào được thanh toán</b></div>
@endif

<script type="text/javascript">

function print_specific_div_content() {

    //Print Page
    $(".navbar").addClass('hidden');
    $(".breadcrumb").addClass('hidden');
    $("#sys_group_btn").addClass('hidden');
    window.print();
    //Restore orignal HTML
    $(".navbar").removeClass('hidden');
    $(".breadcrumb").removeClass('hidden');
    $("#sys_group_btn").removeClass('hidden');

}
</script>