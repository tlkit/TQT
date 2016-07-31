<script type="text/javascript">
    var waypts = [];

</script>
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Hóa đơn xuất kho</li>
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
                            <label for="export_code">Mã hóa đơn</label>
                            <input type="text" class="form-control input-sm" id="export_code" name="export_code" placeholder="" @if(isset($param['export_code']) && $param['export_code'] != '')value="{{$param['export_code']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="export_create_id">Người lập </label>
                            <select name="export_create_id" id="export_create_id" class="form-control input-sm">
                                <option value="0" @if($param['export_create_id'] == 0) selected="selected" @endif>-- Người lập hóa đơn --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['export_create_id'] == $k) selected="selected" @endif>{{$v}}</option>
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
                        <div class="form-group col-lg-3">
                            <label for="export_status">Trạng thái </label>
                            <select name="export_status" id="export_status" class="form-control input-sm">
                                @foreach($aryStatus as $k => $v)
                                    <option value="{{$k}}" @if($param['export_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-lg-3">
                            <label for="export_user_store">Thủ kho </label>
                            <select name="export_user_store" id="export_user_store" class="form-control input-sm">
                                <option value="0" @if($param['export_user_store'] == 0) selected="selected" @endif>-- Thủ kho --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['export_user_store'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="export_user_cod">Người giao hàng </label>
                            <select name="export_user_cod" id="export_user_cod" class="form-control input-sm">
                                <option value="0" @if($param['export_user_cod'] == 0) selected="selected" @endif>-- Người giao hàng --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['export_user_cod'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="export_create_start">Ngày tạo từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="export_create_start" name="export_create_start" class="form-control" @if(isset($param['export_create_start']) && $param['export_create_start'] != '')value="{{$param['export_create_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="export_create_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="export_create_end" name="export_create_end" class="form-control" @if(isset($param['export_create_end']) && $param['export_create_end'] != '')value="{{$param['export_create_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($permission_create)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.export')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Xuất kho
                            </a>
                        </span>
                        @endif
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>


                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> xuất kho @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="5%">Chọn COD</th>
                            <th class="center" width="10%">Mã HĐ</th>
                            <th class="center" width="30%">Khách hàng</th>
                            <th class="center" width="10%">Thủ kho</th>
                            <th class="center" width="10%">Người giao</th>
                            <th class="center" width="10%">Tổng tiền</th>
                            <th class="center" width="10%">Thời gian tạo</th>
                            <th class="center" width="15%">Thao tác</th>
                        </tr>
                        </thead>
                        @if($param['export_status'] == 1)
                        <div style="clear: both"></div>
                        <select name="list_user_content" id="sys_list_user_content" class="form-control" style="width: 200px; display: inline-block;">
                            <option value="0">Chọn nhân viên giao hàng</option>
                            @foreach($admin as $k => $v)
                                <option value="{{$k}}">{{$v}}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-warning" id="sys_test_not_approve" onclick="AdminCart.assignCOD();">Assign</button>
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <div class="form-group col-lg-3">
                                                <label for="sys_add_start">Điểm bắt đầu</label>
                                                <input type="text" class="form-control input-sm" id="sys_add_start" name="sys_add_start" placeholder="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội" value="{{$start}}">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <label for="sys_add_go">Các điểm cần đến</label>
                                                <i>(Ctrl-Click để chọn nhiều địa điểm, tối đa 8 điểm đến)</i> <br>
                                                <select multiple id="sys_add_go">
                                                    @foreach ($data as $key => $item)
                                                        <option value="{{$item['export_customers_address']}}" selected>{{$item['export_customers_address']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="sys_add_end">Điểm về</label>
                                                <input type="text" class="form-control input-sm" id="sys_add_end" name="sys_add_end" placeholder="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội" value="{{$end}}">
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                    <span class="">
                                        <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="AdminCart.findAllMapSelect()" ><i class="fa fa-search"></i> Xem đường đi</a>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row" id="sys_map" style="display: none; padding: 10px;">
                            <div class="col-sm-12">
                                <div id="map" style="width: 80%; height:1000px;float: left; margin-right: 5px;"></div>
                                <div id="panel" style="width: 200px;height:1000px; max-height:1000px;float: left;overflow-y: scroll;"></div>
                            </div>
                        </div>
                        @endif
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr id="{{$item['export_code']}}" @if($item['export_status'] == 0)class="orange bg-warning" @endif>
                                <td class="center">{{ $start + $key+1 }}</td>
                                <td class="center">
                                    <input @if(isset($admin[$item['export_user_cod']])) disabled class="nocheck" @else class="check" @endif  type="checkbox" name="checkProductId[]" value="{{$item['export_id']}}">
                                </td>
                                <td class="center">{{ $item['export_code'] }}</td>
                                <td class="center">@if(isset($customers[$item['customers_id']])){{$customers[$item['customers_id']]}}@endif</td>
                                <td class="center">@if(isset($admin[$item['export_user_store']])){{$admin[$item['export_user_store']]}}@endif</td>
                                <td class="center">@if(isset($admin[$item['export_user_cod']])){{$admin[$item['export_user_cod']]}}@endif</td>
                                <td class="text-right">{{number_format($item['export_total_pay'],0,'.','.')}}</td>
                                <td class="center">{{date('d-m-Y H:i',$item['export_create_time'])}}</td>
                                <td>
                                    @if($item['export_status'] >= 1)
                                        <script type="text/javascript">
                                            waypts.push({
                                                location: "{{$item['export_customers_address']}}" ,
                                                stopover: true
                                            });
                                        </script>
                                        <a href="{{URL::route('admin.export_detail',array('id' => base64_encode($item['export_id'])))}}" class="btn btn-xs btn-primary" data-content="Chi tiết hóa đơn" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-file-text-o bigger-120"></i>
                                        </a>
                                        {{--<div class="col-sm-3"><a href="{{URL::route('admin.export_detail',array('id' => base64_encode($item['export_id'])))}}" title="Chi tiết hóa đơn"><i class="fa fa-file-text-o fa-2x"></i></a></div>--}}
                                        <a href="{{URL::route('admin.export_exportPdf',array('id' => base64_encode($item['export_id'])))}}" target="_blank" class="btn btn-xs btn-danger" data-content="Xuất pdf" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-file-pdf-o bigger-120"></i>
                                        </a>
                                        {{--<div class="col-sm-3"><a href="{{URL::route('admin.export_exportPdf',array('id' => base64_encode($item['export_id'])))}}" target="_blank" title="Xuất pdf"><i class="fa fa-file-pdf-o fa-2x"></i></a></div>--}}
                                        @if($permission_edit)
                                            <a href="javascript:void(0)" class="btn btn-xs btn-warning sys_open_delete" data-code="{{$item['export_code']}}" data-content="Hủy hóa đơn" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </a>
                                        {{--<div class="col-sm-3"><a href="javascript:void(0)" title="Hủy hóa đơn" class="sys_open_delete" data-code="{{$item['export_code']}}"><i class="fa fa-trash-o fa-2x"></i></a></div>--}}
                                        @if($permission_create)
                                            <a href="javascript:void(0)" class="btn btn-xs btn-success sys_open_restore" data-code="{{$item['export_code']}}" data-content="Sửa đơn hàng" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                                <i class="ace-icon fa fa-history bigger-120"></i>
                                            </a>
                                        {{--<div class="col-sm-3"><a href="javascript:void(0)" title="Hủy hóa đơn và tạo lại" class="sys_open_restore" data-code="{{$item['export_code']}}"><i class="fa fa-history fa-2x"></i></a></div>--}}
                                        @endif
                                        {{--modal--}}
                                        <div class="modal fade" role="dialog" id="export_{{$item['export_code']}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="gridSystemModalLabel">Lý do hủy hóa đơn {{$item['export_code']}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    <textarea rows="5" class="form-control input-sm" id="export_note_{{$item['export_code']}}"
                                                              name="export_note"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary sys_delete_export" data-id="{{$item['export_id']}}" data-code="{{$item['export_code']}}">Hủy hóa đơn</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-xs btn-warning" data-target="#note_{{$item['export_code']}}" data-toggle="modal" data-content="Ghi chú" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-bookmark-o bigger-120"></i>
                                        </a>
                                        {{--<div class="col-sm-3"><a href="javascript:void(0)" title="Ghi chú" data-target="#note_{{$item['export_code']}}" data-toggle="modal"><i class="fa fa-bookmark-o fa-2x"></i></a></div>--}}
                                        {{--modal--}}
                                        <div class="modal fade grey" role="dialog" id="note_{{$item['export_code']}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="gridSystemModalLabel">Lý do hủy hóa đơn {{$item['export_code']}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <b>{{$admin[$item['export_update_id']]}} : </b>{{$item['export_note']}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    @endif
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
{{HTML::script('assets/admin/js/export.js');}}
<script type="text/javascript">
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

</script>