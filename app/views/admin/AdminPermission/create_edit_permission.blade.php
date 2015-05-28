@include('admin.AdminPermission.script_js_permission')
<section class="content-header">
    <h1>
        @if(!isset($id))Khởi tạo/Phân quyền @else Sửa/Phân quyền @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{Config::get('config.WEB_ROOT')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">@if(!isset($id))Khởi tạo/Phân quyền @else Sửa/Phân quyền @endif</li>
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
        {{ Form::open(array('class'=>'form-horizontal','files'=>true,'id'=>'permission')) }}
        <div class="form-group">
            <label for="sys_permission_code" class="control-label col-lg-2 textleft">Mã quyền</label>
            <div class="col-lg-3">
                <input maxlength="50"  type="text" id="sys_permission_code" name="sys_permission_code" placeholder="" class="form-control" @if(isset($data['permission_code']))value="{{$data['permission_code']}}"@endif>
            </div>
            <span class="col-lg-1" style="color: red">(*)</span>
        </div>

        <div class="form-group">
            <label for="sys_permission_name" class="control-label col-lg-2 textleft">Tên quyền</label>
            <div class="col-lg-3">
                <input maxlength="50" type="text" id="sys_permission_name" name="sys_permission_name" placeholder="" class="form-control" @if(isset($data['permission_name']))value="{{$data['permission_name']}}"@endif>
            </div>
            <span class="col-lg-1" style="color: red">(*)</span>
        </div>
        <div class="form-group">
            <label for="sys_permission_group_name" class="control-label col-lg-2 textleft">Tên controller</label>
            <div class="col-lg-3">
                <input maxlength="50" type="text" id="sys_permission_group_name" name="sys_permission_group_name" placeholder="" class="form-control" @if(isset($data['permission_group_name']))value="{{$data['permission_group_name']}}"@endif>
            </div>
        </div>
        <div class="form-group">
            <label for="sys_permission_status" class="control-label col-lg-2 textleft">Trạng thái</label>
            <div class="col-lg-3">
                <select name="sys_permission_status" id="sys_permission_status" class="form-control input-sm">{{$optionStatus}}</select>
            </div>
        </div>
        @if(!empty($arrGroupUser))
        <div class="form-group">
            <label for="sys_group_user" class="control-label col-lg-2 textleft">Chọn nhóm quyền</label>
            <div class="col-lg-6">
                @foreach($arrGroupUser as $key => $val)
                <div class="checkbox">
                    <label>
                        <input class="uniform" type="checkbox" value="{{$key}}" name="sys_group_user[]" id="sys_group_user_{{$key}}" @if(isset($data['strGroupUser'])) @if(in_array($key,$data['strGroupUser'])) checked @endif @endif><span @if(isset($data)) @if(in_array($key,$data['strGroupUser'])) style='color: #ec4844' @endif @endif>{{$val}}</span>
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class=" col-lg-11 text-right">
                <a id="submit_permission" class="btn btn-primary" href="javascript:permission.savePermission();">Hoàn thành</a>
            </div>
        </div
        {{ Form::close() }}
    </div>
</div>
</section>