<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
    <div class="space-6"></div>
    <div class="col-sm-4">
        <label for="cus"><i>Đơn vị nhận hàng</i></label>
        <input type="text" id="export_customers_name" name="export_customers_name"
               class="form-control input-sm"
               value="{{$customers['customers_FirstName']}}">
    </div>
    <div class="col-sm-4">
        <label for="cus"><i>Mã số thuế</i></label>
        <input type="text" id="customers_TaxCode" name="customers_TaxCode"
               class="form-control input-sm"
               value="{{$customers['customers_TaxCode']}}" readonly>
    </div>
    <div class="col-sm-4">
        <label for="export_user_customer"><i>Người nhận hàng</i></label>
        <input type="text" id="export_user_customer" name="export_user_customer"
               class="form-control input-sm"
               value="{{$customers['customers_ContactName']}}">
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <label for="export_customers_address"><i>Địa chỉ khách hàng</i></label>
        <input type="text" id="export_customers_address" name="export_customers_address"
               class="form-control input-sm"
               value="{{$customers['customers_ContactAddress']}}">
    </div>
    <div class="col-sm-4">
        <label for="export_delivery_time"><i>Ngày giao hàng</i></label>
        <input type="text" id="export_delivery_time" name="export_delivery_time"
               class="form-control input-sm"
               value="{{date('d-m-Y',time())}}">
    </div>
    <div class="col-sm-4">
        <label for="export_customer_phone"><i>Điện thoại liên hệ</i></label>
        <input type="text" id="export_customer_phone" name="export_customer_phone"
               class="form-control input-sm"
               value="{{$customers['customers_ContactPhone']}}">
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <label for="export_user_store"><i>Thủ kho</i></label>
        <select name="export_user_store" id="export_user_store" class="form-control input-sm">
            @foreach($admin as $k => $v)
                <option value="{{$k}}" @if($user['user_id'] == $k) selected="selected" @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-4">
        <label for="export_user_cod"><i>Người giao hàng</i></label>
        <select name="export_user_cod" id="export_user_cod" class="form-control input-sm">
            @foreach($admin as $k => $v)
                <option value="{{$k}}" @if($user['user_id'] == $k) selected="selected" @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-4">
        <label for="export_customers_note"><i>Ghi chú</i></label>
        <input type="text" id="export_customers_note" name="export_customers_note"
               class="form-control input-sm"
               value="">
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