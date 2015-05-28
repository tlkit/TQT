<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật dự án @else Tạo mới dự án @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/adminProject"><i class="fa fa-dashboard"></i> Quản lý dự án Seo</a></li>
        <li class="active">@if($id > 0)Cập nhật dự án @else Tạo mới dự án @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($id > 0)Cập nhật dự án @else Tạo mới dự án @endif</h3>
    </div>
    {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
    @if(isset($error))
    <div class="alert alert-danger" role="alert">
    @foreach($error as $itmError)
        <p>{{ $itmError }}</p>
    @endforeach
    </div>
    @endif
    <div class="box-body">
        <div class="form-group col-lg-7">
            <label for="seo_project_name">Tên dự án</label>
            <input type="text" placeholder="Tên project" id="seo_project_name" name="seo_project_name" class="form-control" value="@if(isset($data['seo_project_name'])){{$data['seo_project_name']}}@endif">
        </div>
        <div class="form-group col-lg-7">
            <label for="seo_project_position">Vị trí hiển thị</label>
            <input type="text" placeholder="Vị trí hiển thị" id="seo_project_position" name="seo_project_position" class="form-control" value="@if(isset($data['seo_project_position'])){{$data['seo_project_position']}}@endif">
        </div>
        <div class="form-group col-lg-7">
            <label for="seo_project_status">Trạng thái</label>
            <select name="seo_project_status" id="seo_project_status" class="form-control">
                {{$optStatus}}
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
         <button class="btn btn-primary" type="submit">@if($id == 0) Tạo mới @else Cập nhật @endif</button>
         <a href="{{Config::get('config.WEB_ROOT')}}admin/adminProject" class="btn bgColor_f2dede">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>
