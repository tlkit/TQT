<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/adminCategory"><i class="fa fa-dashboard"></i> Danh mục Seo</a></li>
        <li class="active">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</h3>
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
        <div class="form-group col-lg-8">
            <label for="website_name">Tên danh mục</label>
            <input type="text" placeholder="Tên danh mục" id="category_name" name="category_name" class="form-control" value="@if(isset($data['category_name'])){{$data['category_name']}}@endif">
        </div>
        <div class="form-group col-lg-5">
            <label for="website_status">Trạng thái</label>
            <select name="category_status" id="category_status" class="form-control">
                {{$optStatus}}
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
         <button class="btn btn-primary" type="submit">@if($id == 0) Tạo mới @else Cập nhật @endif</button>
         <a href="{{Config::get('config.WEB_ROOT')}}admin/adminCategory" class="btn bgColor_f2dede">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>