@if($notice == -1)
<div class="col-sm-12 alert alert-danger">
Có lỗi xảy ra khi thực hiện thao tác thanh toán . Click <a href="{{URL::route('accounting.pay',array('id'=> $supplier_id))}}"><b>thanh toán lại</b></a> để thực hiện thanh toán. Hoặc về <a href="{{URL::route('accounting.warning')}}"><b>cảnh báo thanh toán</b></a>
</div>
@elseif($notice == 2)
<div class="col-sm-12 alert alert-warning">
Không có giao dịch nào cần thanh toán . Click để về <a href="{{URL::route('accounting.managePaySupplier')}}"><b>quản lý thanh toán</b></a>
</div>
@elseif($notice == 1)
<div class="col-sm-12 alert alert-success">
Thực hiện thanh toán thành công. Click về <a href="{{URL::route('accounting.historyPaySupplier',array('id'=> $supplier_id))}}"><b>lịch sử thanh toán của nhà cung cấp</b></a>
</div>
@endif