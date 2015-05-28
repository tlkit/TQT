$(function () {
    $(".xxxDropdown").xxxDropdown();


    var sys_home_feature_deals = $("#sys_home_feature_deals");
    if(sys_home_feature_deals.length>0) {
        sys_home_feature_deals.on("click",".bullet",function(){
            var getIdx = $(this).index();
            $(this).addClass("active").siblings().removeClass("active");
            $("#sys_slide_feature_deal").children().eq(getIdx).addClass("active").siblings().removeClass("active");
        });
        sys_home_feature_deals.on("click",".iNext",function(){
            var getIdx = $("#sys_slide_feature_deal").children(".active").index() + 1;
            var le = $(".feature-deal-items").length;
            if(getIdx == le ){
                getIdx = 0;
            }
            $(this).addClass("active").siblings().removeClass("active");
            $("#sys_slide_feature_deal").children().eq(getIdx).addClass("active").siblings().removeClass("active");
            $(".bullets").children().eq(getIdx).addClass("active").siblings().removeClass("active");
        })
        sys_home_feature_deals.on("click", ".iPrev", function () {
            var getIdx = $("#sys_slide_feature_deal").children(".active").index();
            var le = $(".feature-deal-items").length - 1;
            if (getIdx == 0) {
                getIdx = le;
            }else{
                getIdx = getIdx - 1;
            }
            $(this).addClass("active").siblings().removeClass("active");
            $("#sys_slide_feature_deal").children().eq(getIdx).addClass("active").siblings().removeClass("active");
            $(".bullets").children().eq(getIdx).addClass("active").siblings().removeClass("active");
        })
    }
    /*var sys_deal_suggestion_bottom = $("#sys_deal_suggestion_bottom");
    if (sys_deal_suggestion_bottom.length > 0) {
        if (sys_deal_suggestion_bottom.find("li").length > 4)
            sys_deal_suggestion_bottom.tinycarousel();
        else
            sys_deal_suggestion_bottom.find(".buttons").remove();
    }*/

    if ($(".sys_countdown").length > 0) {
        $(".sys_countdown").each(function () {
            var arrDateData = $(this).attr("data-times").split(",");
            var onlyDay = $(this).attr("data-onny-day");
            var destDay = new Date(arrDateData[0], arrDateData[1] - 1, arrDateData[2], arrDateData[3], arrDateData[4], arrDateData[5]);
            if(onlyDay) {
                $(this).countdown({
                    until: destDay,
                    padZeroes: true,
                    layout: '{dn}'
                });
            }else
                $(this).countdown({
                    until: destDay,
                    layout: '{dn} <span>{dl}</span> {hnn} : {mnn} : {snn}s'
                });
        });
    }

    $(window).on("scroll", function () {
        var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
        if (pageOffetTop > 100) {
            $("#sys_back_top").addClass("active");
        } else
            $("#sys_back_top").removeClass("active");


    });
    $("#sys_back_top").on("click", function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });

    //Page: Shop
    $(".sys_tab_page_lbl").on("click",function(){
        var getIdx = $(this).index();
        $(this).addClass("active").siblings().removeClass("active");
        $("#sys_shop_page").find(".sys_tab_page_content").removeClass("active").eq(getIdx).addClass("active");
    });


    $.ajax({
        type: "GET",
        url: BASE_URL + "/site/suggest",
        dataType: 'json',
        beforeSend: function () {},
        success: function (res) {
            if(res.intIsOK!=-1) {
                if(res.size>0) {
                    var suggestDataFooter = res.data;
                    $("#sys_deal_suggestion_bottom").find(".box-suggestion").removeClass("loading");
                    initSlideSuggest("sys_deal_suggestion_bottom",suggestDataFooter);
                    $(window).on("resize",function(){
                        initSlideSuggest("sys_deal_suggestion_bottom", suggestDataFooter);
                    });
                }else{
                    $("#sys_deal_suggestion_bottom").hide();
                }
            }else{
                $("#sys_deal_suggestion_bottom").hide();
            }
        },
        error: function () {
            //alert("Có lỗi xảy ra.");
        }
    });

});


function initSlideSuggest(idSlide,arrData){
    var configDealWidth = 207,
        configDealMarginDefault = 10,//margin ca 2 dau cua item
        sys_deal_suggested_list = $("#" + idSlide),
        getAvailableContent = sys_deal_suggested_list.find(".overview").width();
    var calcDealNumberInViewer = Math.floor((getAvailableContent) / (configDealWidth + configDealMarginDefault)),
        calcBalanceWidth = getAvailableContent % (configDealWidth + configDealMarginDefault),
        calcMarginNew = (calcBalanceWidth/calcDealNumberInViewer) + configDealMarginDefault,
        currentPage = 1,
        pageNumber = (arrData.length % calcDealNumberInViewer == 0) ? (arrData.length / calcDealNumberInViewer) : (Math.floor(arrData.length / calcDealNumberInViewer) + 1);

    sys_deal_suggested_list.find(".overview").html("");
    if(calcDealNumberInViewer >= arrData.length) {
        sys_deal_suggested_list.addClass('no-slide').find(".buttons").hide();
        for (var p1 = 0; p1 < arrData.length; p1++) {
            $(arrData[p1]).appendTo(sys_deal_suggested_list.find(".overview"));
        }
    }else{
        var calcMarginNewMiddleDeal = Math.floor(calcMarginNew / 2 + (calcMarginNew / 2 - configDealMarginDefault / 2) / (calcDealNumberInViewer - 1));
        for (var p = 0; p < calcDealNumberInViewer; p++) {
            if(p==0) {
                $(arrData[p]).children().css({"width": (configDealWidth + calcMarginNewMiddleDeal - (configDealMarginDefault/2))}).end().appendTo(sys_deal_suggested_list.find(".overview"));
            }else{
                if(p==(calcDealNumberInViewer-1)) {
                    $(arrData[p]).children().css({"width": (configDealWidth + calcMarginNewMiddleDeal - (configDealMarginDefault/2))}).end().appendTo(sys_deal_suggested_list.find(".overview"));
                }else{
                    $(arrData[p]).children().css({"width": (configDealWidth + calcMarginNewMiddleDeal * 2 - configDealMarginDefault)}).end().appendTo(sys_deal_suggested_list.find(".overview"));
                }
            }
        }

    }
    if(pageNumber > 1) {
        sys_deal_suggested_list.find(".sys_suggest_detail_current_page").html(currentPage);
        sys_deal_suggested_list.find(".sys_suggest_detail_total_page").html(pageNumber);
    }else{
        sys_deal_suggested_list.find(".sys_paging_suggest_list").hide();
    }
    sys_deal_suggested_list.on("click dbclick",".next",function(){
        var idx = calcDealNumberInViewer;
        currentPage = (currentPage == pageNumber) ? 1 : (currentPage + 1);
        sys_deal_suggested_list.find(".sys_suggest_detail_current_page").html(currentPage);
        var arrIdxStarRun = currentPage * calcDealNumberInViewer - 1;
        var intervalUpdate = setInterval(function () {
            if (idx == 0) {
                clearInterval(intervalUpdate);
            } else {
                var newHtml;
                if(arrData[arrIdxStarRun]) {
                    newHtml = $(arrData[arrIdxStarRun]).children();
                }else{
                    newHtml ="";
                }
                arrIdxStarRun--;
                replaceContent(sys_deal_suggested_list.find("li").eq(--idx),newHtml);
            }
        }, 33);
        return false;
    });
    sys_deal_suggested_list.on("click dbclick",".prev",function(){
        var idx=0;
        currentPage = (currentPage == 1 ) ? pageNumber : (currentPage - 1);
        sys_deal_suggested_list.find(".sys_suggest_detail_current_page").html(currentPage);
        var arrIdxStarRun = calcDealNumberInViewer*(currentPage - 1);
        var intervalUpdate = setInterval(function () {
            if (idx == calcDealNumberInViewer) {
                clearInterval(intervalUpdate);
            } else {
                var newHtml ="";
                if(arrData[arrIdxStarRun]) {
                    newHtml = $(arrData[arrIdxStarRun]).children();
                }else{
                    newHtml = "";
                }
                arrIdxStarRun++;
                replaceContent(sys_deal_suggested_list.find("li").eq(idx++), newHtml);
            }
        }, 33);
        return false;
    });
}
function replaceContent(jObj,htmlNew){
    htmlNew = htmlNew ? htmlNew : "";
    $(jObj).children().html(htmlNew);
}