<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li>
                <a href="{{URL::route('admin.sale_list_fake_view')}}"> Bảng kê ảo</a>
            </li>
            <li class="active">Chi tiết bảng kê ảo</li>
        </ul>
        <!-- /.breadcrumb -->
    </div>
    <div class="page-header">
        <div class="text-right">
            <a target="_blank" href="{{URL::route('admin.sale_list_fake_pdf',array('id'=>base64_encode($sale_list['sale_list_id'])))}}" class="btn btn-danger btn-sm" style="margin-right: 15px"><i class="ace-icon fa fa-file-pdf-o"></i> Xuất bảng kê</a>
            <a href="{{URL::route('admin.exportExcelReportSaleListFake',array('id'=>base64_encode($sale_list['sale_list_id'])))}}" class="btn btn-success btn-sm" style="margin-right: 15px"><i class="ace-icon fa fa-file-excel-o"></i> Xuất excel</a>
        </div>
    </div>
    <!-- /.page-header -->
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="row text-center">
                    <b>BẢNG KÊ BÁN HÀNG</b>
                </div>
                <div class="row text-center position-relative">
                    Ngày tạo bảng : {{date('d/m/Y',$sale_list['sale_list_time'])}}
                    @if($sale_list['sale_list_bill'] != '')
                        &nbsp;&nbsp;&nbsp;Kèm HĐGTGT số {{$sale_list['sale_list_bill']}}
                    @endif
                    <span class="position-absolute" style="right: 2%">No : {{$sale_list['sale_list_code']}}</span>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-sm-12">
                        Đơn vị mua hàng : {{$customer['customers_FirstName']}} .
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        Địa chỉ : {{$customer['customers_BizAddress']}} .
                    </div>
                </div>
                @if($customer['customers_TaxCode'] != '')
                    <div class="row">
                        <div class="col-sm-12">
                            MST : {{$customer['customers_TaxCode']}} .
                        </div>
                    </div>
                @endif
                <div class="space-6"></div>
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                    <tr>
                        <td class="center" width="5%"><b>STT</b></td>
                        <td class="center" width="15%"><b>Mã hàng</b></td>
                        <td class="left" width="35%"><b>Tên hàng hóa</b></td>
                        <td class="center" width="10%"><b>Xuất xứ</b></td>
                        <td class="center" width="10%"><b>ĐVT</b></td>
                        <td class="center" width="10%"><b>Đơn giá</b></td>
                        <td class="center" width="5%"><b>SL</b></td>
                        <td class="center" width="10%"><b>Thành tiền</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sub_total = 0;$discount = 0;?>
                    @foreach($product as $key => $value)
                        <tr>
                            <td class="center">{{$key+1}}</td>
                            <td class="center">{{$value['product_Code']}}</td>
                            <td>
                                <div style="margin-left: 5px">{{$value['product_Name']}}</div>
                            </td>
                            <td class="center">{{$value['product_NameOrigin']}}</td>
                            <td class="center">{{$value['product_NameUnit']}}</td>
                            <td class="text-right">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
                            <td class="center">{{$value['export_product_num']}}</td>
                            <td class="text-right"><b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
                            <?php $sub_total += $value['export_product_total'];?>
                            <?php $discount += $value['export_product_discount'];?>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <b>Cộng tiền hàng</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($sub_total, 0, '.', '.');}}</b>
                        </td>
                    </tr>
                    @if($discount > 0)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <b>Chiết khấu</b>
                            </td>
                            <td colspan="5" class="text-right">
                                <b class="red">{{number_format($discount, 0, '.', '.');}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <b>Tổng tiền sau chiết khấu</b>
                            </td>
                            <td colspan="5" class="text-right">
                                <b class="red">{{number_format((int)($sub_total - $discount), 0, '.', '.');}}</b>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <b>Thuế GTGT</b>
                        </td>
                        <td colspan="5" class="text-right">
                            @if($customer['customers_IsNeededVAT'])
                                <?php $vat = (int)(($sub_total - $discount) / 10);?>
                            @else
                                <?php $vat = 0;?>
                            @endif
                            <?php ?>
                            <b class="red">{{number_format($vat, 0, '.', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <b>Tổng tiền thanh toán</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <?php $total = $sub_total - $discount + $vat ;?>
                            <b class="red">{{number_format($total, 0, '.', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <i>Bằng chữ : {{FunctionLib::numberToWord($total)}}</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.page-content -->
</div>