<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh sách nhóm quyền
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Danh sách nhóm quyền</li>
    </ol>
</section>

<section class="content">

    <!-- Default box -->
    <div class="box box-primary">
        {{--<div class="box-header with-border">--}}
        {{--<h3 class="box-title">Title</h3>--}}
        {{--</div>--}}
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="group_user_name"><i>Tên nhóm</i></label>
                <input type="text" class="form-control input-sm" id="group_user_name" name="group_user_name" placeholder="Nhóm người dùng" @if(isset($dataSearch['group_user_name']) && $dataSearch['group_user_name'] != '')value="{{$dataSearch['group_user_name']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="group_user_status"><i>Trạng thái</i></label>
                <select name="group_user_status" id="group_user_status" class="form-control input-sm">
                    @foreach($arrStatus as $k => $v)
                        <option value="{{$k}}" @if($dataSearch['group_user_status'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-right">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
        {{ Form::close() }}
    </div><!-- /.box -->
    @if($permission_create)
    <div class="span pull-right">
        <a class="btn btn-app bg-orange" href="{{URL::route('admin.groupUser_create')}}">
            <i class="fa fa-plus-circle"></i>
            Tạo nhóm
        </a>
    </div>
    @endif
    @if(sizeof($data) > 0)
        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> nhóm quyền @endif </div>
        <br>
        <div class="panel">
            <table class="table-hover table table-bordered ">
                <thead>
                <tr class="btn-primary">
                    <th width="10%" class="text-center">STT</th>
                    <th width="20%" class="">Tên nhóm</th>
                    <th width="50%">Danh sách quyền</th>
                    <th width="10%" class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center">{{ $start + $key+1 }}</td>
                        <td>
                            {{ $item['group_user_name'] }}
                        </td>
                        <td>
                            @if(!empty($item['permissions']))
                                @foreach($item['permissions'] as $permission)
                                    <div class="checkbox disabled">
                                        <label title="{{$permission->permission_name}}">
                                            <input type="checkbox" value="" disabled checked="checked">
                                            {{$permission->permission_name}}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            @if($permission_edit)
                                <a href="{{URL::route('admin.groupUser_edit',array('id' => $item['group_user_id']))}}" title="Sửa nhóm"><i class="fa fa-edit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right">
            {{$paging}}
        </div>
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif

</section><!-- /.content -->