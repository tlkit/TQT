<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách sản phẩm chiết khấu cho khách hàng: <b>{{$inforCust['customers_FirstName']}}</b></li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">

        <div class="row">
            <div class="col-xs-12">
                @if(sizeof($data) > 0)
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="65%">Tên sản phẩm</th>
                            <th width="10%">Giá bán</th>
                            <th width="10%">Giá chiết khấu</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{$key+1 }}</td>
                                <td>{{ $item['product_Name'] }}</td>
                                <td>
                                    <input type="text" class="form-control input-sm" id="product_Price" name="product_Price" value="{{$item['product_Price']}} đ" readonly>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control input-sm" id="product_price_discount_id_{{$item['product_id']}}" name="product_price_discount" value="{{$item['product_price_discount']}}">
                                </td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="javascript:void(0);" onclick="Admin.updateProductCustomer({{$item['customer_id']}},{{$item['product_id']}})"
                                           title="Sửa item"><i class="fa fa-floppy-o fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['product_id']}}"></span>
                                </td>
                            </tr>
                            <script>
                                $("#product_price_discount_id_{{$item['product_id']}}").on('keyup', function (event) {
                                        Import.fomatNumber('product_price_discount_id_{{$item['product_id']}}');
                                    });
                            </script>
                        @endforeach
                        </tbody>
                    </table>
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
{{HTML::script('assets/admin/js/import.js');}}