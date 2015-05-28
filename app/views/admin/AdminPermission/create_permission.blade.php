<section class="content-header">
    <h1>
        Tạo quyền quản trị
        {{--<small>Control panel</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">Tạo quyền quản trị</li>
    </ol>
</section>
<section class="content">
{{ Form::open(array('class'=>'form-horizontal','id'=>'permission','files' => true,'method' => 'POST')) }}
@if(isset($error))
<div class="alert alert-danger" role="alert">
    @foreach($error as $er)
        <p>{{$er}}</p>
    @endforeach
</div>
@endif
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Nhập thông tin quyền</h3>
    </div>
  <div class="box-body">
     <table width="100%">
        <tr>
            <td class="col-sm-2">
                <div class="form-group">
                    <b>Mã quyền</b>
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="permission_code" value="@if(isset($data['permission_code'])){{$data['permission_code']}}@endif">
                </div>
            </td>
            <td class="col-sm-6"></td>
        </tr>
        <tr>
            <td class="col-sm-2">
                <div class="form-group">
                    <b>Mô tả</b>
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="permission_name" value="@if(isset($data['permission_name'])){{$data['permission_name']}}@endif">
                </div>
            </td>
            <td class="col-sm-6"></td>
        </tr>
        <tr>
            <td  class="col-sm-2">
                <div class="form-group">
                    <b>Nhóm quyền</b>
                </div>
            </td>
            <td class="col-sm-4">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="permission_group_name" value="@if(isset($data['permission_group_name'])){{$data['permission_group_name']}}@endif">
                </div>
            </td>
            <td class="col-sm-6"></td>
        </tr>
        <tr>
            <td valign="top" class="col-sm-2">
                <div class="form-group">
                    <b>Nhóm người dùng</b>
                </div>
            </td>
            <td colspan="2" class="col-sm-10">
                @foreach($arrGroupUser as $key => $val)
                    <div class="form-group col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="user_group[]" id="user_group_{{$val['group_user_id']}}" value="{{$val['group_user_id']}}" @if(isset($data['user_group']) && in_array($val['group_user_id'],$data['user_group'])) checked="checked" @endif> {{$val['group_user_name']}}
                            </label>
                        </div>
                    </div>
                @endforeach
            </td>
        </tr>
     </table>
  </div>
</div>
<div class="form-group">
    <div class="col-sm-12 text-right">
        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
    </div>
</div>
{{ Form::close() }}
</section>