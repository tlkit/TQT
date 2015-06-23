<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Thống kê xuất hàng</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="col-lg-3 col-sm-4 sys_time">
                            <label for="export_create_start">Ngày xuất hàng từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="export_create_start" name="export_create_start" class="form-control" @if(isset($param['export_create_start']) && $param['export_create_start'] != '')value="{{$param['export_create_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4 sys_time">
                            <label for="export_create_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="export_create_end" name="export_create_end" class="form-control" @if(isset($param['export_create_end']) && $param['export_create_end'] != '')value="{{$param['export_create_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4 input-group input-group-sm">
                            <label for="customers_id">Khách hàng </label>
                            <select name="customers_id" id="customers_id" class="form-control input-sm" data-placeholder="Chọn khách hàng">
                                <option value="0" @if($param['customers_id'] == 0) selected="selected" @endif></option>
                                @foreach($customer as $k => $v)
                                    <option value="{{$k}}" @if($param['customers_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="10%">STT</th>
                            <th class="center" width="45%">Khách hàng</th>
                            <th class="center" width="15%">CK Cá nhân</th>
                            <th class="center" width="15%">CK Công ty</th>
                            <th class="center" width="15%">Tổng tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1}}</td>
                                <td class="text-left">{{$customer[$item['customers_id']]}}</td>
                                <td class="text-right">{{number_format($item['ckcn'],0,'.','.')}}</td>
                                <td class="text-right">{{number_format($item['ckdn'],0,'.','.')}}</td>
                                <td class="text-right">{{number_format(($item['ckcn']+$item['ckdn']),0,'.','.')}}</td>
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
{{HTML::script('assets/admin/js/export.js');}}
<script type="text/javascript">
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
    $( "#export_create_start" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
//        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#export_create_end").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#export_create_end').focus();
        }
    });
    $( "#export_create_end" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
//        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy'
    });
    $('#customers_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
</script>