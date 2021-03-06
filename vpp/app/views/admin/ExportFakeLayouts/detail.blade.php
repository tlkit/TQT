<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li>
                <a href="{{URL::route('admin.export_fake_view')}}">Danh sách xuất kho ảo</a>
            </li>
            <li class="active">Xuất kho ảo</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row" id="sys_export_content" >
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-sm-1 text-left col-xs-2">
                        <img src="{{URL::asset('assets/admin/img/logo.png')}}" alt=""/>
                    </div>
                    <div class="col-sm-11 col-xs-10">
                        <div><b>CÔNG TY TNHH THƯƠNG MẠI & VÀ DỊCH VỤ THIỀU SƠN</b></div>
                        <div><b>VPGD: Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội. </b></div>
                        {{--<div><b>Cơ sở 1 : CC2 - Bắc Linh Đàm - Hoàng Mai - Hà Nội</b></div>--}}
                        {{--<div><b>Cơ sở 2 : 73, Phố Nguyễn Văn Trỗi, Thanh Xuân, Hà Nội</b></div>--}}
                        <div><b>ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline: 0973323333</b></div>
                        <div><b>Website : http://banbuonvpp.vn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Email: vpp@banbuonvpp.vn</b></div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="row text-center">
                    <b>PHIẾU XUẤT KHO</b>
                </div>
                <div class="row text-center position-relative">
                    Ngày xuất kho : {{date('d/m/Y',$export['export_create_time'])}}
                    <span class="position-absolute" style="right: 2%">No : {{$export['export_code']}}</span>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-sm-12">
                        Đơn vị nhận hàng : {{$export['export_customers_name']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        Địa chỉ giao hàng : {{$export['export_customers_address']}}
                    </div>
                </div><div class="row">
                    <div class="col-sm-12">
                        Người liên hệ : {{$export['export_user_customer']}} .
                        @if($export['export_customer_phone'])
                            Điện thoại : {{$export['export_customer_phone']}}
                        @endif
                    </div>
                </div>
                <div class="space-6"></div>
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                    <tr>
                        <td class="center" width="5%">STT</td>
                        <td class="center" width="10%">Mã hàng</td>
                        <td class="left" width="35%">Tên hàng hóa</td>
                        <td class="center" width="10%">Xuất xứ</td>
                        <td class="center" width="10%">ĐVT</td>
                        <td class="center" width="10%">Đơn giá</td>
                        <td class="center" width="5%">SL</td>
                        <td class="center" width="15%">Thành tiền</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exportProduct as $key => $value)
                        <tr>
                            <td class="center">{{$key+1}}</td>
                            <td class="center">{{$value['product']['product_Code']}}</td>
                            <td>{{$value['product']['product_Name']}}</td>
                            <td class="center">{{$value['product']['product_NameOrigin']}}</td>
                            <td class="center">{{$value['product']['product_NameUnit']}}</td>
                            <td class="text-right">{{number_format($value['export_product_price'], 0, ',', '.');}}</td>
                            <td class="center">{{$value['export_product_num']}}</td>
                            <td class="text-right">
                                <b>{{number_format($value['export_product_total'], 0, ',', '.');}}</b></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="" class="text-left">
                            <b>Cộng tiền hàng</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($export['export_subtotal'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    @if($export['export_discount'] > 0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="" class="text-left">
                            <b>Chiết khấu</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($export['export_discount'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="" class="text-left">
                            <b>Tổng tiền hàng</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($export['export_total'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="" class="text-left">
                            <b>Thuế GTGT</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($export['export_vat'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="" class="text-left">
                            <b>Tổng thanh toán</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($export['export_total_pay'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-left">
                            <i>Bằng chữ : {{FunctionLib::numberToWord($export['export_total_pay'])}}</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="space-6"></div>
                <div class="col-sm-4 col-xs-4 text-center">
                    <p>Thủ kho</p>
                    <p>(Kí, họ tên)</p>
                </div>
                <div class="col-sm-4 col-xs-4 text-center">
                    <p>Người giao hàng</p>
                    <p>(Kí, họ tên)</p>
                </div>
                <div class="col-sm-4 col-xs-4 text-center">
                    <p>Người nhận hàng</p>
                    <p>(Kí, họ tên)</p>
                </div>
                <div class="space-6"></div>
                <div class="space-6"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="space-6"></div>
        <div class="col-sm-12 text-center padding-10">
            <button class="btn btn-primary" onclick="printContent('sys_export_content')"><i class="fa fa-print"></i> IN PHIẾU XUẤT</button>
            <a href="{{URL::route("admin.export_fake_exportPdf",array('id' => base64_encode($export['export_id'])))}}" target="_blank" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> XUẤT PDF</a>
        </div>

    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>