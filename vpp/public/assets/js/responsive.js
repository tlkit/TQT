arrAdsHome= [
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14289.ads",
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14291.ads",
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14295.ads",
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14297.ads"
];

arrAdsDetail= [
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14295.ads",
    "//admicro1.vcmedia.vn/ads_codes/ads_box_14297.ads"
];

$(function () {
    /*for Responsive menu: in all page*/
    if($("#mp-menu").length > 0)
       new mlPushMenu(document.getElementById( 'mp-menu' ), document.getElementById( 'sys_wrap_logo_main' ),{dockSide: "left"} );

    /*var wW = $(window).width();
    if(wW >= 980) {
        console.log("load ads");
        for (var p = 0; p < arrAdsHome.length; p++) {
            loadJsAds(arrAdsHome[p], "sys_box_for_ads");
            loadBreak("sys_box_for_ads");
        }
    }*/
    /*$(window).on("load",function(){
        var wW = $(window).width();
        if(wW >= 980) {
            console.log("load ads");
            for (var p = 0; p < arrAdsHome.length; p++) {
                loadJsAds(arrAdsHome[p], "sys_box_for_ads");
                loadBreak("sys_box_for_ads");
            }
            //document.write("");
        }
    });*/

});

function loadJsAds(srcAds, boxAdsId) {
    var fileref = document.createElement('script');
        fileref.setAttribute("type", "text/javascript");
        fileref.setAttribute("src", srcAds);

    if (typeof fileref != "undefined")
        document.getElementById(boxAdsId).appendChild(fileref);
}
function loadBreak(boxAdsId) {
    var fileref = document.createElement('br');
    if (typeof fileref != "undefined")
        document.getElementById(boxAdsId).appendChild(fileref);
}

