<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Thống kê nhập hàng ảo</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="col-lg-3 col-sm-6 sys_time">
                            <label for="import_product_create_start">Ngày nhập hàng từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="import_product_create_start" name="import_product_create_start" class="form-control" @if(isset($param['import_product_create_start']) && $param['import_product_create_start'] != '')value="{{$param['import_product_create_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 sys_time">
                            <label for="import_product_create_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="import_product_create_end" name="import_product_create_end" class="form-control" @if(isset($param['import_product_create_end']) && $param['import_product_create_end'] != '')value="{{$param['import_product_create_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 input-group-sm">
                            <label for="providers_id">Nhà cung cấp </label>
                            <select name="providers_id" id="providers_id" class="form-control input-sm" data-placeholder="Chọn nhà cung cấp">
                                <option value="0" @if($param['providers_id'] == 0) selected="selected" @endif></option>
                                @foreach($provider as $k => $v)
                                    <option value="{{$k}}" @if($param['providers_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 input-group-sm">
                            <label for="product_id">Sản phẩm </label>
                            <select name="product_id" id="product_id" class="form-control input-sm" data-placeholder="Chọn sản phẩm">
                                <option value="0" @if($param['product_id'] == 0) selected="selected" @endif></option>
                                @foreach($product as $k => $v)
                                    <option value="{{$k}}" @if($param['product_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <button class="btn btn-danger btn-sm" name="submit" value="2"><i class="ace-icon fa fa-file-excel-o"></i> Xuất Excel</button>
                            <button class="btn btn-primary btn-sm" name="submit" value="1"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="10%">Mã SP</th>
                            <th class="center" width="30%">Tên SP</th>
                            <th class="center" width="10%">Thời gian</th>
                            <th class="center" width="10%">SL</th>
                            <th class="center" width="15%">Giá nhập</th>
                            <th class="center" width="20%">NCC</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1}}</td>
                                <td class="center">{{$item['product_Code']}}</td>
                                <td class="text-left">{{$item['product_Name']}}</td>
                                <td class="center">{{date('d-m-Y',$item['import_product_create_time'])}}</td>
                                <td class="center">{{$item['import_product_num']}}</td>
                                <td class="text-right">{{number_format($item['import_product_price'],0,'.','.')}}</td>
                                <td class="text-left">{{$provider[$item['providers_id']]}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                    @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script type="text/javascript">
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
    $( "#import_product_create_start" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#import_product_create_end").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#import_product_create_end').focus();
        }
    });
    $( "#import_product_create_end" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
//        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy'
    });
    $('#providers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
    $('#product_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
</script>