<div id="page-content">
    <div class="container clearfix">
        <div class="breadcrumb clearfix">
            <a class="make-left" href="{{URL::route('site.home')}}">Trang chủ</a>
            <div class="make-left">
                <i class="icons iRightB"></i><a href="javascript:void(0)">Giới thiệu</a>
            </div>
        </div>
        <div class="cr make-left">
            <div class="box-right box-news-list">
                <div class="wrap-img clearfix">
                    <img src="{{asset('assets/site/image/company.png', false)}}" alt="">
                </div>
                <div class="news-item-title mt-10"><a href="javascript:void(0)">Giới thiệu chung</a></div>
                <div class="news-item-info mt-10">
                    {{--<span><i class="icons iUser"></i> </span>--}}
                    {{--<span><i class="icons iCm"></i> 0 Bình luận</span>--}}
                    <span><i class="icons iCa"></i> 1/12/2016</span>
                </div>
                <div class="divider"></div>
                <div class="news-item-des">
                    <b class="fs-16">Kính gửi Quý khách hàng!</b>
                    <br>
                    <p>Công Ty TNHH Thương mại & Dịch vụ THIỀU SƠN  được thành lập vào ngày 22 tháng 10 năm 2012 với ngành nghề kinh doanh chính là phân phối sỉ, lẻ mặt hàng giấy in, văn phòng phẩm các loại cũng như cung cấp dịch vụ in ấn dành cho văn phòng.</p>
                    <p>Trong bối cảnh thị trường văn phòng phẩm ngày càng nở rộ, phát triển nhanh về mặt số lượng nhưng chất lượng dịch vụ phát triển không đồng đều, Quý khách luôn cảm thấy khó khăn trong việc lựa chọn nhà cung cấp văn phòng phẩm ổn định và lâu dài. Chính vì lý do đó, Thiều Sơn được ra đời nhằm mục đích đáp ứng nhu cầu ngày càng cao của Quý khách trong việc lựa chọn nhà cung cấp văn phòng phẩm uy tín nhất, giá cạnh tranh nhất, chất lượng sản phẩm tốt nhất tại Tp.Hà Nội  và các tỉnh lân cận.</p>
                    <br>
                    <p>Với mong muốn đó, Thiều Sơn cũng tự đặt ra mục tiêu cho mình sớm trở thành một trong những đơn vị cung cấp văn phòng phẩm hàng đầu tại Tp.Hà Nội với đối tượng khách hàng ngày càng đa dạng hơn như : công ty/cửa hàng/đại lý văn phòng phẩm – doanh nghiệp SME – tập đoàn kinh tế lớn – doanh nghiệp có loại hình kinh doanh đặc thù khác nhau (Bệnh viện, trường học, DNNN khác…)</p>
                    <br>
                    <p>Trong quá trình phát triển, Thiều Sơn sẽ luôn ý thức gìn giữ giá trị thương hiệu của mình đã xây dựng, không ngừng hoàn thiện để khách hàng tiếp tục tin tưởng, gắn bó với Thiều Sơn như một người bạn đồng hành đáng tin cậy của mình.</p>
                    <br>
                    <b class="fs-16">Hân hạnh được phục vụ Quý khách hàng!</b>
                </div>
            </div>
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