<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                Home
            </li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header">
                    <h3 class="box-title" style="text-align: center;">Chào mừng bạn đến hệ thống quản lý nội bộ</h3>
                </div>

                <div class="box-body" style="margin-top: 50px">
                        @if(in_array('user_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.user_view')}}">
                                    <i class="fa fa-user fa-5x"></i><br/>
                                    <span>Quản lý User</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('personnel_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.personnel_list')}}">
                                    <i class="fa fa-smile-o fa-5x"></i><br/>
                                    <span>QL Nhân viên</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('providers_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.providers_list')}}">
                                    <i class="fa fa-users fa-5x"></i><br/>
                                    <span>QL nhà cung cấp</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('customers_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.customers_list')}}">
                                    <i class="fa fa-child fa-5x"></i><br/>
                                    <span>QL khách hàng</span>
                                </a>
                            </div>
                        </div>
                        @endif


                        @if(in_array('product_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.product_list')}}">
                                    <i class="fa fa-book fa-5x"></i><br/>
                                    <span>Quản lý sản phẩm</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('categories_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.categories_list')}}">
                                    <i class="fa fa-sitemap fa-5x"></i><br/>
                                    <span>Danh mục sản phẩm</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('import_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.import_view')}}">
                                    <i class="fa fa-download fa-5x"></i><br/>
                                    <span>Nhập kho</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('export_view',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.export_view')}}">
                                    <i class="fa fa-upload fa-5x"></i><br/>
                                    <span>Xuất kho</span>
                                </a>
                            </div>
                        </div>
                        @endif

                        @if(in_array('report_product_hot',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.report_productHot')}}">
                                    <i class="fa fa-line-chart fa-5x"></i><br/>
                                    <span>Sản phẩm bán chạy</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('report_store',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.report_store')}}">
                                    <i class="fa fa-database fa-5x"></i><br/>
                                    <span>Thống kê tồn kho</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('report_import',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.report_import')}}">
                                    <i class="fa fa-sign-in fa-5x"></i><br/>
                                    <span>Thống kê nhập hàng</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if(in_array('report_export',$aryPermission))
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail text-center">
                                <a class="quick-btn" href="{{URL::route('admin.report_export')}}">
                                    <i class="fa fa-sign-out fa-5x"></i><br/>
                                    <span>Thống kê xuất hàng</span>
                                </a>
                            </div>
                        </div>
                        @endif

                 </div>

                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>