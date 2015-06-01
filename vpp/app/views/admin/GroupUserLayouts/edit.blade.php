<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sửa nhóm quyền
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.groupUser_view')}}"><i class="fa fa-group"></i> Danh sách nhóm quyền</a></li>
        <li class="active">Sửa nhóm quyền</li>
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
            <h3 class="box-title">Nhập thông tin nhóm</h3>
        </div>
        <div class="box-body">
            <table width="100%">
                <tr>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <b>Mã nhóm</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="group_user_name" value="@if(isset($data['group_user_name'])){{$data['group_user_name']}}@endif">
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
                <tr>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <b>Trạng thái</b>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <div class="form-group">
                            <select name="group_user_status" id="group_user_status" class="form-control input-sm">
                                @foreach($arrStatus as $k => $v)
                                    @if($k != 0)
                                        <option value="{{$k}}" @if($data['group_user_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="col-sm-6"></td>
                </tr>
                <tr>
                    <td valign="top" class="col-sm-2">
                        <div class="form-group">
                            <b>Danh sách quyền</b>
                        </div>
                    </td>
                    <td colspan="2" class="col-sm-10">
                        <?php $i = 1 ?>
                        @foreach($arrPermissionByController as $key => $val)
                            <div class="col-sm-4" @if($i%3 == 1) style="clear: left" @endif>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><b>@if($key || $key != ''){{$key}}@else Khac @endif</b></div>
                                    <div class="panel-body">
                                        @foreach($val as $k => $v)
                                            <div class="checkbox clearfix">
                                                <label title="{{$v['permission_name']}}">
                                                    <input  type="checkbox" value="{{$v['permission_id']}}" name="permission_id[]" @if(isset($data['strPermission'])) @if(in_array($v['permission_id'],$data['strPermission'])) checked @endif @endif>    {{$v['permission_name']}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
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