<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li><a href="{{URL::route('admin.categories_list')}}"><i class="fa fa-dashboard"></i> Danh sách danh mục</a></li>
        <li class="active">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
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
            <label for="book_name">Tên sách</label>
            <input type="text" placeholder="Tên danh mục" id="categories_Name" name="categories_Name" class="form-control" value="@if(isset($data['categories_Name'])){{$data['categories_Name']}}@endif">
        </div>
        <div class="form-group col-lg-7">
            <label for="book_status">Trạng thái</label>
            <select name="categories_Status" id="categories_Status" class="form-control input-sm">
                @foreach($arrStatus as $k => $v)
                    <option value="{{$k}}" @if(isset($data['categories_Status']) && $data['categories_Status'] == $k) selected="selected" @endif>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="clear"></div>
    <div class="box-footer txtAlignR">
         <button class="btn btn-primary" type="submit">@if($id == 0) Tạo mới @else Cập nhật @endif</button>
         <a href="{{URL::route('admin.categories_list')}}" class="btn btn-warning">Hủy</a>
    </div>
    {{ Form::close() }}
</div>
</section>