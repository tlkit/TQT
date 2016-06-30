<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách đơn hàng</li>
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
                            <label for="customers_name">Tên khách hàng</label>
                            <input type="text" class="form-control input-sm" id="customers_name" name="customers_name" placeholder="Tên khách hàng" @if(isset($search['customers_name']) && $search['customers_name'] != '')value="{{$search['customers_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="customers_phone">Số điện thoại</label>
                            <input type="text" class="form-control input-sm" id="customers_phone" name="customers_phone" placeholder="Số điện thoại" @if(isset($search['customers_phone']) && $search['customers_phone'] != '')value="{{$search['customers_phone']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="customers_email">Email</label>
                            <input type="text" class="form-control input-sm" id="customers_email" name="customers_email" placeholder="Email" @if(isset($search['customers_email']) && $search['customers_email'] != '')value="{{$search['customers_email']}}"@endif>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="order_status">Trạng thái</label>
                            <select name="order_status" id="order_status" class="form-control input-sm">
                                @foreach($arrStatus as $k => $v)
                                    <option value="{{$k}}" @if($search['order_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="panel-footer text-right">

                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> đơn hàng @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="20%">Id Đơn Hàng</th>
                            <th width="30%">Thông tin khách hàng</th>
                            <th width="15%">Tổng tiền</th>
                            <th width="10%">Trạng thái</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>
                                   Id :      {{ $item['order_id'] }}<br/>
                                   Ngày tạo: {{date('d-m-Y H:i',$item['order_create_time'])}}
                                </td>
                                <td>
                                    N:    {{ $item['customers_name'] }}<br/>
                                    P:    {{ $item['customers_phone'] }}<br/>
                                    E:    {{ $item['customers_email'] }}<br/>
                                    Ad:   {{ $item['customers_address'] }}<br/>
                                    Note: {{ $item['customer_note'] }}

                                </td>
                                <td>
                                  Tổng tiền: {{number_format($item['order_price_total'],0,'.','.')}} vnd<br/>
                                  Vat:       {{number_format($item['order_vat'],0,'.','.')}}
                                </td>
                                <td class="text-center">
                                    @if($item['order_status'] == 1)
                                        <a href="javascript:void(0);" title="Mới"><span class="glyphicon glyphicon-asterisk"></span></a>
                                    @elseif($item['order_status'] == 2)
                                        <a href="javascript:void(0);" title="Xác nhận"><span class="glyphicon glyphicon-off"></span></a>
                                    @elseif($item['order_status'] == 3)
                                        <a href="javascript:void(0);" title="Đã tạo bản kê"><span class="glyphicon glyphicon-ok"></span></a>
                                    @elseif($item['order_status'] == 0)
                                        <a href="javascript:void(0);" title="Hủy"><span class="glyphicon glyphicon-remove"></span></a>
                                    @endif
                                </td>
                                <td class="text-center">

                                        <a href="{{URL::route('admin.mngSite_carts_detail',array('id' => $item['order_id']))}}" title="Xem chi tiết">Chi tiết</a>
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