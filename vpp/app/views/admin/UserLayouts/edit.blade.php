<section class="content-header">
    <h1>
        Sửa thông tin tài khoản
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.user_view')}}"><i class="fa fa-user"></i> Danh sách tài khoản</a></li>
        <li class="active">Sửa tài khoản</li>
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
                    <i>Tên đăng nhập</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_name"
                           value="{{$data['user_name']}}" readonly>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Tên nhân viên</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_full_name"
                           value="{{$data['user_full_name']}}">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Số di động</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_phone"
                           value="{{$data['user_phone']}}">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Email</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="user_email"
                           value="{{$data['user_email']}}">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Trạng thái</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="user_status" id="user_status" class="form-control input-sm">
                        @foreach($arrStatus as $k => $v)
                            @if($k != 0)
                                <option value="{{$k}}" @if($data['user_status'] == $k)
                                        selected="selected" @endif>{{$v}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-info" id="sys_permission">
        <div class="box-header">
            <h3 class="box-title">Nhóm quyền</h3>
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