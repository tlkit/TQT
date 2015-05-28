<section class="content-header">
    <h1>
        404 Error Page
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Màn hình chính</a></li>
        <li class="active">404 Error</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="{{URL::route('admin.dashboard')}}">return to dashboard</a> or try using the search form.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

</section><!-- /.content -->