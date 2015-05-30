<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@if(isset($title)) {{$title}} @else Quản trị văn phòng phẩm @endif</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href='http://fonts.googleapis.com/css?family=Calligraffitti|Lobster' rel='stylesheet' type='text/css'>
    <!-- Bootstrap 3.3.4 -->
    {{ HTML::style('assets/lib/adminLTE/bootstrap/css/bootstrap.min.css'); }}
    {{--<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />--}}
    <!-- Font Awesome Icons -->
    {{ HTML::style('assets/lib/font-awesome/css/font-awesome.min.css'); }}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<!-- Ionicons -->--}}
    {{--<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />--}}
    <!-- Theme style -->
    {{ HTML::style('assets/lib/adminLTE/dist/css/AdminLTE.min.css'); }}
    {{--<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />--}}
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    {{--<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />--}}
    {{ HTML::style('assets/lib/adminLTE/dist/css/skins/_all-skins.min.css'); }}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
</head>
<body class="skin-purple-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">VPP</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Admin VPP</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown active">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Xin chào, tech_tuanna <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="http://report-dev.todo.vn/password.html">
                                    <i class="glyphicon glyphicon-cog"></i>
                                    Đổi mật khẩu
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="http://report-dev.todo.vn/logout.html">
                                    <i class="glyphicon glyphicon-log-out"></i>
                                    Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            {{--<div class="user-panel">--}}
                {{--<div class="pull-left image">--}}
                    {{--<img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />--}}
                {{--</div>--}}
                {{--<div class="pull-left info">--}}
                    {{--<p>Alexander Pierce</p>--}}

                    {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../index.html"><i class="fa fa-angle-double-right"></i> Dashboard v1</a></li>
                        <li><a href="../../index2.html"><i class="fa fa-angle-double-right"></i> Dashboard v2</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../index.html"><i class="fa fa-angle-double-right"></i> Dashboard v1</a></li>
                        <li><a href="../../index2.html"><i class="fa fa-angle-double-right"></i> Dashboard v2</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../index.html"><i class="fa fa-angle-double-right"></i> Dashboard v1</a></li>
                        <li><a href="../../index2.html"><i class="fa fa-angle-double-right"></i> Dashboard v2</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{$content}}
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
    </footer>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
{{ HTML::script('assets/lib/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js'); }}
{{--<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>--}}
<!-- Bootstrap 3.3.2 JS -->
{{ HTML::script('assets/lib/adminLTE/bootstrap/js/bootstrap.min.js'); }}
{{--<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>--}}
<!-- SlimScroll -->
{{--{{ HTML::script('assets/lib/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js'); }}--}}
{{--<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>--}}
<!-- FastClick -->
{{--{{ HTML::script('assets/lib/adminLTE/plugins/fastclick/fastclick.min.js'); }}--}}
{{--<script src='../../plugins/fastclick/fastclick.min.js'></script>--}}
<!-- AdminLTE App -->
{{ HTML::script('assets/lib/adminLTE/dist/js/app.min.js'); }}
{{--<script src="../../dist/js/app.min.js" type="text/javascript"></script>--}}

<!-- Demo -->
{{--{{ HTML::script('assets/lib/adminLTE/dist/js/demo.js'); }}--}}
{{--<script src="../../dist/js/demo.js" type="text/javascript"></script>--}}
</body>
</html>