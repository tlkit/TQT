<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{--<link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}favicon.ico">--}}

    {{ HTML::style('assets/lib/adminLTE/bootstrap/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/lib/font-awesome/css/font-awesome.min.css'); }}
    {{ HTML::style('assets/lib/adminLTE/dist/css/AdminLTE.min.css'); }}
    {{ HTML::style('assets/lib/adminLTE/plugins/iCheck/square/blue.css'); }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    {{ HTML::script('assets/lib/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js'); }}
    {{--<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>--}}
    <!-- Bootstrap 3.3.2 JS -->
    {{ HTML::script('assets/lib/adminLTE/bootstrap/js/bootstrap.min.js'); }}
    {{--<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>--}}
    <!-- iCheck -->
    {{ HTML::script('assets/lib/adminLTE/plugins/iCheck/icheck.min.js'); }}
    {{--<script src="../../plugins/iCheck/icheck.min.js" type="text/javascript"></script>--}}

    {{--{{CGlobal::$extraHeaderCSS}}--}}
    {{--{{CGlobal::$extraHeaderJS}}--}}
</head>
<body class="login-page">
{{$content}}
{{--{{CGlobal::$extraFooterCSS}}--}}
{{--{{CGlobal::$extraFooterJS}}--}}
</body>
</html>