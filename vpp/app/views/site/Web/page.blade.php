@if($page)
<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">{{$page['page_name']}}</a>
            </div>
        </div>
        <div class="full-width make-left box-right box-like">
            <div class="news-item-title mt-10"><a href="javascript:void(0)">{{$page['page_name']}}</a></div>
            <div class="divider"></div>
            <div class="news-item-des">
                {{htmlspecialchars_decode($page['page_content'])}}
            </div>
        </div>
    </div>
</div>
@endif