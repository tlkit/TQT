<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Hóa đơn nhập kho</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-4">
                            <label for="import_code">Mã hóa đơn</label>
                            <input type="text" class="form-control input-sm" id="import_code" name="import_code" placeholder="" @if(isset($param['import_code']) && $param['import_code'] != '')value="{{$param['import_code']}}"@endif>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="import_create_id">Người lập </label>
                            <select name="import_create_id" id="import_create_id" class="form-control input-sm">
                                <option value="0" @if($param['import_create_id'] == 0) selected="selected" @endif>-- Người lập hóa đơn --</option>
                                @foreach($admin as $k => $v)
                                    <option value="{{$k}}" @if($param['import_create_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="providers_id">Nhà cung cấp </label>
                            <select name="providers_id" id="providers_id" class="form-control input-sm">
                                <option value="0" @if($param['providers_id'] == 0) selected="selected" @endif>-- Nhà cung cấp --</option>
                                @foreach($providers as $k => $v)
                                    <option value="{{$k}}" @if($param['providers_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="import_status">Trạng thái </label>
                            <select name="import_status" id="import_status" class="form-control input-sm">
                                @foreach($aryStatus as $k => $v)
                                    <option value="{{$k}}" @if($param['import_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="import_create_start">Ngày tạo từ </label>
                            <input type="text" class="form-control input-sm" id="import_create_start" name="import_create_start" placeholder="" @if(isset($param['import_create_start']) && $param['import_create_start'] != '')value="{{$param['import_create_start']}}"@endif>
                        </div><div class="form-group col-lg-4">
                            <label for="import_create_end">Đến</label>
                            <input type="text" class="form-control input-sm" id="import_create_end" name="import_create_end" placeholder="" @if(isset($param['import_create_end']) && $param['import_create_end'] != '')value="{{$param['import_create_end']}}"@endif>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.import')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Nhập kho
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> danh mục @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                            <tr class="">
                                <th class="center" width="5%">STT</th>
                                <th class="center" width="10%">Mã HD</th>
                                <th class="center" width="10%">Nhà cung cấp</th>
                                <th class="center" width="10%">Nhân viên</th>
                                <th class="center" width="10%">Tổng tiền</th>
                                <th class="center" width="10%">Thời gian tạo</th>
                                <th class="center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr id="{{$item['import_code']}}" @if($item['import_status'] == 0)class="orange bg-warning" @endif>
                                <td class="center">{{ $start + $key+1 }}</td>
                                <td class="center">{{ $item['import_code'] }}</td>
                                <td class="center">{{$providers[$item['providers_id']]}}</td>
                                <td class="center">{{$admin[$item['import_create_id']]}}</td>
                                <td class="text-right">{{number_format($item['import_price'],0,'.','.')}}</td>
                                <td class="center">{{date('d-m-Y H:i',$item['import_create_time'])}}</td>
                                <td>
                                    @if($item['import_status'] == 1)
                                    <div class="col-sm-3"><a href="" title="Chi tiết hóa đơn"><i class="fa fa-file-text-o fa-2x"></i></a></div>
                                    <div class="col-sm-3"><a href="" title="Xuất pdf"><i class="fa fa-file-pdf-o fa-2x"></i></a></div>
                                    <div class="col-sm-3"><a href="javascript:void(0)" title="Hủy hóa đơn" data-target="#import_{{$item['import_code']}}" data-toggle="modal"><i class="fa fa-trash-o fa-2x"></i></a></div>
                                    <div class="col-sm-3"><a href="javascript:void(0)" title="Hủy hóa đơn và tạo lại" class="sys_restore_import" data-id="{{$item['import_id']}}" data-code="{{$item['import_code']}}"><i class="fa fa-history fa-2x"></i></a></div>
                                    {{--modal--}}
                                    <div class="modal fade" role="dialog" id="import_{{$item['import_code']}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="gridSystemModalLabel">Lý do hủy hóa đơn {{$item['import_code']}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea rows="5" class="form-control input-sm" id="import_note_{{$item['import_code']}}"
                                                              name="import_note"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary sys_delete_import" data-id="{{$item['import_id']}}" data-code="{{$item['import_code']}}">Hủy hóa đơn</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    @else
                                        <div class="col-sm-3"><a href="javascript:void(0)" title="Ghi chú" data-target="#note_{{$item['import_code']}}" data-toggle="modal"><i class="fa fa-bookmark-o fa-2x"></i></a></div>
                                        {{--modal--}}
                                        <div class="modal fade grey" role="dialog" id="note_{{$item['import_code']}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="gridSystemModalLabel">Lý do hủy hóa đơn {{$item['import_code']}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <b>{{$admin[$item['import_update_id']]}} : </b>{{$item['import_note']}}
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
{{HTML::script('assets/admin/js/import.js');}}