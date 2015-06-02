<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh mục sản phẩm
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Danh mục sản phẩm</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="categories_Name">Tên danh mục</label>
                <input type="text" class="form-control input-sm" id="categories_Name" name="categories_Name" placeholder="Tên danh mục" @if(isset($search['categories_Name']) && $search['categories_Name'] != '')value="{{$search['categories_Name']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="categories_Status">Trạng thái</label>
                <select name="categories_Status" id="categories_Status" class="form-control input-sm">
                    @foreach($arrStatus as $k => $v)
                        <option value="{{$k}}" @if($search['categories_Status'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-right">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
        {{ Form::close() }}
    </div><!-- /.box -->
    <div class="span pull-right">
        <a class="btn btn-app bg-orange" href="{{URL::route('admin.categories_edit')}}">
            <i class="fa fa-plus-circle"></i>
            Tạo danh mục
        </a>
    </div>
    @if(sizeof($data) > 0)
        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> danh mục @endif </div>
        <br>
        <div class="panel">
            <table class="table table-bordered table-hover dataTable">
                <thead>
                <tr class="btn-primary">
                    <th width="10%" class="text-center">STT</th>
                    <th width="70%">Danh mục</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%" class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center">{{ $stt + $key+1 }}</td>
                        <td>
                            {{ $item['categories_Name'] }}
                        </td>
                        <td class="text-center">
                            @if($item['categories_Status'] == 1)
                                <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check"></i></a>
                            @else
                                <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($permission_edit ==1)
                                <a href="{{URL::route('admin.categories_edit',array('id' => $item['categories_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right">
            {{$paging}}
        </div>
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif

</section><!-- /.content -->