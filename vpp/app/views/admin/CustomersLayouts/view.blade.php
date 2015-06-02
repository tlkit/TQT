<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Danh sách khách hàng
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Danh sách khách hàng</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
        <div class="box-body">
            <div class="form-group col-lg-3">
                <label for="customers_FirstName"><i>Tên khách hàng</i></label>
                <input type="text" class="form-control input-sm" id="customers_FirstName" name="customers_FirstName" placeholder="Tên danh mục" @if(isset($search['customers_FirstName']) && $search['customers_FirstName'] != '')value="{{$search['customers_FirstName']}}"@endif>
            </div>
            <div class="form-group col-lg-3">
                <label for="customers_Type"><i>Loại khách</i></label>
                <select name="customers_Type" id="customers_Type" class="form-control input-sm">
                    @foreach($arrType as $k => $v)
                        <option value="{{$k}}" @if($search['customers_Type'] == $k) selected="selected" @endif>{{$v}}</option>
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
        <a class="btn btn-app bg-orange" href="{{URL::route('admin.customers_edit')}}">
            <i class="fa fa-plus-circle"></i>
            Thêm khách hàng
        </a>
    </div>
    @if(sizeof($data) > 0)
        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> khách hàng @endif </div>
        <br>
        <div class="panel">
            <table class="table table-bordered table-hover dataTable">
                <thead>
                <tr class="btn-primary">
                    <th width="5%" class="text-center">STT</th>
                    <th width="35%">Tên khách hàng</th>
                    <th width="8%">Loại KH</th>
                    <th width="15%">Email - Số ĐT</th>
                    <th width="30%">Đ/c thực tế</th>
                    <th width="5%" class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td class="text-center">{{ $stt + $key+1 }}</td>
                        <td>{{ $item['customers_FirstName'] }}</td>
                        <td>{{ $item['customers_Type'] }}</td>
                        <td>
                            @if($item['customers_ContactEmail'] != '')E: {{ $item['customers_ContactEmail'] }} <br/>@endif
                            @if($item['customers_Phone'] != '')ĐT: {{ $item['customers_Phone'] }}@endif
                        </td>
                        <td>{{ $item['customers_ContactAddress'] }}</td>
                        <td class="text-center">
                            @if($permission_edit ==1)
                                <a href="{{URL::route('admin.customers_edit',array('id' => $item['customers_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
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

