<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách phiếu thu - chi</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-9">
                            <label for="customers_FirstName"><i>Tên người thu-chi</i></label>
                            <input type="text" class="form-control input-sm" id="customers_FirstName"
                                   name="ticket_person_money" placeholder="Tên người thu-chi tiền"
                                   @if(isset($search['ticket_person_money']) && $search['ticket_person_money'] != '')value="{{$search['ticket_person_money']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="ticket_type"><i>Loại phiếu</i></label>
                            <select name="ticket_type" id="ticket_type" class="form-control input-sm" disabled>
                                <option value="0">-- Chọn loại phiếu --</option>
                                @foreach($arrTypeTicket as $k => $v)
                                    <option value="{{$k}}" @if($search['ticket_type'] == $k)
                                            selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="clear1"></div>
                        <div class="col-lg-3 sys_time">
                            <label for="export_product_create_start">Ngày tạo phiếu từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="ticket_time_created_start" name="ticket_time_created_start" class="form-control" @if(isset($search['ticket_time_created_start']) && $search['ticket_time_created_start'] != '')value="{{$search['ticket_time_created_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="export_product_create_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="ticket_time_created_end" name="ticket_time_created_end" class="form-control" @if(isset($search['ticket_time_created_end']) && $search['ticket_time_created_end'] != '')value="{{$search['ticket_time_created_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-3 sys_time">
                            <label for="ticket_time_approve_start">Ngày duyệt phiếu từ </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="ticket_time_approve_start" name="ticket_time_approve_start" class="form-control" @if(isset($search['ticket_time_approve_start']) && $search['ticket_time_approve_start'] != '')value="{{$search['ticket_time_approve_start']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 sys_time">
                            <label for="ticket_time_approve_end">Đến </label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="ticket_time_approve_end" name="ticket_time_approve_end" class="form-control" @if(isset($search['ticket_time_approve_end']) && $search['ticket_time_approve_end'] != '')value="{{$search['ticket_time_approve_end']}}"@endif/>
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($permission_create == 1 && isset($search['ticket_type']) && $search['ticket_type'] > 0)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.ticket_edit',array('id' => base64_encode(0),'type'=>$search['ticket_type']))}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        @endif
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit" name="submit" value="1"><i class="fa fa-search"></i> Tìm kiếm</button>
                            <button class="btn btn-danger btn-sm" type="submit" name="submit" value="2"><i class="fa fa-file-word-o"></i> Xuất Quỹ tiền mặt</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span"> @if($total >0) Có tổng số <b>{{$total}}</b> phiếu  thu - chi @endif </div>
                    <br/>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="4%" class="text-center">STT</th>
                            <th width="20%">Họ tên người thu - chi</th>
                            <th width="7%" class="text-center">Loại phiếu</th>
                            <th width="15%" class="text-right">Số tiền</th>

                            <th width="15%">Thông tin đơn vị</th>
                            <th width="10%">Thông tin phiếu</th>
                            <th width="15%">Tỷ giá ngoại tệ</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>
                                {{ $item['ticket_person_money'] }}
                                @if($item['ticket_person_address'] != '') <br/><b>ĐC:</b> {{$item['ticket_person_address']}}@endif
                                @if($item['ticket_reason'] != '') <br/><b>Lý do:</b> {{$item['ticket_reason']}}@endif
                                </td>
                                <td class="text-center">@if(isset($arrTypeTicket[$item['ticket_type']])){{ $arrTypeTicket[$item['ticket_type']] }} @else -- @endif</td>

                                <td class="text-right">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                       <tr>
                                          <td valign="left" width="32%">Thu-chi:</td>
                                          <td valign="right" width="68%">{{number_format($item['ticket_money'],0,'.','.')}}đ</td>
                                       </tr>
                                       <tr>
                                          <td valign="left">Đã nhận:</td>
                                          <td valign="right">{{number_format($item['ticket_money_pay'],0,'.','.')}}đ</td>
                                       </tr>
                                       @if($item['ticket_money_miss'] > 0)
                                       <tr>
                                          <td valign="left">Nợ:</td>
                                          <td valign="right">{{number_format($item['ticket_money_miss'],0,'.','.')}}đ</td>
                                       </tr>
                                       @endif
                                    </table>
                                </td>

                                <td>
                                    @if($item['ticket_company'] != '') <b>ĐV:</b> {{$item['ticket_company']}}<br/>@endif
                                    @if($item['ticket_company_address'] != '')<b>ĐC:</b> {{$item['ticket_company_address']}}<br/>@endif
                                    @if($item['ticket_company_mst'] != '')<b>MST:</b> {{$item['ticket_company_mst']}}@endif
                                </td>
                                <td>
                                    @if($item['ticket_book_number'] != '') <b>Quyển số:</b> {{$item['ticket_book_number']}}<br/>@endif
                                    @if($item['ticket_number'] != '') <b>Số:</b> {{$item['ticket_number']}}<br/>@endif
                                    @if($item['ticket_miss'] != '') <b>Nợ:</b> {{$item['ticket_miss']}}<br/>@endif
                                    @if($item['ticket_acttack'] != '') <b>Có:</b> {{$item['ticket_acttack']}}<br/>@endif
                                </td>
                                <td>
                                    @if($item['ticket_rate'] != '')<b>Tỷ giá:</b> {{$item['ticket_rate']}}<br/>@endif
                                    @if($item['ticket_rate_money'] != 0)<b>Quy đổi:</b> {{number_format($item['ticket_rate_money'],0,'.','.')}}đ<br/>@endif
                                    @if($item['ticket_time_created'] != 0)<b>Tạo:</b> {{date('d-m-Y',$item['ticket_time_created'])}}<br/>@endif
                                    @if($item['ticket_time_approve'] != 0)<b>Duyệt:</b> {{date('d-m-Y',$item['ticket_time_approve'])}}<br/>@endif
                                </td>

                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.ticket_edit',array('id' => base64_encode($item['ticket_id']),'type'=>$item['ticket_type']))}}" class="btn btn-xs btn-primary" title="Chi tiết phiếu" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-file-text-o bigger-120"></i>
                                        </a>
                                        <a href="{{URL::route('admin.ticket_export',array('id' => base64_encode($item['ticket_id'])))}}" class="btn btn-xs btn-danger" title="Xuất phiếu" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-file-word-o bigger-120"></i>
                                        </a>
                                    @endif
                                    <input type="hidden" value="{{$item['ticket_id']}}" name="ticket_id_{{$item['ticket_id']}}">
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
<script type="text/javascript">
    $( "#ticket_time_created_start" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
        onClose: function(selectedDate) {
            $("#ticket_time_created_end").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#ticket_time_created_end').focus();
        }
    });
    $( "#ticket_time_created_end" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy'
    });
    $( "#ticket_time_approve_start" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy',
        onClose: function(selectedDate) {
            $("#ticket_time_approve_end").datepicker("option", "minDate", selectedDate);
            $(this).parents('.sys_time').next().children().find('#ticket_time_approve_end').focus();
        }
    });
    $( "#ticket_time_approve_end" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: 'dd-mm-yy'
    });
</script>

