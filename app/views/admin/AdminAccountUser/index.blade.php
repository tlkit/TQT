<section class="content-header">
    <h1>
        Quản lý tài khoản nhân viên
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Quản lý tài khoản nhân viên</li>
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
          <label for="user_id">Mã user</label>
          <input type="text" class="form-control input-sm" id="user_id" name="user_id" placeholder="ID tài khoản" @if(isset($dataSearch['user_id']) && $dataSearch['user_id'] > 0)value="{{$dataSearch['user_id']}}"@endif>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_employee_id">Mã nhân sự</label>
          <input type="text" class="form-control input-sm" id="user_employee_id" name="user_employee_id" placeholder="Mã nhân sự" @if(isset($dataSearch['user_employee_id']) && $dataSearch['user_employee_id'] > 0)value="{{$dataSearch['user_employee_id']}}"@endif>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_status">Trạng thái</label>
          <select name="user_status" id="user_status" class="form-control input-sm">
              @foreach($arrStatus as $k => $v)
              <option value="{{$k}}" @if($dataSearch['user_status'] == $k) selected="selected" @endif>{{$v}}</option>
              @endforeach
          </select>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_group">Nhóm người dùng</label>
          <select name="user_group" id="user_group" class="form-control input-sm chosen-select-deselect" tabindex="12" data-placeholder="Chọn nhóm quyền">
              <option value=""></option>
              @foreach($arrGroupUser as $k => $v)
              <option value="{{$v['group_user_id']}}" @if($dataSearch['user_group'] == $v['group_user_id']) selected="selected" @endif>{{$v['group_user_name']}}</option>
              @endforeach
          </select>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_name">Tên đăng nhập</label>
          <input type="text" class="form-control input-sm" id="user_name" name="user_name" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_full_name">Tên nhân viên</label>
          <input type="text" class="form-control input-sm" id="user_full_name" name="user_full_name" placeholder="Tên nhân viên" @if(isset($dataSearch['user_full_name']))value="{{$dataSearch['user_full_name']}}"@endif>
      </div>
      <div class="form-group col-lg-3">
          <label for="user_email">Email</label>
          <input type="text" class="form-control input-sm" id="user_email" name="user_email" placeholder="Email nhân viên" @if(isset($dataSearch['user_email']))value="{{$dataSearch['user_email']}}"@endif>
      </div>
      <div class="clear"></div>
      <div class="box-footer">
        <div class="text-right">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            @if($is_root)
            <a href="{{URL::route('admin.createUser')}}" class="btn bgColor">Tạo tài khoản</a>
            @endif
        </div>
      </div>
      <div class="clear"></div>
  </div>
  {{ Form::close() }}
</div>
@if($data)
<div class="span"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
<table class="table-hover table table-bordered ">
        <thead>
            <tr class="primary">
                <th width="15%" class="text-center">Id</th>
                <th width="40%" >Thông tin</th>
                <th width="15%" class="text-center">Ngày tạo</th>
                <th width="30%" class="text-center">Thao tác</th>
                {{--<th width="20%">Email</th>--}}
                {{--<th width="10%">Change Pass</th>--}}
                {{--<th width="10%">Change Role</th>--}}
                {{--<th width="10%">Action</th>--}}
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr @if($item['user_status'] == -1) class="warning" @endif>
                <td class="text-center">{{ $item['user_id'] }}</td>
                <td>
                    <div class="green"><b>Tài khoản : </b>{{ $item['user_name'] }}</div>
                    <div><b>Tên nhân viên : </b>{{ $item['user_full_name'] }}</div>
                    <div><b>Mã nhân sự : </b>{{ $item['user_employee_id'] }}</div>
                    <div><b>Email : </b>{{ $item['user_email'] }}</div>
                </td>
                <td class="text-center">
                    @if($item['user_created'])
                    {{ date("d-m-Y",$item['user_created']) }}
                    @endif
                </td>
                <td class="text-center">
                    @if($is_root)
                    <a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$item['user_id'])))}}" title="Sửa mật khẩu">Đổi mật khẩu</a>
                    @endif
                    <br/>
                    @if($is_root)
                    <a href="{{URL::route('admin.getEditUser',array('id' => $item['user_id']))}}" title="Sửa thông tin tài khoản">Sửa</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$paging}}
@else
<h4> Không có dữ liệu</h4>
@endif
</section>