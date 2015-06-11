<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách nhân viên</li>
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
                            <label for="providers_Name"><i>Tên nhân viên</i></label>
                            <input type="text" class="form-control input-sm" id="personnel_name" name="personnel_name"
                                   placeholder="Tên nhân viên"
                                   @if(isset($search['personnel_name']) && $search['personnel_name'] != '')value="{{$search['personnel_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="providers_Phone"><i>Số điện thoại</i></label>
                            <input type="text" class="form-control input-sm" id="personnel_phone" name="personnel_phone"
                                   placeholder="Số điện thoại"
                                   @if(isset($search['personnel_phone']) && $search['personnel_phone'] != '')value="{{$search['personnel_phone']}}"@endif>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.personnel_edit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> nhân viên @endif </div>
                    <br>
                    <table class="table table-bordered table-hover dataTable">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="20%">Họ tên nhân viên</th>
                            <th width="15%">Số điện thoại</th>
                            <th width="20%">ĐC thường trú</th>
                            <th width="20%">ĐC hiện tại</th>
                            <th width="10%" class="text-center">Tình trạng</th>
                            <th width="5%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>
                                    {{ $item['personnel_name'] }}
                                    @if($item['personnel_user_name'] != '') <br/>User:
                                        <a href="{{URL::route('admin.user_view',array('user_name' => $item['personnel_user_name']))}}" title="Tìm {{$item['personnel_user_name']}}" target="_blank">
                                           <b>{{$item['personnel_user_name']}}</b>
                                        </a>
                                    @endif
                                    @if($item['personnel_name'] != '') <br/>E: {{ $item['personnel_email'] }}@endif
                                    @if($item['personnel_brithday'] != '')<br/>B: {{date('d-m-Y',$item['personnel_brithday'])}}@endif
                                </td>
                                <td>{{ $item['personnel_phone'] }}</td>
                                <td>{{ $item['personnel_adress_1'] }}</td>
                                <td>{{ $item['personnel_adress_2'] }}</td>
                                <td>
                                @if(isset($arrStatus[$item['personnel_status']])){{$arrStatus[$item['personnel_status']]}} @else --- @endif
                                @if(isset($item['personnel_time_star_work']) && $item['personnel_time_star_work'] > 0)<br/>S: {{date('d-m-Y',$item['personnel_time_star_work'])}} @endif
                                @if(isset($item['personnel_time_out_work']) && $item['personnel_time_out_work'] > 0)<br/>E: {{date('d-m-Y',$item['personnel_time_out_work'])}} @endif
                                </td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.personnel_edit',array('id' => $item['personnel_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
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

