<div class="main-content-inner">
    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="#">Home</a>
            </li>

            <li>
                <a href="#">More Pages</a>
            </li>
            <li class="active">Invoice</li>
        </ul><!-- /.breadcrumb -->

        <div class="nav-search" id="nav-search">
            <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
            </form>
        </div><!-- /.nav-search -->
    </div>

    <div class="page-content">
        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="ace-icon fa fa-cog bigger-130"></i>
            </div>

            <div class="ace-settings-box clearfix" id="ace-settings-box">
                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <div class="pull-left">
                            <select id="skin-colorpicker" class="hide">
                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                            </select>
                        </div>
                        <span>&nbsp; Choose Skin</span>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                        <label class="lbl" for="ace-settings-add-container">
                            Inside
                            <b>.container</b>
                        </label>
                    </div>
                </div><!-- /.pull-left -->

                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                    </div>
                </div><!-- /.pull-left -->
            </div><!-- /.ace-settings-box -->
        </div><!-- /.ace-settings-container -->

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
                            {{Form::open(array('method' => 'POST', 'role'=>'form', 'class'=>'form-horizontal'))}}
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right" style="text-align: left">
                                                    <b>Bước 1 : Chọn nhà cung cấp</b>
                                                </div>
                                            </div>

                                            <div class="space"></div>

                                            <div>
                                                <div class="col-sm-2">
                                                    <b>Nhà cung cấp</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <select class="chosen-select form-control" id="providers_id" name="providers_id" data-placeholder="Chọn nhà cung cấp">
                                                        <option value="0">  </option>
                                                        @foreach($providers as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                                <ul class="list-unstyled spaced">
                                                    {{--<li>--}}
                                                        {{--<i class="ace-icon fa fa-caret-right blue"></i>Street, City--}}
                                                    {{--</li>--}}

                                                    {{--<li>--}}
                                                        {{--<i class="ace-icon fa fa-caret-right blue"></i>Zip Code--}}
                                                    {{--</li>--}}

                                                    {{--<li>--}}
                                                        {{--<i class="ace-icon fa fa-caret-right blue"></i>State, Country--}}
                                                    {{--</li>--}}

                                                    {{--<li>--}}
                                                        {{--<i class="ace-icon fa fa-caret-right blue"></i>--}}
                                                        {{--Phone:--}}
                                                        {{--<b class="red">111-111-111</b>--}}
                                                    {{--</li>--}}

                                                    {{--<li class="divider"></li>--}}

                                                    {{--<li>--}}
                                                        {{--<i class="ace-icon fa fa-caret-right blue"></i>--}}
                                                        {{--Paymant Info--}}
                                                    {{--</li>--}}
                                                </ul>
                                            </div>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->

                                    <div class="space"></div>

                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right" style="text-align: left">
                                            <b>Bước 2 : Chọn sản phẩm</b>
                                        </div>
                                    </div>

                                    <div class="space"></div>
                                    <div>
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
                                        <div class="clearfix"></div>
                                        <div class="space"></div>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Product</th>
                                                <th class="hidden-xs">Description</th>
                                                <th class="hidden-480">Discount</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td class="center">1</td>

                                                <td>
                                                    <a href="#">google.com</a>
                                                </td>
                                                <td class="hidden-xs">
                                                    1 year domain registration
                                                </td>
                                                <td class="hidden-480"> --- </td>
                                                <td>$10</td>
                                            </tr>

                                            <tr>
                                                <td class="center">2</td>

                                                <td>
                                                    <a href="#">yahoo.com</a>
                                                </td>
                                                <td class="hidden-xs">
                                                    5 year domain registration
                                                </td>
                                                <td class="hidden-480"> 5% </td>
                                                <td>$45</td>
                                            </tr>

                                            <tr>
                                                <td class="center">3</td>
                                                <td>Hosting</td>
                                                <td class="hidden-xs"> 1 year basic hosting </td>
                                                <td class="hidden-480"> 10% </td>
                                                <td>$90</td>
                                            </tr>

                                            <tr>
                                                <td class="center">4</td>
                                                <td>Design</td>
                                                <td class="hidden-xs"> Theme customization </td>
                                                <td class="hidden-480"> 50% </td>
                                                <td>$250</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="hr hr8 hr-double hr-dotted"></div>

                                    <div class="row">
                                        <div class="col-sm-5 pull-right">
                                            <h4 class="pull-right">
                                                Total amount :
                                                <span class="red">$395</span>
                                            </h4>
                                        </div>
                                        <div class="col-sm-7 pull-left"> Extra Information </div>
                                    </div>

                                    <div class="space-6"></div>
                                    <div class="well">
                                        Thank you for choosing Ace Company products.
                                        We believe you will be satisfied by our services.
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