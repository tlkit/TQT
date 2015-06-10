<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li>
                <a href="{{URL::route('admin.import_view')}}">Danh sách nhập kho</a>
            </li>
            <li class="active">Nhập kho</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row" id="sys_import_content">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-sm-1 text-left col-xs-2">
                        <img src="/assets/admin/img/logo.png" alt=""/>
                    </div>
                    <div class="col-sm-11 col-xs-10">
                        <div><b>CÔNG TY TNHH THƯƠNG MẠI & VÀ DỊCH VỤ THIỀU SƠN</b></div>
                        <div><b>Trụ sở : Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, Hà Nội</b></div>
                        <div><b>Cơ sở 1 : CC2 - Bắc Linh Đàm - Hoàng Mai - Hà Nội</b></div>
                        <div><b>Cơ sở 2 : 73, Phố Nguyễn Văn Trỗi, Thanh Xuân, Hà Nội</b></div>
                        <div><b>ĐT : 04 66572 888 - 04 6686 0415 / Fax: 04 62841202 - Hotline: 0973323333</b></div>
                        <div><b>Website : http://banbuonvpp.vn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Email: vpp@banbuonvpp.vn</b></div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="row text-center">
                    <b>PHIẾU NHẬP KHO</b>
                </div>
                <div class="row text-center position-relative">
                    Ngày nhập kho : {{date('d/m/Y',$import['import_create_time'])}}
                    <span class="position-absolute" style="right: 2%">No : {{$import['import_code']}}</span>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-sm-12">
                        Nhà cung cấp : {{$providers['providers_Name']}}
                    </div>
                </div>
                <div class="space-6"></div>
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                        <tr>
                            <td class="center" width="5%">STT</td>
                            <td class="center" width="15%">Mã hàng</td>
                            <td class="left" width="30%">Tên hàng hóa</td>
                            <td class="center" width="10%">Xuất sứ</td>
                            <td class="center" width="10%">ĐVT</td>
                            <td class="center" width="10%">Đơn giá</td>
                            <td class="center" width="10%">Số lượng</td>
                            <td class="center" width="10%">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($importProduct as $key => $value)
                        <tr>
                            <td class="center">{{$key+1}}</td>
                            <td class="center">{{$value['product']['product_Code']}}</td>
                            <td>{{$value['product']['product_Name']}}</td>
                            <td class="center">{{$value['product']['product_NameOrigin']}}</td>
                            <td class="center">{{$value['product']['product_NameUnit']}}</td>
                            <td class="text-right">{{number_format($value['import_product_price'], 0, ',', '.');}}</td>
                            <td class="center">{{$value['import_product_num']}}</td>
                            <td class="text-right">
                                <b>{{number_format($value['import_product_total'], 0, ',', '.');}}</b></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-center">
                            <b>Tổng nhập</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($import['import_price'], 0, ',', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-left">
                            <i>Bằng chữ : {{FunctionLib::numberToWord($import['import_price'])}}</i>
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
            <button class="btn btn-primary" onclick="printContent('sys_import_content')"><i class="fa fa-print"></i> IN PHIẾU NHẬP</button>
            <a href="{{URL::route("admin.import_exportPdf",array('id' => base64_encode($import['import_id'])))}}" target="_blank" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> XUẤT PDF</a>
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