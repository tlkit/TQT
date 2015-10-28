<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Bảng kê bán hàng</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="sale_list_code">Mã bảng kê</label>
                            <input type="text" class="form-control input-sm" id="sale_list_code" name="sale_list_code" placeholder="" @if(isset($param['sale_list_code']) && $param['sale_list_code'] != '')value="{{$param['sale_list_code']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="sale_list_code">Hóa đơn GTGT</label>
                            <input type="text" class="form-control input-sm" id="sale_list_bill" name="sale_list_bill" placeholder="" @if(isset($param['sale_list_bill']) && $param['sale_list_bill'] != '')value="{{$param['sale_list_bill']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="sale_list_create_id">Người tạo </label>
                            <select name="sale_list_create_id" id="sale_list_create_id" class="form-control input-sm">
                                <option value="0" @if($param['sale_list_create_id'] == 0) selected="selected" @endif>-- Người lập hóa đơn --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['sale_list_create_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="customers_id">Khách hàng </label>
                            <select name="customers_id" id="customers_id" class="form-control input-sm">
                                <option value="0" @if($param['customers_id'] == 0) selected="selected" @endif>-- Chọn khách hàng --</option>
                                @foreach($customers as $k => $v)
                                    <option value="{{$k}}" @if($param['customers_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-lg-3">
                            <label for="sale_list_status">Trạng thái </label>
                            <select name="sale_list_status" id="sale_list_status" class="form-control input-sm">
                                @foreach($aryStatus as $k => $v)
                                    <option value="{{$k}}" @if($param['sale_list_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="sale_list_type">Thanh toán </label>
                            <select name="sale_list_type" id="sale_list_type" class="form-control input-sm">
                                @foreach($aryType as $k => $v)
                                    <option value="{{$k}}" @if($param['sale_list_type'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="sale_list_start">Ngày tạo từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="sale_list_start" name="sale_list_start" class="form-control" @if(isset($param['sale_list_start']) && $param['sale_list_start'] != '')value="{{$param['sale_list_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="sale_list_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="sale_list_end" name="sale_list_end" class="form-control" @if(isset($param['sale_list_end']) && $param['sale_list_end'] != '')value="{{$param['sale_list_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{--@if($permission_create)--}}
                            <span class="">
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.sale_list_create')}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    Tạo bảng kê
                                </a>
                            </span>
                        {{--@endif--}}
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> bảng kê @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="8%">Mã BK</th>
                            <th class="center" width="8%">Hóa đơn GTGT</th>
                            <th class="center" width="30%">Khách hàng</th>
                            <th class="center" width="7%">Người tạo</th>
                            <th class="center" width="10%">Tổng tiền</th>
                            <th class="center" width="10%">TT Thanh toán</th>
                            <th class="center" width="7%">Thời gian tạo</th>
                            <th class="center" width="15%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr id="{{$item['sale_list_code']}}">
                                <td class="center">{{ $start + $key+1 }}</td>
                                <td class="center"><a href="{{URL::route('admin.sale_list_detail',array('id'=>base64_encode($item['sale_list_id'])))}}" target="_blank">{{ $item['sale_list_code'] }}</a></td>
                                <td class="center">{{ $item['sale_list_bill'] }}</td>
                                <td class="left"><a href="{{URL::route('admin.customers_edit',array('id'=>$item['customers_id']))}}" target="_blank">@if(isset($customers[$item['customers_id']])){{$customers[$item['customers_id']]}}@endif</a></td>
                                <td class="center">@if(isset($admin[$item['sale_list_create_id']])){{$admin[$item['sale_list_create_id']]}}@endif</td>
                                <td class="text-right">{{number_format($item['sale_list_total_pay'],0,'.','.')}}</td>
                                <th class="center" width="10%">
                                    @if($item['sale_list_type'] == 1)
                                        <span class="red"> Công nợ</span>
                                    @else
                                        <span class="green">Đã  thanh toán</span>
                                    @endif
                                </th>
                                <td class="center">{{date('d-m-Y H:i',$item['sale_list_create_time'])}}</td>
                                <td>
                                    @if($item['sale_list_type'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-xs btn-info sys_update_payment" data-id="{{$item['sale_list_id']}}" data-code="{{$item['sale_list_code']}}" data-content="Cập nhật thanh toán" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-credit-card bigger-120"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-xs btn-danger" href="{{URL::route('admin.sale_list_pdf',array('id'=>base64_encode($item['sale_list_id'])))}}" target="_blank" data-content="Xuất pdf" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                        <i class="ace-icon fa fa-file-pdf-o bigger-120"></i>
                                    </a>
                                    <a class="btn btn-xs btn-success" href="{{URL::route('admin.exportExcelReportSaleList',array('id'=>base64_encode($item['sale_list_id'])))}}" data-content="Xuất excel" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                        <i class="ace-icon fa fa-file-excel-o bigger-120"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
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
{{HTML::script('assets/admin/js/sale_list.js');}}
<script type="text/javascript">
    $( "#sale_list_start").datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#sale_list_end").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#sale_list_end').focus();
        }
    });
    $( "#sale_list_end").datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
//        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy'
    });
</script>