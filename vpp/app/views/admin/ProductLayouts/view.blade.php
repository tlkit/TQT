<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách Sản phẩm</li>
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
                            <label for="providers_Name"><i>Tên sản phẩm</i></label>
                            <input type="text" class="form-control input-sm" id="product_Name" name="product_Name"  placeholder="Tên sản phẩm" @if(isset($search['product_Name']) && $search['product_Name'] != '')value="{{$search['product_Name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="providers_Phone"><i>Danh mục sản phẩm</i></label>
                            <select name="product_Category" id="product_Category" class="form-control input-sm">
                                <option value="0">--- Chọn danh mục ---</option>
                                @foreach($arrCategory as $k => $v)
                                    <option value="{{$k}}" @if(isset($search['product_Category']) && $search['product_Category'] == $k)selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.product_edit')}}">
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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> sản phẩm @endif </div>
                    <br>
                    <table class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="40%">Tên sản phẩm</th>
                            <th width="30%">Thuộc danh mục</th>
                            <th width="5%" class="text-center">SL</th>
                            <th width="10%" class="text-right">Giá</th>
                            <th width="10%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>{{ $item['product_Name'] }}</td>
                                <td>@if(isset($arrCategory[$item['product_Category']])) {{$arrCategory[$item['product_Category']]}}@else --- @endif</td>
                                <td class="text-center">{{ $item['product_Quantity'] }}</td>
                                <td class="text-right">{{ $item['product_Price'] }} đ</td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="{{URL::route('admin.providers_edit',array('id' => $item['product_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['product_id']}},2)" title="Xóa Item"><i class="fa fa-trash"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['product_id']}}"></span>
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


