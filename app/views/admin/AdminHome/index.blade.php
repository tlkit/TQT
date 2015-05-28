<section class="content-header">
    <h1>
        Control panel
    </h1>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">&nbsp;</h3>
    </div>
    <div class="box-body">
        @if($is_root)
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail text-center">
                <a class="quick-btn" href="{{URL::route('admin.adminUser_view')}}">
                    <i class="fa fa-user fa-5x"></i><br/>
                    <span>Quản lý User</span>
                </a>
            </div>
        </div>
        @endif
        @if($is_root || in_array('category_view',$aryPermission))
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail text-center">
                <a class="quick-btn" href="{{URL::route('category.index')}}">
                    <i class="fa fa-sitemap fa-5x"></i><br/>
                    <span>Quản lý chuyên mục</span>
                </a>
            </div>
        </div>
        @endif
        @if($is_root || in_array('book_view',$aryPermission))
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail text-center">
                <a class="quick-btn" href="{{URL::route('book.index')}}">
                    <i class="fa fa-book fa-5x"></i><br/>
                    <span>Quản lý Sách</span>
                </a>
            </div>
        </div>
        @endif
        @if($is_root || in_array('website_view',$aryPermission))
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail text-center">
                <a class="quick-btn" href="{{URL::route('website.index')}}">
                    <i class="fa fa-laptop fa-5x"></i><br/>
                    <span>Quản lý Website</span>
                </a>
            </div>
        </div>
        @endif
        @if($is_root || in_array('posts_view',$aryPermission))
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail text-center">
                <a class="quick-btn" href="{{URL::route('posts.index')}}">
                    <i class="fa fa-newspaper-o fa-5x"></i><br/>
                    <span>Quản lý tin bài</span>
                </a>
            </div>
        </div>
        @endif
    </div>

    <div style="clear:both"></div>
</div>

</section>