@include('admin.AdminGroupUser.script_js_group_user')
<section class="content-header">
    <h1>
        @if(!isset($id))Khởi tạo/Nhóm quyền @else Sửa/Nhóm quyền @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{Config::get('config.WEB_ROOT')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">@if(!isset($id))Khởi tạo/Nhóm quyền @else Sửa/Nhóm quyền @endif</li>
    </ol>
</section>
<section class="content">
<div class="box dark">
    <div id="div-1" class="body">
        <div  class="form-group padding-bottom-3 display-none" id="sys_mess_form">
            <label for="sys_mess" class="control-label col-lg-2"></label>
            <p id="sys_mess" class="col-lg-10" style="color: red;"></p>
        </div>
        <!-- thong bao loi -->
        @if(isset($error))
        <p><span style=" color:red">{{ $error }}</span></p>
        <div class="clearfix"></div>
        @endif
        {{ Form::open(array('class'=>'form-horizontal','id'=>'group-user')) }}
        <div class="form-group">
            <label for="sys_group_user_name" class="control-label col-lg-2 textleft">Tên nhóm quyền</label>
            <div class="col-lg-3">
                <input maxlength="50"  type="text" id="sys_group_user_name" name="sys_group_user_name" placeholder="" class="form-control" @if(isset($data['group_user_name']))value="{{$data['group_user_name']}}"@endif>
            </div>
            <span class="col-lg-1" style="color: red">(*)</span>
        </div>
        <div class="form-group">
            <label for="sys_group_user_status" class="control-label col-lg-2 textleft">Trạng thái</label>
            <div class="col-lg-3">
                <select name="sys_group_user_status" id="sys_group_user_status" class="form-control input-sm">{{$optionStatus}}</select>
            </div>
        </div>
        @if(!empty($arrPermissionByController))
        <div class="form-group">
            <label for="sys_permission" class="control-label col-lg-2 textleft">Chọn quyền</label>
            <div class="col-lg-6">
            @foreach($arrPermissionByController as $key => $val)
                <ul>
                    <li>{{$key}}</li>
                        <ul style="list-style: none">
                            @foreach($val as $k => $v)
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input class="uniform" type="checkbox" value="{{$v['permission_id']}}" name="sys_permission[]" id="sys_permission_{{$v['permission_id']}}" @if(isset($data['strPermission'])) @if(in_array($v['permission_id'],$data['strPermission'])) checked @endif @endif><span @if(isset($data)) @if(in_array($v['permission_id'],$data['strPermission'])) style='color: #ec4844' @endif @endif>{{$v['permission_name']}}({{$v['permission_code']}})</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                </ul>
            @endforeach
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class=" col-lg-11 text-right">
                <a id="submit_group" class="btn btn-primary" href="javascript:groupUser.saveGroup();">Hoàn thành</a>
            </div>
        </div
        {{ Form::close() }}
    </div>
</div>
</section>