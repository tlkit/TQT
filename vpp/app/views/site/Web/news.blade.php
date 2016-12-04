<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="">Tin tức</a>
            </div>
        </div>
        <div class="cr make-left">
            @if($news)
            @foreach($news as $new)
            <div class="box-right box-news-list mb-30">
                <div class="wrap-img clearfix">
                    <img src="{{Croppa::url(Constant::dir_news.$new['news_image'], 830)}}" alt="">
                </div>
                <div class="news-item-title mt-10">{{$new['news_title']}}</div>
                <div class="news-item-info mt-10">
                    <span><i class="icons iUser"></i> {{$new['news_created_name']}}</span>
                    {{--<span><i class="icons iCm"></i> 0 Bình luận</span>--}}
                    <span><i class="icons iCa"></i> {{date('d/m/Y',$new['news_created_time'])}}</span>
                </div>
                <div class="news-item-des">{{$new['news_short_content']}}</div>
            </div>
            @endforeach
            <div class="make-right">
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
            <div class="box-left clearfix mt-30">
                <div class="box-left-title">
                    Từ khóa nổi bật
                </div>
                <div class="news-history clearfix">
                    <div class="news-history-label clearfix">
                        <span class="active">Tuần này</span>|<span>Tuần trước</span>
                    </div>
                    <div class="news-history-content clearfix">
                        <div class="wrap-img">
                            <a href=""><img src="{{asset('assets/site/image/tt-1.png', false)}}" alt=""></a>
                        </div>
                        <div class="news-history-title"><a href="">Simple Blog Post</a></div>
                        <div class="news-history-info">
                            <span><i class="icons iSCm"></i> 0 Bình luận</span>
                            <span><i class="icons iSCa"></i> 25/11/2016</span>
                        </div>
                        <div class="news-history-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                    <div class="news-history-content clearfix">
                        <div class="wrap-img">
                            <a href=""><img src="{{asset('assets/site/image/tt-1.png', false)}}" alt=""></a>
                        </div>
                        <div class="news-history-title"><a href="">Simple Blog Post</a></div>
                        <div class="news-history-info">
                            <span><i class="icons iSCm"></i> 0 Bình luận</span>
                            <span><i class="icons iSCa"></i> 25/11/2016</span>
                        </div>
                        <div class="news-history-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#banner").slick({
            prevArrow : '<div class="banner-home-prev"><i class="icons icon-banner-home-prev"></i></div>',
            nextArrow : '<div class="banner-home-next"><i class="icons icon-banner-home-next"></i></div>'
        });
        $(".slide-deal-km").slick({
            prevArrow : '<div class="deal-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="deal-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-cate").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            variableWidth:true,
            prevArrow : '<div class="cate-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="cate-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-hot").slick({
            rows: 2,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-hott").slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
            nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
        });
        $(".slide-brand").slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow : '<div class="brand-prev"><i class="icons iPrev2"></i></div>',
            nextArrow : '<div class="brand-next"><i class="icons iNext2"></i></div>'
        });
    })
</script>