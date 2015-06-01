<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh sách nhân viên
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Danh sách tài khoản</li>
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
                        <option value="{{$k}}" @if($dataSearch['user_group'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="text-right">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div><!-- /.box-footer-->
        {{ Form::close() }}
    </div><!-- /.box -->
    @if($permission_create)
    <div class="span pull-right">
        <a class="btn btn-app bg-orange" href="{{URL::route('admin.user_create')}}">
            <i class="fa fa-plus-circle"></i>
            Tạo tài khoản
        </a>
    </div>
    @endif
    @if(sizeof($data) > 0)
        <div class="span clearfix"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
        <br>
        <div class="panel">
            <table class="table-hover table table-bordered">
                <thead>
                <tr class="btn-primary">
                    <th width="15%" class="text-center">STT</th>
                    <th width="40%" >Thông tin</th>
                    <th width="15%" class="text-center">Ngày tạo</th>
                    <th width="20%" class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center">{{ $start+$key+1 }}</td>
                        <td>
                            <div class="green"><b>Tài khoản : </b>{{ $item['user_name'] }}</div>
                            <div><b>Tên nhân viên : </b>{{ $item['user_full_name'] }}</div>
                            <div><b>Số điện thoại : </b>{{ $item['user_phone'] }}</div>
                            <div><b>Email : </b>{{ $item['user_email'] }}</div>
                        </td>
                        <td class="text-center">
                            @if($item['user_created'])
                                {{ date("d-m-Y",$item['user_created']) }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($permission_change_pass)
                            <a href="{{URL::route('admin.user_change',array('id' => base64_encode($item['user_id'])))}}" title="Đổi mật khẩu" class="" style="margin-right: 10px"><i class="fa fa-lock fa-2x"></i></a>
                            @endif
                            {{--<br/>--}}
                            @if($permission_edit)
                            <a href="{{URL::route('admin.user_edit',array('id' => $item['user_id']))}}" title="Sửa thông tin tài khoản"><i class="fa fa-edit fa-2x"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$paging}}
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif

</section><!-- /.content -->