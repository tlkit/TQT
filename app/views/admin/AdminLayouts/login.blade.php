<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}favicon.ico">
    <link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/admin/lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{Config::get('config.WEB_ROOT')}}assets/css/AdminLTE.css">

    {{CGlobal::$extraHeaderCSS}}
    {{CGlobal::$extraHeaderJS}}
</head>
<body class="bg-black">
{{$content}}

@if(Config::get('compile.debug'))
@include('debug')
@endif
{{CGlobal::$extraFooterCSS}}
{{CGlobal::$extraFooterJS}}
</body>
</html>