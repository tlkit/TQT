<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
    <div class="space-6"></div>
    <div class="col-sm-4">
        <label for="cus"><i>Đơn vị nhận hàng</i></label>
        <input type="text" id="export_customers_name" name="export_customers_name"
               class="form-control input-sm"
               value="{{$customers['export_customers_name']}}">
    </div>
    <div class="col-sm-4">
        <label for="export_customers_code"><i>Mã số thuế</i></label>
        <input type="text" id="export_customers_code" name="export_customers_code"
               class="form-control input-sm"
               value="{{$customers['export_customers_code']}}" readonly>
    </div>
    <div class="col-sm-4">
        <label for="export_user_customer"><i>Người nhận hàng</i></label>
        <input type="text" id="export_user_customer" name="export_user_customer"
               class="form-control input-sm"
               value="{{$customers['export_user_customer']}}">
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <label for="export_customers_address"><i>Địa chỉ khách hàng</i></label>
        <input type="text" id="export_customers_address" name="export_customers_address"
               class="form-control input-sm"
               value="{{$customers['export_customers_address']}}">
    </div>
    <div class="col-sm-4">
        <label for="export_delivery_time"><i>Ngày giao hàng</i></label>
        <input type="text" id="export_delivery_time" name="export_delivery_time"
               class="form-control input-sm"
               value="{{$customers['export_delivery_time']}}">
    </div>
    <div class="col-sm-4">
        <label for="export_customer_phone"><i>Điện thoại liên hệ</i></label>
        <input type="text" id="export_customer_phone" name="export_customer_phone"
               class="form-control input-sm"
               value="{{$customers['export_customer_phone']}}">
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <label for="export_user_store"><i>Thủ kho</i></label>
        <select name="export_user_store" id="export_user_store" class="form-control input-sm">
            @foreach($admin as $k => $v)
                <option value="{{$k}}" @if($customers['export_user_store'] == $k) selected="selected" @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-4">
        <label for="export_user_cod"><i>Người giao hàng</i></label>
        <select name="export_user_cod" id="export_user_cod" class="form-control input-sm">
            @foreach($admin as $k => $v)
                <option value="{{$k}}" @if($customers['export_user_cod'] == $k) selected="selected" @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-4">
        <label for="export_customers_note"><i>Ghi chú</i></label>
        <input type="text" id="export_customers_note" name="export_customers_note"
               class="form-control input-sm"
               value="{{$customers['export_customers_note']}}">
    </div>
    <div class="cols-sm-6 col-xs-12">
        <div class="space-6"></div>
        <div class="checkbox">
            <label>
                <input type="checkbox" class="ace ace-checkbox-2" id="export_pay_type" name="export_pay_type" value="1" @if($customers['export_pay_type'] == 1) checked @endif>
                <span class="lbl orange"> <strong>Thanh toán công nợ</strong></span>
            </label>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( "#export_delivery_time" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
//        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy'
    });
</script>