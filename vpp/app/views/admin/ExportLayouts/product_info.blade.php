@if(isset($error) && $error != '')
    <div class="alert alert-danger">
        {{$error}}
    </div>
@endif
@if($export)
    <table class="table table-striped table-bordered">
        <thead class="thin-border-bottom">
        <tr>
            <th class="center">#</th>
            <th class="center">Mã hàng</th>
            <th class="hidden-480">Tên hàng hóa</th>
            <th class="center hidden-xs">Xuất sứ</th>
            <th class="center hidden-480">Đơn vị tính</th>
            <th class="center hidden-480">Giá</th>
            <th class="center hidden-480">Số lượng</th>
            <th class="center">Thành tiền</th>
            <th class="center">Thao tác</th>
        </tr>
        </thead>

        <tbody>
        <?php $i = 1;$total = 0;$total_discount = 0;?>
        @foreach($export as $k => $v)
            <?php
            $total_item = $v['export_product_price'] * $v['export_product_num'];
            $discount_item =  $v['export_product_price'] * $v['export_product_num'] * $v['export_product_discount']
            ?>
            <tr>
                <td class="center">{{$i}}</td>
                <td class="center">{{$v['product_Code']}}</td>
                <td class="hidden-480"><a href="#">{{$v['product_Name']}}</a></td>
                <td class="center hidden-xs">{{$v['product_NameOrigin']}}</td>
                <td class="center hidden-480">{{$v['product_NameUnit']}}</td>
                <td class="text-right hidden-480">{{number_format($v['export_product_price'], 0, ',', '.');}}</td>
                <td class="center hidden-480">{{$v['export_product_num']}}</td>
                <td class="text-right hidden-480"><b>{{number_format($total_item, 0, ',', '.');}}</b></td>
                <td class="center"><a href="javascript:void(0)" class="sys_remove_item" onclick="Export.removeItem({{$k}})"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            <?php $i ++;$total += $total_item;$total_discount += $discount_item?>
        @endforeach
        </tbody>
    </table>

    <div class="hr hr8 hr-double hr-dotted"></div>

    <div class="row">
        <div class="col-sm-5 pull-right">
            <div class="col-sm-6 col-xs-6"><b>Tổng tiền</b></div>
            <div class="col-sm-6 col-xs-6 text-right"><b class="">{{number_format($total, 0, ',', '.');}} VNĐ</b></div>
            <div class="clearfix"></div>
            @if($total_discount > 0)
            <div class="col-sm-6 col-xs-6"><b>Chiết khấu</b></div>
            <div class="col-sm-6 col-xs-6 text-right"><b class="">{{number_format($total_discount, 0, ',', '.');}} VNĐ</b></div>
            <div class="clearfix"></div>
            @endif
            @if($vat)
                <?php $total_vat = (int)(($total-$total_discount)*10/100);?>
            @else
                <?php $total_vat = 0;?>
            @endif
            <div class="col-sm-6 col-xs-6"><b>Thuế VAT</b></div>
            <div class="col-sm-6 col-xs-6 text-right"><b class="">{{number_format($total_vat, 0, ',', '.');}} VNĐ</b></div>
            <div class="clearfix"></div>
            <div class="hr hr8 hr-double hr-dotted"></div>
            <div class="col-sm-6 col-xs-6"><b>Tổng thanh toán</b></div>
            <div class="col-sm-6 col-xs-6 text-right"><b class="red">{{number_format($total-$total_discount+$total_vat, 0, ',', '.');}} VNĐ</b></div>
            <div class="clearfix"></div>
            {{--<h4 class="pull-right">--}}
                {{--Tổng tiền trước thuế :--}}
                {{--<span class="red">{{number_format($total, 0, ',', '.');}} VNĐ</span>--}}
            {{--</h4>--}}
            {{--<h4 class="pull-right">--}}
                {{--Thuế VAT :--}}
                {{--<span class="red">{{number_format($total, 0, ',', '.');}} VNĐ</span>--}}
            {{--</h4>--}}
            {{--<h4 class="pull-right">--}}
                {{--Tổng tiền :--}}
                {{--<span class="red">{{number_format($total, 0, ',', '.');}} VNĐ</span>--}}
            {{--</h4>--}}
        </div>
        {{--<div class="col-sm-7 pull-left"> Extra Information</div>--}}
    </div>
@endif