<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách khách hàng</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{--<div class="page-header">--}}
        {{--<h1>--}}
        {{--<small>--}}
        {{--Danh sách khách hàng--}}
        {{--</small>--}}
        {{--</h1>--}}
        {{--</div><!-- /.page-header -->--}}

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
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
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.categories_edit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> danh mục @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
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
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i
                                                    class="fa fa-close"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.categories_edit',array('id' => $item['categories_id']))}}"
                                           title="Sửa item"><i class="fa fa-edit"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>