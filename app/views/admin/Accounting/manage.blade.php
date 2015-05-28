<ol class="breadcrumb">
    <li><a href="{{URL::route('admin.dashboard')}}">DashBoard</a></li>
    <li class="active">Quản lý thanh toán</li>
</ol>
<h1><small>Quản lý thanh toán</small></h1>
{{ Form::open(array('class'=>'form-horizontal','method'=>'get','id'=>'frm_manage_supplier')) }}
<div class="panel panel-info">
    <div class="panel-body">
    <table width="100%">
        <tr>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="supplier_full_name">Nhà cung cấp</label>
                    <input type="text" class="form-control input-sm" id="supplier_full_name" name="supplier_full_name" placeholder="Tên nhà cung cấp">
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="pay_supplier_status">Trạng thái thanh toán</label>
                    <select name="pay_supplier_status" id="pay_supplier_status" class="form-control input-sm">
                        <option value="0" @if($param['pay_supplier_status'] == 0) selected @endif> -- Tất cả -- </option>
                        <option value="1" @if($param['pay_supplier_status'] == 1) selected @endif>Chưa thanh toán</option>
                        <option value="2" @if($param['pay_supplier_status'] == 2) selected @endif>Đã thanh toán</option>
                    </select>
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="orders_id">Đơn hàng</label>
                    <input type="text" class="form-control input-sm" id="orders_id" name="orders_id" placeholder="DS id đơn hàng" value="@if($param['orders_id'] != '') {{$param['orders_id']}} @endif">
                </div>
            </td>
        </tr>
        <tr>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="pay_time_start">Thanh toán từ</label>
                    <input type="text" class="form-control input-sm" id="pay_time_start" name="pay_time_start" data-date-format="dd-mm-yyyy" value="@if($param['pay_time_start'] != '') {{$param['pay_time_start']}} @endif">
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="pay_time_end">Đến</label>
                    <input type="text" class="form-control input-sm" id="pay_time_end" name="pay_time_end" data-date-format="dd-mm-yyyy" value="@if($param['pay_time_end'] != '') {{$param['pay_time_end']}} @endif">
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="items_id">Sản phẩm</label>
                    <input type="text" class="form-control input-sm" id="items_id" name="items_id" placeholder="DS id sản phẩm" value="@if($param['items_id'] != '') {{$param['items_id']}} @endif">
                </div>
            </td>
        </tr>
        <tr>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="receive_time_start">NCC nhận từ</label>
                    <input type="text" class="form-control input-sm" id="receive_time_start" name="receive_time_start" data-date-format="dd-mm-yyyy" value="@if($param['receive_time_start'] != '') {{$param['receive_time_start']}} @endif">
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="receive_time_end">Đến</label>
                    <input type="text" class="form-control input-sm" id="receive_time_end" name="receive_time_end" data-date-format="dd-mm-yyyy" value="@if($param['receive_time_end'] != '') {{$param['receive_time_end']}} @endif">
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group col-sm-10">
                    <label for="coupons">Coupon</label>
                    <input type="text" class="form-control input-sm" id="coupons" name="coupons" placeholder="DS mã coupon" value="@if($param['coupons'] != '') {{$param['coupons']}} @endif">
                </div>
            </td>
        </tr>
    </table>
    </div>
    <div class="panel-footer text-right">
    <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-search"></i> Tìm kiếm</button>
    </div>
</div>
{{Form::close()}}
@if($pay)
    <div>
    <div class="col-sm-6 padding-top-3 padding-bottom-2"><b>Có tổng số <span class="red">{{$size}}</span> thanh toán</b></div>
    <div class="col-sm-6 text-right">{{$paging}}</div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">NCC</th>
            <th class="text-center">Ngày tạo</th>
            <th class="text-center">Người TT</th>
            <th class="text-center">Số tiền</th>
            <th class="text-center">Phí trả MC</th>
            <th class="text-center">Tiền phải trả</th>
            <th class="text-center">Trạng thái</th>
            @if($view_detail_accounting)
            <th class="text-center">Chi tiết</th>
            @endif
        </tr>
        @foreach($pay as $k => $v)
        <tr>
            <td align="center">{{$k+1}}</td>
            <td align="left">
            @if($view_history_accounting)
            <a href="{{URL::route('accounting.historyPaySupplier',array('id'=>$v['supplier_id']))}}">{{$v['supplier_full_name']}}</a>
            @else
            {{$v['supplier_full_name']}}
            @endif
            </td>
            <td align="center">{{date('d-m-Y',$v['pay_supplier_pay_time'])}}</td>
            <td align="center">{{$v['pay_supplier_user_name_c']}}</td>
            <td align="center">{{number_format($v['pay_supplier_money'],0,",",".")}}</td>
            <td align="center">{{number_format($v['pay_supplier_fee_change'],0,",",".")}}</td>
            <td align="center">{{number_format($v['pay_supplier_real_money'],0,",",".")}}</td>
            <td align="center">{{$aryPayStatus[$v['pay_supplier_status']]}}</td>
            @if($view_detail_accounting)
            <td align="center"><a href="{{URL::route('accounting.detailPaySupplier',array('id' => $v['pay_supplier_id']))}}"><i class="glyphicon glyphicon-list-alt"></i></a></td>
            @endif
        </tr>
        @endforeach
    </table>
    <div class="col-sm-12 text-right">
    {{$paging}}
    </div>
@else
<div class="alert alert-warning"><b>Không có thanh toán nào</b></div>
@endif
<script type="text/javascript">
$(document).ready(function(){
    var pay_start = $('#pay_time_start').datepicker().on('changeDate',function (ev){
        pay_start.hide();
    }).data('datepicker');
    var pay_end = $('#pay_time_end').datepicker().on('changeDate',function (ev){
        pay_end.hide();
    }).data('datepicker');
    var re_start = $('#receive_time_start').datepicker().on('changeDate',function (ev){
        re_start.hide();
    }).data('datepicker');
    var re_end = $('#receive_time_end').datepicker().on('changeDate',function (ev){
        re_end.hide();
    }).data('datepicker');
})
</script>