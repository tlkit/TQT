<section class="content-header">
    <h1>
        Tạo tài khoản nhân viên
        {{--<small>Control box</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Tạo tài khoản nhân viên</li>
    </ol>
</section>
<section class="content">
{{ Form::open(array('class'=>'form-horizontal','files' => true,'method' => 'POST')) }}
    @if(isset($error))
    <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endif
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Thông tin cá nhân</h3>
        </div>
        <div class="box-body">
            <table width="50%">
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Tên đăng nhập</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="user_name"
                                   value="@if(isset($data['user_name'])){{$data['user_name']}}@endif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Tên nhân viên</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="user_full_name"
                                   value="@if(isset($data['user_full_name'])){{$data['user_full_name']}}@endif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Mã nhân sự</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="user_employee_id"
                                   value="@if(isset($data['user_employee_id'])){{$data['user_employee_id']}}@endif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Email</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="user_email"
                                   value="@if(isset($data['user_email'])){{$data['user_email']}}@endif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Permission</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            <select class="form-control input-sm" name="user_is_admin" id="user_is_admin">
                                <option value="0" selected>Biên tập viên</option>
                                <option value="1">Quản trị viên</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<div class="box box-info" id="sys_permission">
    <div class="box-header">
        <h3 class="box-title">Phân quyền</h3>
    </div>
  <div class="box-body clearfix">
       @foreach($arrGroupUser as $key => $val)
            <div class="form-group col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="user_group[]" id="user_group_{{$val['group_user_id']}}" value="{{$val['group_user_id']}}" @if(isset($data['user_group']) && in_array($val['group_user_id'],$data['user_group'])) checked="checked" @endif> {{$val['group_user_name']}}
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#user_is_admin").on('change',function(){
            if($(this).val() == 1){
                $("#sys_permission").addClass('hidden');
            }else{
                $("#sys_permission").removeClass('hidden');
            }
        });
    });
</script>