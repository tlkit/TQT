<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>{{CGlobal::$pageTitle}}</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}favicon.ico">
<link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/css/bootstrap.min.css">
<link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/css/AdminLTE.css">
<link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/css/custom.css">
<link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/datetimepicker_new/datetimepicker.css">
{{CGlobal::$extraHeaderCSS}}
<script type="text/javascript">
    var WEB_ROOT = '{{Config::get('config.WEB_ROOT')}}';
</script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/jquery/jquery.min.js"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/datetimepicker_new/jquery.datetimepicker.js"></script>
{{CGlobal::$extraHeaderJS}}
</head>
<body class="skin-blue">
<header class="header">
@include('admin.AdminHome.header')
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
<aside class="left-side sidebar-offcanvas">
<section class="sidebar">
@include('admin.AdminHome.sidebar')
</section>
</aside>
<aside class="right-side">
{{$content}}
</aside>
</div>
@if(Config::get('compile.debug'))
@include('debug')
@endif
{{CGlobal::$extraFooterCSS}}
{{CGlobal::$extraFooterJS}}
<script src="{{Config::get('config.WEB_ROOT')}}assets/js/common.js"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/screenfull/screenfull.js"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="{{Config::get('config.WEB_ROOT')}}assets/js/AdminLTE/dashboard.js" type="text/javascript"></script>

</body>