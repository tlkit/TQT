/**
 * Created by PC0353 on 12/1/2016.
 */
$(document).ready(function() {
    $("#banner").slick({
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow : '<div class="banner-home-prev"><i class="icons iPrev3"></i></div>',
        nextArrow : '<div class="banner-home-next"><i class="icons iNext3"></i></div>'
    });
    $(".slide-deal-km").slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        arrows : false,
        /*prevArrow : '<div class="deal-prev"><i class="icons iPrev"></i></div>',
        nextArrow : '<div class="deal-next"><i class="icons iNext"></i></div>'*/
    });
    $(".slide-cate").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        variableWidth:true,
        prevArrow : '<div class="cate-prev"><i class="icons iPrev"></i></div>',
        nextArrow : '<div class="cate-next"><i class="icons iNext"></i></div>'
    });
    $(".slide-hot").slick({
        rows: 2,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow : '<div class="product-prev-1"><i class="icons iPrev3"></i></div>',
        nextArrow : '<div class="product-next-1"><i class="icons iNext3"></i></div>'
    });
    $(".slide-hott").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow : '<div class="product-prev-1"><i class="icons iPrev3"></i></div>',
        nextArrow : '<div class="product-next-1"><i class="icons iNext3"></i></div>'
    });
    $(".slide-brand").slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        prevArrow : '<div class="brand-prev"><i class="icons iPrev2"></i></div>',
        nextArrow : '<div class="brand-next"><i class="icons iNext2"></i></div>'
    });
    $(".slide-deal-km").find(".sys_countdown").each(function () {
        var arrDateData = $(this).attr("data-times").split(",");
        var destDay = new Date(arrDateData[0], arrDateData[1] - 1, arrDateData[2], arrDateData[3], arrDateData[4], arrDateData[5]);
        $(this).countdown({
            until:destDay,
            //layout:'{dn} <span>{dl}</span> {hnn}{sep}{mnn}{sep}{snn}s'
        });
    });
    $(".sys_group_new").on('click dbclick',function(){
        $(".sys_group_new").removeClass('active');
        $(this).addClass('active');
        var id = $(this).data('id');
        $.ajax({
            url: '/home/getProductNew',
            data: {
                id: id,
                type:1
            },
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (res) {
                if (res.success == 1) {
                    $(".box-product-new").html(res.html);
                }
            }
        });
    })
    $(".sys_xemthem").on('click',function(){
        $(this).hide();
        $(".sys_thunho").show();
        $(".sys_dx_deal").css('height','auto');
    })
    $(".sys_thunho").on('click',function(){
        $(this).hide();
        $(".sys_xemthem").show();
        $(".sys_dx_deal").css('height','310px');
    })

});
