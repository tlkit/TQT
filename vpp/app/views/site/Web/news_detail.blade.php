<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="{{URL::route('site.news')}}">Tin tức</a>
            </div>
        </div>
        <div class="cr make-left">
            <div class="box-right box-news-list">
                <div class="wrap-img clearfix">
                    <img src="{{Croppa::url(Constant::dir_news.$new['news_image'], 830)}}" alt="">
                </div>
                <div class="news-item-title mt-10">{{$new['news_title']}}</div>
                <div class="news-item-info mt-10">
                    <span><i class="icons iUser"></i> {{$new['news_created_name']}}</span>
                    {{--<span><i class="icons iCm"></i> 0 Bình luận</span>--}}
                    <span><i class="icons iCa"></i> {{date('d/m/Y',$new['news_created_time'])}}</span>
                </div>
                <div class="divider"></div>
                <div class="news-item-des">
                    {{htmlspecialchars_decode($new['news_content'])}}
                </div>
            </div>
            @if(sizeof($re) > 0)
            <div class="box-right clearfix mt-30">
                <div class="box-right-title">
                    <div class="make-left">Tin liên quan</div>
                </div>
                <div class="box-news">
                    <div class="slide-news">
                        @foreach($re as $v)
                        <div class="box-news-content make-left">
                            <div class="img-news">
                                <a href="{{URL::route('site.news_detail',array('id' => $v['news_id'],'name'=>FunctionLib::safe_title($v['news_title'])))}}"><img src="{{Croppa::url(Constant::dir_news.$v['news_image'], 393)}}" alt=""></a>
                            </div>
                            <div class="news-title"><a href="{{URL::route('site.news_detail',array('id' => $v['news_id'],'name'=>FunctionLib::safe_title($v['news_title'])))}}">{{$v['news_title']}}</a></div>
                            <div class="news-auth">By {{$v['news_created_name']}} | {{date('d',$v['news_created_time'])}} tháng {{date('m',$v['news_created_time'])}} năm {{date('Y',$v['news_created_time'])}}</div>
                            <div class="news-short-desc">{{$v['news_short_content']}}</div>
                            <div class="news-link">
                                <a href="{{URL::route('site.news_detail',array('id' => $v['news_id'],'name'=>FunctionLib::safe_title($v['news_title'])))}}">Xem thêm <i class="icons iNextz"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="cl make-right">
            @if($tag)
                <div class="box-left clearfix">
                    <div class="box-left-title">
                        Chủ đề nổi bật
                    </div>
                    <div class="box-tag clearfix">
                        @foreach($tag as $k => $v)
                            <div class="tag-content make-left"><a href="javascript:void(0)">{{$v}}</a></div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="mt-30">
                <div class="fb-page" data-href="https://www.facebook.com/vppthieuson" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/vppthieuson" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/vppthieuson">Văn phòng phẩm Thiều Sơn</a></blockquote></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".slide-news").slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
    })
</script>