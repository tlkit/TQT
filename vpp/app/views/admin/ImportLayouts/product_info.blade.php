@if(isset($error) && $error != '')
    <div class="alert alert-danger">
        {{$error}}
    </div>
@endif
@if($import)
<div class="cols-sm-6 col-xs-12">
    <div class="checkbox">
        <label>
            <input type="checkbox" class="ace" id="import_pay_type" name="import_pay_type" value="1" @if($import_pay_type == 1) checked @endif>
            <span class="lbl green"> <strong>Thanh toán công nợ</strong></span>
        </label>
    </div>
    <div class="space-6"></div>
</div>
<div class="clearfix"></div>
<table class="table table-striped table-bordered">
    <thead class="thin-border-bottom">
    <tr>
        <th class="center">#</th>
        <th class="center">Mã hàng</th>
        <th class="hidden-480">Tên hàng hóa</th>
        <th class="center hidden-xs">Xuất xứ</th>
        <th class="center hidden-480">Đơn vị tính</th>
        <th class="center hidden-480">Giá nhập</th>
        <th class="center hidden-480">Số lượng</th>
        <th class="center">Thành tiền</th>
        <th class="center">Thao tác</th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 1;$total = 0;?>
    @foreach($import as $k => $v)
    <?php $total_item = $v['import_product_price'] * $v['import_product_num'];?>
    <tr>
        <td class="center">{{$i}}</td>
        <td class="center">{{$v['product_Code']}}</td>
        <td class="hidden-480"><a href="#">{{$v['product_Name']}}</a></td>
        <td class="center hidden-xs">{{$v['product_NameOrigin']}}</td>
        <td class="center hidden-480">{{$v['product_NameUnit']}}</td>
        <td class="text-right hidden-480">{{number_format($v['import_product_price'], 0, ',', '.');}}</td>
        <td class="center hidden-480">{{$v['import_product_num']}}</td>
        <td class="text-right hidden-480"><b>{{number_format($total_item, 0, ',', '.');}}</b></td>
        <td class="center">
            <a href="javascript:void(0)" class="btn btn-xs btn-danger sys_remove_item" onclick="Import.removeItem({{$k}})" data-content="Bỏ sản phẩm" data-placement="bottom" data-trigger="hover" data-rel="popover">
                <i class="ace-icon fa fa-trash-o bigger-120"></i>
            </a>
            {{--<a href="javascript:void(0)" class="sys_remove_item" onclick="Import.removeItem({{$k}})"><i class="fa fa-trash-o"></i></a>--}}
        </td>
    </tr>
    <?php $i ++;$total += $total_item;$total_discount =0?>
    @endforeach
    </tbody>
</table>

<div class="hr hr8 hr-double hr-dotted"></div>

<div class="row">
    <div class="col-sm-5 pull-right">
        <div class="col-sm-6 col-xs-6" style="margin-bottom: 5px">
            <b>Tổng tiền</b>
        </div>
        <div class="col-sm-6 col-xs-6 text-right" style="margin-bottom: 5px">
            <b>{{number_format($total, 0, ',', '.');}}</b>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <div class="radio">
                <label>
                    <input type="radio" class="ace" name="import_pay_discount_type" value="1" @if($import_pay_discount_type == 1) checked @endif>
                    <span class="lbl"> Chiết khấu %</span>
                </label>
            </div>
        </div>
        <div class="col-sm-6 col-xs-6 text-right sys_discount" id="sys_discount_1" @if($import_pay_discount_type != 1) style="display: none" @endif>
            <input type="text" id="import_pay_discount_percent" name="import_pay_discount_percent"
                   class="form-control text-right txt_input"
                   value="{{$discount_percent}}">
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <div class="radio">
                <label>
                    <input type="radio" class="ace" name="import_pay_discount_type" value="2" @if($import_pay_discount_type == 2) checked @endif>
                    <span class="lbl"> Chiết khấu VNĐ</span>
                </label>
            </div>
        </div>
        <div class="col-sm-6 col-xs-6 text-right sys_discount" id="sys_discount_2" @if($import_pay_discount_type != 2) style="display: none" @endif>
                <input type="text" id="import_pay_discount_vnd" name=""
                       class="form-control text-right txt_input"
                       value="{{number_format($discount_vnd, 0, ',', '.');}}">
                <input type="hidden" id="input_import_pay_discount_vnd" name="import_pay_discount_vnd"
                       class="form-control text-right "
                       value="{{$discount_vnd}}">
        </div>
        <div class="clearfix"></div>
        <div class="hr hr8 hr-double hr-dotted"></div>
        <div class="col-sm-6 col-xs-6">
            <b>Tổng thanh toán</b>
        </div>
        <div class="col-sm-6 col-xs-6 text-right">
            <b class="red">{{number_format($total-$total_discount, 0, ',', '.');}}</b>
        </div>
        <div class="clearfix"></div>
    </div>
    {{--<div class="col-sm-7 pull-left"> Extra Information</div>--}}
</div>
@endif