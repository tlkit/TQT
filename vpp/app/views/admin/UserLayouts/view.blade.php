<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh sách nhân viên
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Danh sách nhân viên</li>
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
                <label for="user_name">Tên đăng nhập</label>
                <input type="text" class="form-control input-sm" id="user_name" name="user_name" autocomplete="off" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="user_email">Email</label>
                <input type="text" class="form-control input-sm" id="user_email" name="user_email" autocomplete="off" placeholder="Địa chỉ email" @if(isset($dataSearch['user_email']))value="{{$dataSearch['user_email']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="user_phone">Di động</label>
                <input type="text" class="form-control input-sm" id="user_phone" name="user_phone" autocomplete="off" placeholder="Số di động" @if(isset($dataSearch['user_phone']))value="{{$dataSearch['user_phone']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="user_group">Nhóm quyền</label>
                <select name="user_group" id="user_group" class="form-control input-sm" tabindex="12" data-placeholder="Chọn nhóm quyền">
                    <option value="0">--- Chọn nhóm quyền ---</option>
                    @foreach($arrGroupUser as $k => $v)
                        <option value="{{$v['group_user_id']}}" @if($dataSearch['user_group'] == $v['group_user_id']) selected="selected" @endif>{{$v['group_user_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="text-right">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                {{--<a href="{{URL::route('admin.createUser')}}" class="btn bgColor">Tạo tài khoản</a>--}}
            </div>
        </div><!-- /.box-footer-->
        {{ Form::close() }}
    </div><!-- /.box -->
    @if($data)
        <div class="span"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
        <br>
        <table class="table-hover table table-bordered">
            <thead>
            <tr class="primary">
                <th width="15%" class="text-center">STT</th>
                <th width="40%" >Thông tin</th>
                <th width="15%" class="text-center">Ngày tạo</th>
                <th width="20%" class="text-center">Thao tác</th>
                {{--<th width="20%">Email</th>--}}
                {{--<th width="10%">Change Pass</th>--}}
                {{--<th width="10%">Change Role</th>--}}
                {{--<th width="10%">Action</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $key => $item)
                <tr @if($item['user_status'] == -1) class="warning" @endif>
                    <td class="text-center">{{ $key+1 }}</td>
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
                        {{--@if($is_root)--}}
                            {{--<a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$item['user_id'])))}}" title="Sửa mật khẩu">Đổi mật khẩu</a>--}}
                        {{--@endif--}}
                        {{--<br/>--}}
                        {{--@if($is_root)--}}
                            {{--<a href="{{URL::route('admin.getEditUser',array('id' => $item['user_id']))}}" title="Sửa thông tin tài khoản">Sửa</a>--}}
                        {{--@endif--}}
                    </td>
                </tr>
            @endforeach
            @foreach ($data as $key => $item)
                <tr @if($item['user_status'] == -1) class="warning" @endif>
                    <td class="text-center">{{ $key+1 }}</td>
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
                        {{--@if($is_root)--}}
                        {{--<a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$item['user_id'])))}}" title="Sửa mật khẩu">Đổi mật khẩu</a>--}}
                        {{--@endif--}}
                        {{--<br/>--}}
                        {{--@if($is_root)--}}
                        {{--<a href="{{URL::route('admin.getEditUser',array('id' => $item['user_id']))}}" title="Sửa thông tin tài khoản">Sửa</a>--}}
                        {{--@endif--}}
                    </td>
                </tr>
            @endforeach
            @foreach ($data as $key => $item)
                <tr @if($item['user_status'] == -1) class="warning" @endif>
                    <td class="text-center">{{ $key+1 }}</td>
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
                        {{--@if($is_root)--}}
                        {{--<a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$item['user_id'])))}}" title="Sửa mật khẩu">Đổi mật khẩu</a>--}}
                        {{--@endif--}}
                        {{--<br/>--}}
                        {{--@if($is_root)--}}
                        {{--<a href="{{URL::route('admin.getEditUser',array('id' => $item['user_id']))}}" title="Sửa thông tin tài khoản">Sửa</a>--}}
                        {{--@endif--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$paging}}
    @else
        <h4> Không có dữ liệu</h4>
    @endif

</section><!-- /.content -->