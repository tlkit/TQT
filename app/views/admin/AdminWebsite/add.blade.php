<section class="content-header">
    <h1>
        @if($website_id > 0)Cập nhật website @else Tạo mới website @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/website"><i class="fa fa-dashboard"></i> Danh mục website</a></li>
        <li class="active">@if($website_id > 0)Cập nhật website @else Tạo mới website @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($website_id > 0)Cập nhật website @else Tạo mới website @endif</h3>
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
            <label for="website_name">Tên website</label>
            <input type="text" placeholder="Tên website" id="website_name" name="website_name" class="form-control" value="@if(isset($data['website_name'])){{$data['website_name']}}@endif">
        </div>
        <div class="form-group col-lg-8">
            <label for="website_domain">Domain</label>
            <input type="text" placeholder="Domain" id="website_domain" name="website_domain" class="form-control" value="@if(isset($data['website_domain'])){{$data['website_domain']}}@endif">
        </div>
        <div class="form-group col-lg-8">
            <label for="website_desc">Mô tả</label>
            <textarea class="form-control" rows="4" name="website_desc">@if(isset($data['website_desc'])){{$data['website_desc']}}@endif</textarea>
        </div>
        <div class="form-group col-lg-5">
            <label for="website_status">Trạng thái</label>
            <select name="website_status" id="website_status" class="form-control">
                {{$optStatus}}
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
        <button class="btn btn-primary" type="submit">@if($website_id == 0) Tạo mới @else Cập nhật @endif</button>
        <a href="{{Config::get('config.WEB_ROOT')}}admin/website" class="btn bgColor_f2dede">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>