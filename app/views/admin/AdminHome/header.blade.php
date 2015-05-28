<a href="{{URL::route('admin.dashboard')}}" class="logo">
    Admin Seo Zamba
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<div class="navbar-right">
<ul class="nav navbar-nav">
<li class="dropdown user user-menu" style="display: none">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>{{$user['user_full_name']}} <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header bg-light-blue">
            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
            <p>
                {{$user['user_full_name']}}
                <small>VCC SEOer Pro</small>
            </p>
        </li>
        <li class="user-footer">
<!--            <div class="pull-left">-->
<!--                <a href="#" class="btn btn-default btn-flat">Profile</a>-->
<!--            </div>-->
            <div class="pull-left">
                <a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$user['user_id'])))}}" class="btn btn-default btn-flat">Đổi mật khẩu</a>
            </div>
            <div class="pull-right">
                <a href="{{URL::route('admin.logout')}}" class="btn btn-default btn-flat">Đăng xuất</a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>