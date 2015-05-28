<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật sách @else Tạo mới sách @endif
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{Config::get('config.WEB_ROOT')}}admin/adminBook"><i class="fa fa-dashboard"></i> Danh mục sách</a></li>
        <li class="active">@if($id > 0)Cập nhật sách @else Tạo mới sách @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@if($id > 0)Cập nhật sách @else Tạo mới sách @endif</h3>
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
            <label for="book_name">Tên sách</label>
            <input type="text" placeholder="Tên sách" id="book_name" name="book_name" class="form-control" value="@if(isset($data['book_name'])){{$data['book_name']}}@endif">
        </div>
        <div class="form-group col-lg-5">
            <label for="book_status">Trạng thái</label>
            <select name="book_status" id="book_status" class="form-control">
                {{$optStatus}}
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
         <button class="btn btn-primary" type="submit">@if($id == 0) Tạo mới @else Cập nhật @endif</button>
         <a href="{{Config::get('config.WEB_ROOT')}}admin/adminBook" class="btn bgColor_f2dede">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>