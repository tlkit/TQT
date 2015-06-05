@if(isset($error) && $error != '')
    <div class="alert alert-danger">
        {{$error}}
    </div>
@endif
@if($import)
<table class="table table-striped table-bordered">
    <thead class="thin-border-bottom">
    <tr>
        <th class="center">#</th>
        <th class="center">Mã hàng</th>
        <th class="hidden-480">Tên hàng hóa</th>
        <th class="center hidden-xs">Xuất sứ</th>
        <th class="center hidden-480">Đơn vị tính</th>
        <th class="center hidden-480">Giá nhập</th>
        <th class="center hidden-480">Số lượng</th>
        <th class="center">Thành tiền</th>
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
        <td class="center hidden-xs">{{$v['product_OriginID']}}</td>
        <td class="center hidden-480">{{$v['product_UnitID']}}</td>
        <td class="text-right hidden-480">{{number_format($v['import_product_price'], 0, ',', '.');}}</td>
        <td class="center hidden-480">{{$v['import_product_num']}}</td>
        <td class="text-right hidden-480"><b>{{number_format($total_item, 0, ',', '.');}}</b></td>
    </tr>
    <?php $i ++;$total += $total_item;?>
    @endforeach
    </tbody>
</table>

<div class="hr hr8 hr-double hr-dotted"></div>

<div class="row">
    <div class="col-sm-5 pull-right">
        <h4 class="pull-right">
            Tổng tiền :
            <span class="red">{{number_format($total, 0, ',', '.');}} VNĐ</span>
        </h4>
    </div>
    {{--<div class="col-sm-7 pull-left"> Extra Information</div>--}}
</div>
@endif