<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh mục sản phẩm triết khấu cho khách hàng: <b>{{$inforCust['customers_FirstName']}}</b></li>
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
                            <th width="60%">Danh mục</th>
                            <th width="30%">Giá triết khấu</th>
                            <th width="5%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{$key+1 }}</td>
                                <td>
                                    {{ $item['category_name'] }}
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control input-sm" id="category_price_discount_id_{{$item['category_id']}}" name="category_price_discount" value="{{$item['category_price_discount']}}">
                                </td>
                                <td class="text-center">
                                    @if($permission_edit ==1)
                                        <a href="javascript:void(0);" onclick="Admin.updateCategoryCustomer({{$item['customer_id']}},{{$item['category_id']}})"
                                           title="Sửa item"><i class="fa fa-floppy-o fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['category_id']}}"></span>
                                </td>
                            </tr>

                            <script>
                                $("#category_price_discount_id_{{$item['category_id']}}").on('keyup', function (event) {
                                        Import.fomatNumber('category_price_discount_id_{{$item['category_id']}}');
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