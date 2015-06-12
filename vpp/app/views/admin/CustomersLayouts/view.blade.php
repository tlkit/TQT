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
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="customers_FirstName"><i>Tên khách hàng</i></label>
                            <input type="text" class="form-control input-sm" id="customers_FirstName"
                                   name="customers_FirstName" placeholder="Tên danh mục"
                                   @if(isset($search['customers_FirstName']) && $search['customers_FirstName'] != '')value="{{$search['customers_FirstName']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="customers_Type"><i>Loại khách</i></label>
                            <select name="customers_Type" id="customers_Type" class="form-control input-sm">
                                @foreach($arrType as $k => $v)
                                    <option value="{{$k}}" @if($search['customers_Type'] == $k)
                                            selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($permission_create == 1)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.customers_edit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        @endif
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span"> @if($total >0) Có tổng số <b>{{$total}}</b> khách hàng @endif </div>
                    <br/>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
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
                                    @if($item['customers_ContactEmail'] != '')
                                        E: {{ $item['customers_ContactEmail'] }} <br/>@endif
                                    @if($item['customers_Phone'] != '')ĐT: {{ $item['customers_Phone'] }}@endif
                                </td>
                                <td>{{ $item['customers_ContactAddress'] }}</td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.customers_edit',array('id' => $item['customers_id']))}}"
                                           title="Sửa item"><i class="fa fa-edit"></i></a> <br/>
                                    @endif
                                    <a href="{{URL::route('admin.discountProduct',array('' => $item['customers_id']))}}" target="_blank"  title="Triết khấu theo sản phẩm"><i class="fa fa-cubes"></i></a>
                                    <a href="{{URL::route('admin.discountCategory',array('' => $item['customers_id']))}}" target="_blank"  title="Triết khấu theo danh mục"><i class="fa fa-building"></i></a>
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

