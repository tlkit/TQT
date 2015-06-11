<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Dashboard - Ace Admin</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/font-awesome/4.2.0/css/font-awesome.min.css'); }}

    <!-- page specific plugin styles -->

    {{ HTML::style('assets/css/jquery-ui.min.css'); }}
    <!-- text fonts -->
    {{ HTML::style('assets/fonts/fonts.googleapis.com.css'); }}

    {{ HTML::style('assets/css/chosen.min.css'); }}
    <!-- ace styles -->
    {{ HTML::style('assets/css/ace.min.css'); }}

    <!--[if lte IE 9]>
    {{ HTML::style('assets/css/ace-part2.min.css'); }}
    <![endif]-->

    <!--[if lte IE 9]>
    {{ HTML::style('assets/css/ace-ie.min.css'); }}
    <![endif]-->


    {{--{{ HTML::style('assets/css/datepicker.min.css'); }}--}}
    {{ HTML::style('assets/admin/css/admin_css.css'); }}
    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    {{ HTML::script('assets/js/ace-extra.min.js'); }}

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    {{ HTML::script('assets/js/html5shiv.min.js'); }}
    {{ HTML::script('assets/js/respond.min.js'); }}
    <![endif]-->
    <script type="text/javascript">
            var WEB_ROOT = "{{ URL::to('/')}}";
        </script>
    <!-- basic scripts -->

    <!--[if !IE]> -->
    {{ HTML::script('assets/js/jquery.2.1.1.min.js'); }}

    <!-- <![endif]-->

    <!--[if IE]>
    {{ HTML::script('assets/js/jquery.1.11.1.min.js'); }}
    <![endif]-->

    {{ HTML::script('assets/js/bootstrap.min.js'); }}

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
    <![endif]-->
    {{--{{ HTML::script('assets/js/jquery-ui.custom.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.ui.touch-punch.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.easypiechart.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.sparkline.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.flot.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.flot.pie.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/jquery.flot.resize.min.js'); }}--}}

    <!-- ace scripts -->
    {{ HTML::script('assets/js/ace-elements.min.js'); }}
    {{ HTML::script('assets/js/chosen.jquery.js'); }}
    {{ HTML::script('assets/js/jquery-ui.min.js'); }}
    {{ HTML::script('assets/js/jquery.ui.touch-punch.min.js'); }}
    {{ HTML::script('assets/js/ace.min.js'); }}
    {{ HTML::script('assets/js/ace-elements.min.js'); }}
    {{--{{ HTML::script('assets/js/bootstrap-datepicker.min.js'); }}--}}
    {{--{{ HTML::script('assets/js/bootstrap-timepicker.min.js'); }}--}}
    {{ HTML::script('assets/js/moment.min.js'); }}
    {{ HTML::script('assets/js/bootbox.min.js'); }}

    {{ HTML::script('assets/admin/js/admin.js'); }}
    {{ HTML::script('assets/admin/js/format.js'); }}
</head>

<body class="no-skin">
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ URL::route('admin.dashboard') }}" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    Vpp Admin
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
									<small>Xin chào,</small>
                                    {{$user['user_full_name']}}
								</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{URL::route('admin.user_change',array('id' => base64_encode($user['user_id'])))}}">
                                <i class="ace-icon fa fa-unlock"></i>
                                Đổi mật khẩu
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{URL::route('admin.logout')}}">
                                <i class="ace-icon fa fa-power-off"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>

<div class="main-container" id="main-container">
    <div id="sidebar" class="sidebar sidebar-fixed sidebar-scroll responsive">
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
            <li class="@if(Route::currentRouteName() == 'admin.user_view' || Route::currentRouteName() == 'admin.personnel_list'|| Route::currentRouteName() == 'admin.permission_view'|| Route::currentRouteName() == 'admin.groupUser_view')active @endif">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text"> Quản trị tài khoản</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu  nav-show ">
                    <li class="@if(Route::currentRouteName() == 'admin.user_view')active @endif">
                        <a href="{{URL::route('admin.user_view')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách tài khoản
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="@if(Route::currentRouteName() == 'admin.personnel_list')active @endif">
                        <a href="{{URL::route('admin.personnel_list')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách nhân viên
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="@if(Route::currentRouteName() == 'admin.permission_view')active @endif">
                        <a href="{{URL::route('admin.permission_view')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách quyền
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="@if(Route::currentRouteName() == 'admin.groupUser_view')active @endif">
                        <a href="{{URL::route('admin.groupUser_view')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách nhóm quyền
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="@if(Route::currentRouteName() == 'admin.categories_list' || Route::currentRouteName() == 'admin.product_list')active @endif">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-book"></i>
                    <span class="menu-text"> Quản trị sản phẩm </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="@if(Route::currentRouteName() == 'admin.categories_list')active @endif">
                        <a href="{{URL::route('admin.categories_list')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh mục sản phẩm
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="@if(Route::currentRouteName() == 'admin.product_list')active @endif">
                        <a href="{{URL::route('admin.product_list')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Quản lý sản phẩm
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="@if(Route::currentRouteName() == 'admin.customers_list' || Route::currentRouteName() == 'admin.discountCategory'|| Route::currentRouteName() == 'admin.discountProduct') active @endif">
                <a href="{{URL::route('admin.customers_list')}}">
                    <i class="menu-icon fa fa-group"></i>
                    <span class="menu-text"> Quản trị khách hàng </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="@if(Route::currentRouteName() == 'admin.providers_list') active @endif">
                <a href="{{URL::route('admin.providers_list')}}">
                    <i class="menu-icon fa fa-briefcase"></i>
                    <span class="menu-text"> QL nhà cung cấp </span>
                </a>

                <b class="arrow"></b>
            </li>
            <li class="@if(Route::currentRouteName() == 'admin.import_view' || Route::currentRouteName() == 'admin.import_detail' || Route::currentRouteName() == 'admin.import'|| Route::currentRouteName() == 'admin.import_restore' || Route::currentRouteName() == 'admin.export_view' || Route::currentRouteName() == 'admin.export_detail' || Route::currentRouteName() == 'admin.export'|| Route::currentRouteName() == 'admin.export_restore') active @endif">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-book"></i>
                    <span class="menu-text"> Quản lý xuất nhập </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="@if(Route::currentRouteName() == 'admin.import_view')active @endif">
                        <a href="{{URL::route('admin.import_view')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách nhập kho
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="@if(Route::currentRouteName() == 'admin.export_view')active @endif">
                        <a href="{{URL::route('admin.export_view')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Danh sách xuất kho
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="@if(Route::currentRouteName() == 'admin.import' || Route::currentRouteName() == 'admin.import_restore')active @endif">
                        <a href="{{URL::route('admin.import')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Nhập kho
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="@if(Route::currentRouteName() == 'admin.export' || Route::currentRouteName() == 'admin.export_restore')active @endif">
                        <a href="{{URL::route('admin.export')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Xuất kho
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
    </div>

    <div class="main-content">
        {{$content}}
    </div><!-- /.main-content -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-info">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-300"></i>
    </a>
</div><!-- /.main-container -->

<!-- inline scripts related to this page -->
</body>
</html>
