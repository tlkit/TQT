/**
 * Created by PC0353 on 12/2/2016.
 */
$(document).ready(function(){
    $("#limit, #sort").on('change', function () {
        var sort = $("#sort").val();
        var limit = parseInt($("#limit").val());
        var link = window.location.origin + window.location.pathname + '?sort=' + sort + '&limit=' + limit;
        window.location.href = link;
    });
    $(".slide-deal-km").slick({
        prevArrow : '<div class="deal-prev"><i class="icons iPrev"></i></div>',
        nextArrow : '<div class="deal-next"><i class="icons iNext"></i></div>'
    });
    $(".slide-hot").slick({
        //rows:3,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        vertical: true,
        verticalSwiping: true,
        prevArrow : '<div class="product-prev"><i class="icons iPrev"></i></div>',
        nextArrow : '<div class="product-next"><i class="icons iNext"></i></div>'
    });

    $(".slide-deal-km").find(".sys_countdown").each(function () {
        var arrDateData = $(this).attr("data-times").split(",");
        var destDay = new Date(arrDateData[0], arrDateData[1] - 1, arrDateData[2], arrDateData[3], arrDateData[4], arrDateData[5]);
        $(this).countdown({
            until:destDay,
            //layout:'{dn} <span>{dl}</span> {hnn}{sep}{mnn}{sep}{snn}s'
        });
    });

    $(".sys_filter_view").on('click',function(){
        $(".filter-view").children().removeClass('active');
        $(this).children().addClass('active');
        var value = parseInt($(this).data('value'));
        if(value == 1){
            $(".sys_view_content").removeClass('list-product');
            $(".sys_view_content").addClass('list-product-grid');
        }else if(value == 2){
            $(".sys_view_content").removeClass('list-product-grid');
            $(".sys_view_content").addClass('list-product');
        }
        jQuery.cookie("type_view", value, { expires : 30 });
    })
})
