<section class="content-header">
    <h1>
        Quản lý Log Cronjob
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">QL Log</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lọc dữ liệu</h3>
    </div>
    <form role="form">
        <div class="box-body">

            <div class="form-group col-lg-4">
                <label for="book_name">Ngày chạy từ</label>
                <input id="log_created_at_from" name="log_created_at_from" class="form-control" type="text" @if(isset($search['log_created_at_from']) && $search['log_created_at_from'] !='')value="{{$search['log_created_at_from']}}"@else value=""@endif>
            </div>

            <div class="form-group col-lg-4">
                <label for="book_status">đến</label>
                <input id="log_created_at_to" name="log_created_at_to" class="form-control" type="text" @if(isset($search['log_created_at_to']) && $search['log_created_at_to'] !='')value="{{$search['log_created_at_to']}}"@else value=""@endif>
            </div>

            <div class="form-group col-lg-4">
                <button class="btn btn-primary mrgTop20" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div style="clear:both"></div>
</div>
@if(!empty($data))
<div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline">
        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
        </div>
        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr role="row">
                <th width="5%" class="text-center">STT</th>
                <th width="30%" class="text-center">Kiểu</th>
                <th width="20%" class="text-center">Thời gian chạy (giây)</th>
                <th width="20%" class="text-center">Thời gian chạy</th>
                <th width="10%" class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $k=>$itm)
            <tr class="@if($k % 2 == 0)even @else odd @endif">
                <td align="center">{{$stt+$k+1}}</td>
                <td align="center">@if($itm['log_type'] == 1)Chạy cronjob @else --- @endif</td>
                <td align="center">{{$itm['log_run_time']}}</td>
                <td align="center">{{date('d-m-Y H:i',$itm['log_created_at'])}}</td>

                <td class="text-center">
                    @if ($is_root || $permission_item == 1)
                       <a href="javascript:;" onclick="Common.getViewLog({{ $itm['log_id'] }})" title="Xem trạng thái đơn hàng bên COD"><i class="fa fa-eye"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example2_info">Hiển thị {{$sizeShow}} của {{$size}} kết quả</div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_bootstrap">
                    {{$pagging}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</section>

<script type="text/javascript">
    $(document).ready(function() {
        var checkin = $('#log_created_at_from').datetimepicker({timepicker:false,format:'d-m-Y' });
        var checkout = $('#log_created_at_to').datetimepicker({timepicker:false,format:'d-m-Y' });
    });
</script>

<div class="modal fade" id="sys_PopupShowLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Log chạy cronjob</h4>
            </div>
            <div class="modal-body">
                <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading">
                <div class="form_group" id="sys_block_popup_infor">
                    <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                        <div class="float-left marginTop10" style="width: 100%">
                            <div class="form-group" id="sys_infor_view" style="display: none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>