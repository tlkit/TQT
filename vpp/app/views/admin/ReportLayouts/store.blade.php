<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Thống kê tồn kho</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="col-lg-3 col-sm-6 input-group-sm">
                            <label for="product_id">Sản phẩm </label>
                            <select name="product_id" id="product_id" class="form-control input-sm" data-placeholder="Chọn sản phẩm">
                                <option value="0" @if($param['product_id'] == 0) selected="selected" @endif></option>
                                @foreach($product as $k => $v)
                                    <option value="{{$k}}" @if($param['product_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <button class="btn btn-danger btn-sm" name="submit" value="2"><i class="ace-icon fa fa-file-excel-o"></i> Xuất Excel</button>
                            <button class="btn btn-primary btn-sm" name="submit" value="1"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th class="center" width="5%">STT</th>
                            <th class="center" width="10%">Mã SP</th>
                            <th class="center" width="30%">Tên SP</th>
                            <th class="center" width="10%">Xuất xứ</th>
                            <th class="center" width="10%">ĐVT</th>
                            <th class="center" width="5%">SL</th>
                            <th class="center" width="15%">Giá nhập</th>
                            <th class="center" width="15%">Tiền tồn</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="center">{{$key+1}}</td>
                                <td class="center">{{$item['product_Code']}}</td>
                                <td class="text-left">{{$item['product_Name']}}</td>
                                <td class="center">{{$item['product_NameOrigin']}}</td>
                                <td class="center">{{$item['product_NameUnit']}}</td>
                                <td class="center">{{$item['product_Quantity']}}</td>
                                <?php $sub_total = 0;$quantity = $item['product_Quantity'];?>
                                <td class="text-left">
                                    @if($item['store'])
                                        @foreach($item['store'] as $store)
                                            @if($quantity > 0)
                                                @if($quantity >= $store['import_product_num'])
                                                    {{number_format($store['import_product_price'],0,'.','.')}} ({{$store['import_product_num']}})
                                                    <?php
                                                        $quantity = $quantity-$store['import_product_num'];
                                                        $sub_total += ($store['import_product_num'] * $store['import_product_price']);
                                                    ?>
                                                @else
                                                    {{number_format($store['import_product_price'],0,'.','.')}} ({{$quantity}})
                                                    <?php
                                                        $sub_total += ($quantity * $store['import_product_price']);
                                                        $quantity = 0;
                                                    ?>
                                                @endif
                                                <br/>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{number_format($sub_total,0,'.','.')}}
                                </td>
                            </tr>
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
{{HTML::script('assets/admin/js/export.js');}}
<script type="text/javascript">
    $('#product_id').chosen({allow_single_deselect:true,no_results_text:'Từ khóa : ',search_contains: true});
</script>