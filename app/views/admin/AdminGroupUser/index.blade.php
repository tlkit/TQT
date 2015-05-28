<section class="content-header">
    <h1>
        Danh sách nhóm người dùng
        {{--<small>Control panel</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Danh sách nhóm người dùng</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Lọc dữ liệu</h3>
        </div>
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="group_user_name">Tên nhóm</label>
                <input type="text" class="form-control input-sm" id="group_user_name" name="group_user_name" placeholder="Nhóm người dùng" @if(isset($dataSearch['group_user_name']) && $dataSearch['group_user_name'] != '')value="{{$dataSearch['group_user_name']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="group_user_status">Trạng thái</label>
                <select name="group_user_status" id="group_user_status" class="form-control input-sm">
                    @foreach($arrStatus as $k => $v)
                    <option value="{{$k}}" @if($dataSearch['group_user_status'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="clear"></div>
            <div class="box-footer">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    @if($is_root)
                    <a href="{{URL::route('admin.getCreteGroupUser')}}" class="btn bgColor">Tạo nhóm</a>
                    @endif
                </div>
            </div>
            <div class="clear"></div>
        </div>
  {{ Form::close() }}
</div>
@if($data)
<div class="span"> @if($total >0) Có tổng số <b>{{$total}}</b> nhóm  @endif </div>
@if(isset($paging)){{$paging}}@endif
<table class="table-hover table table-bordered ">
    <thead>
        <tr class="primary">
            <th width="10%" class="text-center">ID</th>
            <th width="20%" class="">Tên nhóm</th>
            <th width="50%">Danh sách quyền</th>
            <th width="10%" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr @if($item['group_user_status'] == -1) class="warning" @endif>
            <td class="text-center">{{ $item['group_user_id'] }}</td>
            <td>
                {{ $item['group_user_name'] }}
            </td>
            <td>
            @if(!empty($item['permissions']))
            @foreach($item['permissions'] as $permission)
                <div class="checkbox disabled">
                    <label title="{{$permission->permission_name}}">
                        <input type="checkbox" value="" disabled checked="checked">
                        {{$permission->permission_code}}
                    </label>
                </div>
            @endforeach
            @endif
            </td>
            <td class="text-center">
                @if($is_root)
                <a href="{{URL::route('admin.geteditGroupUser',array('id' => $item['group_user_id']))}}" title="Sửa nhóm">Sửa nhóm</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@if(isset($paging)){{$paging}}@endif
@else
    <div class="alert alert-danger" role="alert">Không có dữ liệu</div>
@endif
</section>