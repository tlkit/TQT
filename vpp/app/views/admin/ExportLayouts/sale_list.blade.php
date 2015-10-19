<style type="text/css">
    .ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Tạo bảng kê</li>
        </ul><!-- /.breadcrumb -->
    </div>
    <div class="page-header">
        <h1>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Nhập thông tin bảng kê
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form', 'route' => 'admin.sale_list_create'))}}
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Khách hàng</i>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <select class="chosen-select form-control input-sm" id="customers_id" name="customers_id" data-placeholder="Chọn khách hàng">
                            <option value="0" selected>  </option>
                            @foreach($customers as $key => $value)
                                <option value="{{$key}}" @if($key == $customers_id) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Thanh toán</i>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <select class="form-control input-sm" id="sale_list_type" name="sale_list_type">
                            <option value="0" @if(isset($param['sale_list_type']) && $param['sale_list_type'] == 0) selected @endif>Đã thanh toán</option>
                            <option value="1" @if(isset($param['sale_list_type']) && $param['sale_list_type'] == 1) selected @endif>Công nợ</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Hóa đơn GTGT</i>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="sale_list_code" name="sale_list_code" @if(isset($param['sale_list_code'])) value="{{$param['sale_list_code']}}" @endif>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <i>Ngày xuất kho</i>
                    </div>
                </div>
                <div class="col-sm-5 sys_time">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="export_create_start" name="export_create_start" @if(isset($param['export_create_start'])) value="{{$param['export_create_start']}}" @endif>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <i>Đến</i>
                    </div>
                </div>
                <div class="col-sm-4 sys_time">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="export_create_end" name="export_create_end" @if(isset($param['export_create_end'])) value="{{$param['export_create_end']}}" @endif>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-sm btn-info" id="sys_get_export"><b>Tìm xuất kho</b>  <i class="fa fa-arrow-right"></i> </button>
                </div>
                <div class="clearfix"></div>
                <div class="space-6"></div>
                <div class="row" id="sys_data_export"></div>
                <div class="space-6"></div>
                {{Form::close()}}
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
{{HTML::script('assets/admin/js/sale_list.js');}}
