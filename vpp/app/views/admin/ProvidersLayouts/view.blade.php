<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách nhà cung cấp</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{--<div class="page-header">--}}
        {{--<h1>--}}
        {{--<small>--}}
        {{--Danh sách khách hàng--}}
        {{--</small>--}}
        {{--</h1>--}}
        {{--</div><!-- /.page-header -->--}}

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="providers_Name"><i>Tên nhà cung cấp</i></label>
                            <input type="text" class="form-control input-sm" id="providers_Name" name="providers_Name"
                                   placeholder="Tên nhà cung cấp"
                                   @if(isset($search['providers_Name']) && $search['providers_Name'] != '')value="{{$search['providers_Name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="providers_Phone"><i>Số điện thoại</i></label>
                            <input type="text" class="form-control input-sm" id="providers_Phone" name="providers_Phone"
                                   placeholder="Số điện thoại"
                                   @if(isset($search['providers_Phone']) && $search['providers_Phone'] != '')value="{{$search['providers_Phone']}}"@endif>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.providers_edit')}}">
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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> nhà cung cấp @endif </div>
                    <br>
                    <table class="table table-bordered table-hover dataTable">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="30%">Tên nhà cung cấp</th>
                            <th width="15%">Số điện thoại</th>
                            <th width="15%">Địa chỉ</th>
                            <th width="30%">Địa chỉ kho</th>
                            <th width="5%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>{{ $item['providers_Name'] }}</td>
                                <td>{{ $item['providers_Phone'] }}</td>
                                <td>{{ $item['providers_Address'] }}</td>
                                <td>{{ $item['providers_StoreAddress'] }}</td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.providers_edit',array('id' => $item['providers_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['providers_id']}},1)" title="Xóa Item"><i class="fa fa-trash"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['providers_id']}}"></span>
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

