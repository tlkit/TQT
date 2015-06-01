<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh sách quyền
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Danh sách quyền</li>
    </ol>
</section>

<section class="content">

    <!-- Default box -->
    <div class="box box-primary">
        {{--<div class="box-header with-border">--}}
        {{--<h3 class="box-title">Title</h3>--}}
        {{--</div>--}}
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="permission_code">Mã quyền</label>
                <input type="text" class="form-control input-sm" id="permission_code" name="permission_code" placeholder="Mã quyền" @if(isset($dataSearch['permission_code']) && $dataSearch['permission_code'] != '')value="{{$dataSearch['permission_code']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="permission_name">Tên quyền</label>
                <input type="text" class="form-control input-sm" id="permission_name" name="permission_name" placeholder="Tên quyền" @if(isset($dataSearch['permission_name']) && $dataSearch['permission_name'] != '')value="{{$dataSearch['permission_name']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="permission_status">Trạng thái</label>
                <select name="permission_status" id="permission_status" class="form-control input-sm" tabindex="12">
                    @foreach($arrStatus as $k => $v)
                        <option value="{{$k}}" @if($dataSearch['permission_status'] == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-right">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                {{--@if($is_root)--}}
                {{--@endif--}}
            </div>
        </div>
        {{ Form::close() }}
    </div><!-- /.box -->
    @if($permission_create)
    <div class="span pull-right">
        <a class="btn btn-app bg-orange" href="{{URL::route('admin.permission_create')}}">
            <i class="fa fa-plus-circle"></i>
            Tạo quyền
        </a>
    </div>
    @endif
    @if(sizeof($data) > 0)
        <div class="span clearfix">
            @if($total >0) Có tổng số <b>{{$total}}</b> quyền  @endif
        </div>
        <br>
        <div class="panel">
            <table class="table-hover table table-bordered">
                <thead>
                <tr class="btn-primary">
                    <th width="10%" class="text-center">STT</th>
                    <th width="20%" class="">Mã quyền</th>
                    <th width="40%" >Tên quyền</th>
                    <th width="20%" >Danh mục</th>
                    <th width="10%" class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr @if($item['permission_status'] == -1) class="warning" @endif>
                        <td class="text-center">{{ $start + $key+1 }}</td>
                        <td>
                            {{ $item['permission_code'] }}
                        </td>
                        <td class="">
                            {{ $item['permission_name'] }}
                        </td>
                        <td>
                            {{ $item['permission_group_name'] }}
                        </td>
                        <td class="text-center">
                            @if($permission_edit)
                                <a href="{{URL::route('admin.permission_edit',array('id' => $item['permission_id']))}}" title="Sửa quyền"><i class="fa fa-edit fa-2x"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$paging}}
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif

</section><!-- /.content -->