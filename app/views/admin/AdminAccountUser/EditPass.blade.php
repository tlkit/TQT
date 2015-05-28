<section class="content-header">
    <h1>
        Đổi mật khẩu
        {{--<small>Control panel</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
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
        <div class="box-body">
            <table width="50%">
                @if(!$is_root && $id == $user['user_id'])
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Mật khẩu hiện tại</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="password" class="form-control input-sm" name="old_password"
                                   value="@if(isset($data['old_password'])){{$data['old_password']}}@endif">
                        </div>
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Mật khẩu mới</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="password" class="form-control input-sm" name="new_password"
                                   value="@if(isset($data['new_password'])){{$data['new_password']}}@endif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Xác nhận mật khẩu</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="password" class="form-control input-sm" name="confirm_new_password"
                                   value="@if(isset($data['confirm_new_password'])){{$data['confirm_new_password']}}@endif">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button type="submit"  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>Đổi mật khẩu</button>
        </div>
    </div>
    {{ Form::close() }}
</section>
