<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Chi tiết đơn hàng</li>
        </ul>
        <!-- /.breadcrumb -->
    </div>

    <!-- /.page-header -->
    <div class="page-content">

        <div class="row panel">
            <div class="col-xs-12">
                <div class="row text-center">
                    <b>Chi tiết đơn hàng </b>{{$data->order_id}}
                </div>
                <div class="row text-center position-relative">
                    Ngày tạo đơn hàng : {{date('d/m/Y',$data->order_create_time)}}

                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-sm-12">
                       <b>Tên khách hàng :</b>  {{$data->customers_name}} | <b>Email :</b>  {{$data->customers_email}} | <b>Điện thoại :</b>  {{$data->customers_phone}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <b>Trạng thái đơn hàng :</b>  @if($data->order_status == 1) Mới @elseif($data->order_status == 2 ) Đã xác nhận @elseif($data->order_status == 3 ) Đã tạo bản kê @elseif($data->order_status == 0 ) Đã hủy @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <b>Ghi chú của khách :</b>  {{$data->customer_note}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                       <b> Địa chỉ : </b>{{$data->customers_address}}
                        <a href="javascript:void(0)" onclick="AdminCart.findMap()"> Xem đường đi</a>
                        <input type="hidden" id="sys_end" value="{{$data->customers_address}}">
                        <input type="hidden" id="sys_start" value="Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội">
                    </div>
                </div>
                <div class="row" id="sys_map" style="display: none;">
                    <div class="col-sm-12">
                        <div id="map" style="width: 400px; height:500px;  float: left; margin: 10px;"></div>
                        <div id="panel" style="width: 400px;height:500px; max-height:500px;float: left;overflow-y: scroll;"></div>
                        <a href="javascript:void(0)" onclick="AdminCart.hiddenMap()">Thu gọn</a>
                    </div>
                </div>
                <div class="space-6"></div>
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                    <tr>
                        <td class="center" width="5%">
                            <input type="checkbox" class="ace ace-checkbox-2" id="sys_select_all" />
                            <label class="lbl" for="sys_select_all"></label>
                        </td>
                        <td class="center" width="5%"><b>STT</b></td>
                        <td class="center" width="15%"><b>Mã hàng</b></td>
                        <td class="left" width="35%"><b>Tên hàng hóa</b></td>
                        <td class="center" width="10%"><b>Đơn giá</b></td>
                        <td class="center" width="5%"><b>SL</b></td>
                        <td class="center" width="5%"><b>Tồn</b></td>
                        <td class="center" width="10%"><b>Thành tiền</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sub_total = 0;$discount = 0;?>
                    @foreach($data->orderitem as $key => $value)
                        <tr>
                            <td class="center">
                                <input type="checkbox" class="ace ace-checkbox-1 sys_check" name="export[]" value="{{$value['order_item_id']}}" @if($value['product_num'] > $value['product']['product_Quantity']) disabled @endif/>
                                <label class="lbl"></label>
                            </td>
                            <td class="center">{{$key+1}}</td>
                            <td class="center">{{$value['product_code']}}</td>
                            <td>
                                <div style="margin-left: 5px">{{$value['product_name']}}</div>
                            </td>
                            <td class="text-right">{{number_format($value['product_price'], 0, ',', '.');}}</td>
                            <td class="center">{{$value['product_num']}}</td>
                            <td class="center">{{$value['product']['product_Quantity']}}</td>
                            <td class="center">{{number_format($value['product_price']*$value['product_num'], 0, ',', '.');}}</td>
                            <?php $sub_total += $value['product_price']*$value['product_num'];?>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <b>Cộng tiền hàng</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <b class="red">{{number_format($sub_total, 0, '.', '.');}}</b>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <b>Tổng tiền thanh toán</b>
                        </td>
                        <td colspan="5" class="text-right">
                            <?php $total = $sub_total ;?>
                            <b class="red">{{number_format($total, 0, '.', '.');}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <i>Bằng chữ : {{FunctionLib::numberToWord($total)}}</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="panel-footer text-right">
            @if($data->order_status == 1)
            <span class="">
                <a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="AdminCart.setStatusCart({{$data->order_id}},2);">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Xác nhận đơn hàng
                </a>
            </span>
            @endif
            @if($data->order_status == 2)
                <span class="">
                    <a class="btn btn-success btn-sm sys_btn_export" href="javascript:void(0);" data-id="{{$data->order_id}}">
                        <i class="ace-icon fa fa-plus-circle"></i>
                        Xuất kho
                    </a>
                </span>
            @endif
            @if($data->order_status > 0)
                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="AdminCart.setStatusCart({{$data->order_id}},-1);">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        Hủy đơn hàng
                    </a>
            @endif
        </div>
    </div>

    <!-- /.page-content -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#sys_select_all").on('change',function(){
            if(this.checked){
                $(".sys_check").each(function(){
                    if($(this).prop('disabled') == false){
                        $(this).prop('checked',true);
                    }
                });
            }else{
                $(".sys_check").each(function(){
                    $(this).prop('checked',false);
                });
            }
        });
        $(".sys_btn_export").on('click dbclick',function(){
            var select = [];
            $('.sys_check').each(function () {
                if ($(this).prop('checked')) {
                    select.push(parseInt($(this).val()));
                }
            });
            var ids = select.toString();
            if(!ids){
                bootbox.alert('Chưa chọn sản phẩm xuất kho');
                return false;
            }
            var order_id = $(this).data('id');
            AdminCart.export(ids,order_id)
        })
    });
</script>