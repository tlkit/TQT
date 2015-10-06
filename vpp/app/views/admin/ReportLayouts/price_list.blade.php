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
            <li class="active">Xu?t kho</li>
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
                                    L?p phi?u xu?t kho
                                </h3>
                                <div class="widget-toolbar no-border invoice-info">
                                    <br/>
                                    <span class="invoice-info-label">Ng�y:</span>
                                    <span class="blue">{{date('d/m/Y',time())}}</span>
                                </div>
                            </div>
                            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal', 'route' => 'admin.export'))}}
                            <div class="widget-body">
                                <div class="widget-main">

                                    @if(isset($error) && $error != '')
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endif

                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right" style="text-align: left">
                                            <b>B??c 1 : Ch?n kh�ch h�ng</b>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <b>T�n kh�ch h�ng</b>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="chosen-select form-control" id="customers_id" name="customers_id" data-placeholder="Ch?n kh�ch h�ng">
                                                <option value="0" selected>  </option>
                                                @foreach($customers as $key => $value)
                                                    <option value="{{$key}}" @if($key == $customers_id) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 text-center" id="sys_load" style="padding: 90.5px;display: none;">
                                            <i class="ace-icon fa fa-spinner fa-spin bigger-300"></i>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row" id="sys_customer_info">
                                            @if(isset($customer_info))
                                                {{$customer_info}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right" style="text-align: left">
                                            <b>B??c 2 : Ch?n s?n ph?m</b>
                                        </div>
                                    </div>
                                    <div class="space"></div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label for="product_name"><i>T�n s?n ph?m</i></label>
                                            <input type="text" id="product_name" name="product_name"
                                                   class="form-control txt_input"
                                                   value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="product_Quantity"><i>T?n kho</i></label>
                                            <input type="text" id="product_Quantity" name="product_Quantity"
                                                   class="form-control text-center"
                                                   value="" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="export_product_num"><i>S? l??ng</i></label>
                                            <input type="text" id="export_product_num" name="export_product_num"
                                                   class="form-control text-center txt_input"
                                                   value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="space"></div>
                                            <input type="button" class="btn btn-sm btn-primary" id="sys_add_product" value="Th�m s?n ph?m"/>
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
                                        <button type="submit" class="btn btn-primary">T?o phi?u</button>
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
{{HTML::script('assets/admin/js/export.js');}}