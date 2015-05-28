<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left info text-center col-sm-12">
        <p>Helo, {{$user['user_name']}}</p>
    </div>
    <div class="clear"></div>
    <div class="pull-left image">
        <i class="fa fa-user fa-5x"></i>
    </div>
    <div class="pull-left info profile">
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a><br/>
        <a href="{{URL::route('admin.getEditPass',array('id' => base64_encode('seo_admin_'.$user['user_id'])))}}" title="Đổi mật khẩu">
             <i class="fa fa-unlock"></i> Đổi mật khẩu
        </a>
        <br/>
        <a href="{{URL::route('admin.logout')}}" title="Đăng xuất" >
             <i class="fa fa-sign-out"></i> Đăng xuất
        </a>
    </div>
</div>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="active">
        <a href="{{Config::get('config.WEB_ROOT')}}admin/adminDashboard">
            <i class="fa fa-dashboard"></i> <span>Màn hình chính</span>
        </a>
    </li>

    @if($is_root || in_array('view_account',$aryPermission) || in_array('view_permission',$aryPermission)|| in_array('view_group_user',$aryPermission))
    <li class="treeview @if(Route::currentRouteName() == 'admin.permission' || Route::currentRouteName() == 'admin.groupUser'|| Route::currentRouteName() == 'admin.adminUser_view' || Route::currentRouteName() == 'admin.getEditUser') active @endif">
        <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Phân quyền</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($is_root || in_array('view_account',$aryPermission))
                <li><a href="{{URL::route('admin.adminUser_view')}}" class="@if(Route::currentRouteName() == 'admin.adminUser_view' || Route::currentRouteName() == 'admin.getEditUser') active @endif"><i class="fa fa-angle-double-right"></i> Danh sách tài khoản</a></li>
            @endif
            @if($is_root || in_array('view_permission',$aryPermission))
                <li><a href="{{URL::route('admin.permission')}}" class="@if(Route::currentRouteName() == 'admin.permission') active @endif"><i class="fa fa-angle-double-right"></i> Danh sách quyền</a></li>
            @endif
            @if($is_root || in_array('view_group_user',$aryPermission))
                <li><a href="{{URL::route('admin.groupUser')}}" class="@if(Route::currentRouteName() == 'admin.groupUser') active @endif"><i class="fa fa-angle-double-right"></i> Nhóm quyền</a></li>
            @endif
        </ul>
    </li>
    @endif

    @if($is_root || in_array('website_view',$aryPermission) || in_array('posts_view',$aryPermission))
    <li class="treeview @if(Route::currentRouteName() == 'website.index' || Route::currentRouteName() == 'website.getCreate' || Route::currentRouteName() == 'posts.getCreate' || Route::currentRouteName() == 'posts.index' || Route::currentRouteName() == 'logCronjob.index') active @endif">
        <a href="#">
            <i class="fa fa-cubes"></i>
            <span>Đăng tin</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($is_root || in_array('website_view',$aryPermission))
                <li><a href="{{URL::route('website.index')}}" class="@if(Route::currentRouteName() == 'website.index' || Route::currentRouteName() == 'website.getCreate') active @endif"><i class="fa fa-angle-double-right"></i> QL website</a></li>
            @endif
            @if($is_root || in_array('posts_view',$aryPermission))
                <li><a href="{{URL::route('posts.index')}}" class="@if(Route::currentRouteName() == 'posts.index' || Route::currentRouteName() == 'posts.getCreate') active @endif"><i class="fa fa-angle-double-right"></i> QL Bài tin</a></li>
            @endif

            @if($is_root)
                <li><a href="{{URL::route('logCronjob.index')}}" class="@if(Route::currentRouteName() == 'logCronjob.index') active @endif"><i class="fa fa-angle-double-right"></i> Log Cronjob</a></li>
            @endif
        </ul>
    </li>
    @endif

    @if($is_root || in_array('category_view',$aryPermission)|| in_array('book_view',$aryPermission))
    <li class="treeview @if(Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'category.getCreate'|| Route::currentRouteName() == 'book.index' || Route::currentRouteName() == 'book.getCreate') active @endif">
        <a href="#">
            <i class="fa fa-sitemap"></i>
            <span>Danh mục</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($is_root || in_array('category_view',$aryPermission))
                <li><a href="{{URL::route('category.index')}}" class="@if(Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'category.getCreate') active @endif"><i class="fa fa-angle-double-right"></i> QL Chuyên mục</a></li>
            @endif
            @if($is_root || in_array('book_view',$aryPermission))
                <li><a href="{{URL::route('book.index')}}" class="@if(Route::currentRouteName() == 'book.index'|| Route::currentRouteName() == 'book.getCreate') active @endif"><i class="fa fa-angle-double-right"></i> QL Sách</a></li>
            @endif
        </ul>
    </li>
    @endif

    @if($is_root || in_array('project_view',$aryPermission) || in_array('seo_campaign_view',$aryPermission))
    <li class="treeview @if(Route::currentRouteName() == 'project.index' || Route::currentRouteName() == 'project.getCreate' || Route::currentRouteName() == 'campaign.view' || Route::currentRouteName() == 'campaign.add') active @endif">
        <a href="#">
            <i class="fa fa-folder-open"></i>
            <span>Quản lý Project</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($is_root || in_array('project_view',$aryPermission))
                <li><a href="{{URL::route('project.index')}}" class="@if(Route::currentRouteName() == 'project.index' || Route::currentRouteName() == 'project.getCreate') active @endif"><i class="fa fa-angle-double-right"></i>Danh sách dự án</a></li>
            @endif
            @if($is_root || in_array('seo_campaign_view',$aryPermission))
                <li><a href="{{URL::route('campaign.view')}}" class="@if(Route::currentRouteName() == 'campaign.view' || Route::currentRouteName() == 'campaign.add') active @endif"><i class="fa fa-angle-double-right"></i>Danh sách campaign</a></li>
            @endif
        </ul>
    </li>
    @endif

</ul>

