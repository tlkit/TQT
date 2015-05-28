<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::route('admin.dashboard')}}"><i class="glyphicon glyphicon-dashboard"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if($is_root || in_array('view_account',$aryPermission) || in_array('view_permission',$aryPermission)|| in_array('view_group_user',$aryPermission))
                <li class="dropdown @if(Route::currentRouteName() == 'admin.adminUser_view' || Route::currentRouteName() == 'admin.permission' || Route::currentRouteName() == 'admin.groupUser') active @endif">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Phân quyền <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @if($is_root || in_array('view_account',$aryPermission))
                        <li class="@if(Route::currentRouteName() == 'admin.adminUser_view') active @endif"><a href="{{URL::route('admin.adminUser_view')}}">Danh sách tài khoản</a></li>
                        @endif
                        @if($is_root || in_array('view_permission',$aryPermission))
                        <li class="@if(Route::currentRouteName() == 'admin.permission') active @endif"><a href="{{URL::route('admin.permission')}}">Danh sách quyền</a></li>
                        @endif
                        @if($is_root || in_array('view_group_user',$aryPermission))
                        <li class="@if(Route::currentRouteName() == 'admin.groupUser') active @endif"><a href="{{URL::route('admin.groupUser')}}">Nhóm quyền</a></li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0px">
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user_login['admin_fullname']}} <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu col-sm-12">
                        <li>
                            <a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('plaza_admin_'.$user_login['admin_id'])))}}">
                                <i class="glyphicon glyphicon-cog"></i>
                                Đổi mật khẩu
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{URL::route('admin.logout')}}">
                                <i class="glyphicon glyphicon-log-out"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>
.dropdown-submenu{position:relative;}
.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
.action>a{color: #000!important;}
.dropdown-submenu:hover>a:after{border-left-color:#555;}
.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

</style>
<script>
(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);
</script>

