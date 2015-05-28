<ol class="breadcrumb">
    <li><a href="{{URL::route('admin.dashboard')}}">DashBoard</a></li>
    <li><a href="{{URL::route('accounting.managePaySupplier')}}">Quản lý thanh toán</a></li>
    <li class="active">Lịch sử thanh toán</li>
</ol>
<h1><small>Lịch sử thanh toán cho NCC {{$supplier['supplier_full_name']}}</small></h1>
@if($history)
<table class="table table-bordered">
    <tr>
        <th class="text-center">STT</th>
        <th class="text-center">Ngày tạo</th>
        <th class="text-center">Người TT</th>
        <th class="text-center">Số tiền</th>
        <th class="text-center">Phí trả MC</th>
        <th class="text-center">Tiền phải trả</th>
        <th class="text-center">Ngày UNC</th>
        <th class="text-center">Trạng thái</th>
        @if($view_detail_accounting)
        <th class="text-center">Chi tiết</th>
        @endif
    </tr>
    @foreach($history as $k => $v)
    <tr>
        <td align="center">{{$k+1}}</td>
        <td align="center">{{date('d-m-Y',$v['pay_supplier_pay_time'])}}</td>
        <td align="center">{{$v['pay_supplier_user_name_c']}}</td>
        <td align="center">{{number_format($v['pay_supplier_money'],0,",",".")}}</td>
        <td align="center">{{number_format($v['pay_supplier_fee_change'],0,",",".")}}</td>
        <td align="center">{{number_format($v['pay_supplier_real_money'],0,",",".")}}</td>
        <td align="center">@if($v['pay_supplier_receive_time']){{date('d-m-Y',$v['pay_supplier_receive_time'])}} @else - @endif</td>
        <td align="center">
        @if($v['pay_supplier_status'] == CGlobal::pay_supplier_chuathanhtoan)
            @if($confirm_pay_accounting)
            <a class="sys_confirm_pay" data-pay-id="{{$v['pay_supplier_id']}}" href="#" data-toggle="modal" data-target="#myModalConfirm">Chưa thanh toán</a>
            @else
            Chưa thanh toán
            @endif
        @elseif($v['pay_supplier_status'] == CGlobal::pay_supplier_dathanhtoan)
            Đã thanh toán
        @endif
        </td>
        @if($view_detail_accounting)
        <td align="center"><a href="{{URL::route('accounting.detailPaySupplier',array('id' => $v['pay_supplier_id']))}}"><i class="glyphicon glyphicon-list-alt"></i></a></td>
        @endif
    </tr>
    @endforeach
</table>
@else
<div class="alert alert-success"><b>Hiện nhà cung cấp này chưa được thanh toán lần nào</b></div>
@endif

<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thanh toán</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="receive_date">Ngày NCC thực nhận tiền</label>
                    <input readonly type="text" class="form-control input-sm" id="receive_date" data-date-format="dd-mm-yyyy" value="{{date('d-m-Y',time())}}">
                </div>
                <div class="form-group">
                    <label for="receive_date">Phí ngân hàng</label>
                    <select name="bank_fee" id="bank_fee" class="form-control input-sm">
                        @foreach(CGlobal::$aryBankFee as $key => $fee)
                            <option value="{{$key}}">{{$fee}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <input id="sys_finish_pay" type="button" class="btn btn-primary" value="Đồng ý" style="width: 20%"/>
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Hủy" style="width: 20%"/>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.datepicker{z-index:1151 !important;}
</style>