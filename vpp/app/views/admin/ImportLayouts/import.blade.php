<style type="text/css">
    .ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Nhập kho</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="space-6"></div>

                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-large">
                                <h3 class="widget-title blue lighter">
                                    <i class="ace-icon fa fa-file-text"></i>
                                    Lập phiếu nhập kho
                                </h3>
                                <div class="widget-toolbar no-border invoice-info">
                                    <br/>
                                    <span class="invoice-info-label">Ngày:</span>
                                    <span class="blue">{{date('d/m/Y',time())}}</span>
                                </div>
                            </div>
                            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'admin.import'))}}
                            <div class="widget-body">
                                <div class="widget-main">

                                    @if(isset($error) && $error != '')
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endif

                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right" style="text-align: left">
                                            <b>Bước 1 : Chọn nhà cung cấp</b>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <b>Nhà cung cấp</b>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="chosen-select form-control" id="providers_id" name="providers_id" data-placeholder="Chọn nhà cung cấp">
                                                <option value="0" selected>  </option>
                                                @foreach($providers as $key => $value)
                                                    <option value="{{$key}}" @if($key == $providers_id) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 text-center" id="sys_load" style="padding: 28px;display: none;">
                                            <i class="ace-icon fa fa-spinner fa-spin bigger-300"></i>
                                        </div>
                                        <ul class="list-unstyled spaced" id="sys_provider_info">
                                            @if(isset($provider_info))
                                                {{$provider_info}}
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right" style="text-align: left">
                                            <b>Bước 2 : Chọn sản phẩm</b>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label for="product_name"><i>Tên sản phẩm</i></label>
                                            <input type="text" id="product_name" name="product_name"
                                                   class="form-control"
                                                   value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="import_product_price"><i>Giá nhập</i></label>
                                            <input type="text" id="import_product_price" name="import_product_price"
                                                   class="form-control text-right"
                                                   value="">
                                            <input type="hidden" id="input_import_product_price" name="import_product_price"
                                                   class="form-control text-right"
                                                   value="0">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="import_product_num"><i>Số lượng</i></label>
                                            <input type="text" id="import_product_num" name="import_product_num"
                                                   class="form-control text-center"
                                                   value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="space"></div>
                                            <input type="button" class="btn btn-sm btn-primary" id="sys_add_product" value="Thêm sản phẩm"/>
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
                                        <button type="submit" class="btn btn-primary">Tạo phiếu</button>
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
{{HTML::script('assets/admin/js/import.js');}}