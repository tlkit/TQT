<section class="content-header">
    <h1>
        Tạo tài khoản
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.user_view')}}"><i class="fa fa-user"></i> Danh sách tài khoản</a></li>
        <li class="active">Tạo tài khoản</li>
    </ol>
</section>
<section class="content">
    {{ Form::open(array('class'=>'form-horizontal','files' => true,'method' => 'POST')) }}
    @if(isset($error))
        <div class="alert alert-danger" role="alert">
            @foreach($error as $er)
                <p>{{$er}}</p>
            @endforeach
        </div>
    @endif
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Thông tin cá nhân</h3>
        </div>
        <div class="box-body">
            <div class="col-sm-2">
                <div class="form-group">
                    <b>Tên đăng nhập</b>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_name"
                           value="@if(isset($data['user_name'])){{$data['user_name']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <b>Tên nhân viên</b>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_full_name"
                           value="@if(isset($data['user_full_name'])){{$data['user_full_name']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <b>Số di động</b>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_phone"
                           value="@if(isset($data['user_phone'])){{$data['user_phone']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <b>Địa chỉ email</b>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_email"
                           value="@if(isset($data['user_email'])){{$data['user_email']}}@endif">
                </div>
            </div>
        </div>
    </div>
    <div class="box box-info" id="sys_permission">
        <div class="box-header">
            <h3 class="box-title">Danh sách nhóm quyền</h3>
        </div>
        <div class="box-body clearfix">
            @foreach($arrGroupUser as $key => $val)
                <div class="form-group col-sm-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="user_group[]" id="user_group_{{$key}}" value="{{$key}}" @if(isset($data['user_group']) && in_array($key,$data['user_group'])) checked="checked" @endif> {{$val}}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
        </div>
    </div>
    {{ Form::close() }}
</section>