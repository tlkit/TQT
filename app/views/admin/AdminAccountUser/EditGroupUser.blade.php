<section class="content-header">
    <h1>
        Sửa thông tin nhân viên <b class="green">{{$data['user_full_name']}}</b>
        {{--<small>Control panel</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Sửa thông tin nhân viên</li>
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
                            <b>ID</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            Plaza_{{$data['user_id']}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Tên đăng nhập</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
                        <div class="form-group">
                            {{$data['user_name']}}
                            <input type="hidden" class="form-control input-sm" name="user_name"
                                   value="{{$data['user_name']}}">
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
                                   value="{{$data['user_full_name']}}">
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
                                   value="{{$data['user_email']}}">
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
                                   value="{{$data['user_employee_id']}}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <b>Trạng thái</b>
                        </div>
                    </td>
                    <td class="col-sm-9">
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
                                <option value="0" @if($data['user_is_admin'] == 0)selected @endif>Biên tập viên</option>
                                <option value="1" @if($data['user_is_admin'] == 1)selected @endif>Quản trị viên</option>
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