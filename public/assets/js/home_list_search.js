/**
 * User: tuanna
 * Date: 12/22/2014
 * Time: 10:57 AM
 */

$(document).ready(function(){
    var cat_sponsored = 0;
    $.ajax({
        type: "GET",
        url: BASE_URL + "/getTourDealMC",
        data: {
            category:cat_sponsored
        },
        dataType: 'json',
        beforeSend: function () {
        },
        success: function (res) {
            if(res.intIsOK == 1){
                //$("#sys_support_plaza").append(res.html)
                var i = 0;
                var j = 0;
                $(".sponsor-x2").each(function(){
                    if(i in res.resx2){
                        if(res.resx2[i].banner_type == 4){
                            $(this).attr("class", "slot-x2").html('<a href="' + res.resx2[i].link + '"><img class="img-banner" src="' + res.resx2[i].image + '" alt="' + res.resx2[i].title + '"></a>')
                        }else {
                            $(this).find(".location-name").attr('href', res.resx2[i].link);
                            $(this).find(".location-name").html(res.resx2[i].province);
                            $(this).find(".lbl-mark").html(res.resx2[i].target);
                            $(this).find(".star-yl").addClass('s' + res.resx2[i].star);
                            $(this).find(".img-thumb-deal").attr('href', res.resx2[i].link);
                            $(this).find(".img-overlay").attr('alt', res.resx2[i].title);
                            $(this).find(".img-overlay").css('background-image', 'url("' + res.resx2[i].image + '")');
                            $(this).find(".cl-trans").attr('href', res.resx2[i].link);
                            $(this).find(".cl-trans").html(res.resx2[i].title);
                            var star = parseInt(res.resx2[i].star) / 5 * 100
                            $(this).find(".star-sm").find('i').css('width', star + '%');
                            $(this).find(".per-val").html(res.resx2[i].price_promotion);
                            var price = parseInt(res.resx2[i].price);
                            $(this).find(".price-val").html(price.format(0, 3, '.', ','));
                            $(this).find(".deal-desc").html(res.resx2[i].note);
                        }
                    }else{
                        $(this).addClass('hidden');
                    }
                    i++;
                });
                $(".sponsor-x3").each(function(){
                    if(j in res.resx3){
                        if(res.resx3[j].banner_type == 4){
                            $(this).attr("class", "slot-x3").html('<a href="' + res.resx3[j].link + '"><img class="img-banner" src="' + res.resx3[j].image_big + '" alt="' + res.resx3[j].title + '"></a>')
                        }else {
                            $(this).find(".location-name").attr('href', res.resx3[j].link);
                            $(this).find(".location-name").html(res.resx3[j].province);
                            $(this).find(".lbl-mark").html(res.resx3[j].target);
                            $(this).find(".star-yl").addClass('s' + res.resx3[j].star);
                            $(this).find(".img-thumb-deal").attr('href', res.resx3[j].link);
                            $(this).find(".img-overlay").attr('alt', res.resx3[j].title);
                            $(this).find(".img-overlay").css('background-image', 'url("' + res.resx3[j].image_big + '")');
                            $(this).find(".cl-trans").attr('href', res.resx3[j].link);
                            $(this).find(".cl-trans").html(res.resx3[j].title);
                            var star = parseInt(res.resx3[j].star) / 5 * 100
                            $(this).find(".star-sm").find('i').css('width', star + '%');
                            $(this).find(".per-val").html(res.resx3[j].price_promotion);
                            var price = parseInt(res.resx3[j].price);
                            $(this).find(".price-val").html(price.format(0, 3, '.', ','));
                            $(this).find(".deal-desc").html(res.resx3[j].note);
                        }
                    }else{
                        $(this).addClass('hidden');
                    }
                    j++;
                });
            }else{
                $(".sponsor").addClass('hidden');
            }
        },
        error:function(){
        }
    });
    $("#sys_sort_options").on('change',function(){
        var sort = $(this).val();
        $.cookie('sort',sort , {path:'/', domain:COOKIE_DOMAIN});
        location.reload();
    })
})
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

