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
            <li class="active">Bảng báo giá</li>
        </ul><!-- /.breadcrumb -->
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="space-6"></div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-large">
                                <h3 class="widget-title blue lighter">
                                    <i class="ace-icon fa fa-file-text"></i>
                                    Lập bảng giá
                                </h3>
                                <div class="widget-toolbar no-border invoice-info">
                                    <br/>
                                    <span class="invoice-info-label">Ngày:</span>
                                    <span class="blue">{{date('d/m/Y',time())}}</span>
                                </div>
                            </div>
                            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal'))}}
                            {{--'route' => 'admin.export'--}}
                            <div class="widget-body">
                                <div class="widget-main">
                                    @if(isset($error) && $error != '')
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="customers_id"><i>Tên khách hàng</i></label>
                                            <select class="chosen-select form-control" id="customers_id" name="customers_id" data-placeholder="Chọn khách hàng">
                                                <option value="0" selected>  </option>
                                                @foreach($customers as $key => $value)
                                                    <option value="{{$key}}" @if($key == $customers_id) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="space"></div>
                                        <div class="col-sm-6">
                                            <label for="product_name"><i>Tên sản phẩm</i></label>
                                            <input type="text" id="product_name" name="product_name"
                                                   class="form-control txt_input"
                                                   value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="product_num"><i>Số lượng</i></label>
                                            <input type="text" id="product_num" name="product_num"
                                                   class="form-control text-center txt_input"
                                                   value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="space"></div>
                                            <input type="button" class="btn btn-sm btn-info" id="sys_add_product" value="Thêm sản phẩm"/>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row" id="sys_product_info">
                                        @if(isset($product_info))
                                            {{$product_info}}
                                        @endif
                                    </div>
                                    <div class="space-6"></div>
                                    <div class="row text-center">
                                        <button type="button" class="btn btn-primary" id="btn_export_pdf">Xuất báo giá</button>
                                    </div>
                                </div>
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
{{HTML::script('assets/admin/js/price_list.js');}}