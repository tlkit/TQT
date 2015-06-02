<section class="content-header">
    <h1>
        @if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{URL::route('admin.categories_list')}}"><i class="fa fa- fa-book"></i> Danh sách danh mục</a></li>
        <li class="active">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</li>
    </ol>
</section>
<section class="content">
    {{Form::open(array('method' => 'POST', 'role'=>'form'))}}
    @if(isset($error))
        <div class="alert alert-danger" role="alert">
            @foreach($error as $itmError)
                <p>{{ $itmError }}</p>
            @endforeach
        </div>
    @endif
    <div class="box box-primary">
        <div class="box-header">
            {{--<h3 class="box-title">Nhập thông tin quyền</h3>--}}
        </div>
        <div class="box-body">
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Tên danh mục</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" placeholder="Tên danh mục" id="categories_Name" name="categories_Name"
                           class="form-control input-sm"
                           value="@if(isset($data['categories_Name'])){{$data['categories_Name']}}@endif">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2">
                <div class="form-group">
                    <i>Trạng thái</i>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="categories_Status" id="categories_Status" class="form-control input-sm">
                        @foreach($arrStatus as $k => $v)
                            <option value="{{$k}}" @if(isset($data['categories_Status']) && $data['categories_Status'] == $k)
                                    selected="selected" @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-right">
            <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
        </div>
    </div>
    {{ Form::close() }}
</section>