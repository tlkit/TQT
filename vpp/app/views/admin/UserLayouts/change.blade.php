<section class="content-header">
    <h1>
        Đổi mật khẩu
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        @if((int)$id !== $user['user_id'])
            <li><a href="{{URL::route('admin.user_view')}}"><i class="fa fa-user"></i> Danh sách tài khoản</a></li>
        @endif
        <li class="active">Đổi mật khẩu</li>
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
        <div class="box-header"></div>
        <div class="box-body">
            @if(!$permission_change_pass)
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Mật khẩu hiện tại</i>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="password" class="form-control input-sm" name="old_password"
                               value="@if(isset($data['old_password'])){{$data['old_password']}}@endif">
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Mật khẩu mới</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="password" class="form-control input-sm" name="new_password"
                           value="@if(isset($data['new_password'])){{$data['new_password']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Xác nhận mật khẩu</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="password" class="form-control input-sm" name="confirm_new_password"
                           value="@if(isset($data['confirm_new_password'])){{$data['confirm_new_password']}}@endif">
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button type="submit"  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>Đổi mật khẩu</button>
        </div>
    </div>
    {{ Form::close() }}
</section>