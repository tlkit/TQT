/**
 * Created by PC0353 on 12/6/2016.
 */

$(document).ready(function(){
    var header = $("#header");
    var height = $("#header").height() - $(".header-nav").height();
    $("body").data("prevPageOffetTop", 0);
    $(window).on("scroll", function () {
        var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
        // Bám menu bên trái
        /*        if(cateOffset.length>0){
         var configXXX = 150;
         var newPageOffetTop = pageOffetTop + configXXX;
         if(newPageOffetTop<cateOffset[0]){
         $("#sys_main_dock_menu").removeClass("active").find("a").removeClass("active").end()
         .find("li").eq(0).find("a").addClass("active");
         }else
         for(var p = 0; p < cateOffset.length; p++){
         if(p==(cateOffset.length-1)){
         if(newPageOffetTop>cateOffset[p] && newPageOffetTop <($(".sys_mod_home_cate").last().height() + cateOffset[p])){
         if(pageOffetTop>$("#sys_prevent_dock_menu").offset().top - $("#sys_main_dock_menu").position().top - $("#sys_main_dock_menu").find("ul").height()){
         $("#sys_main_dock_menu").removeClass("active").find("a").removeClass("active").end()
         .find("li").eq(cateOffset.length-1).find("a").addClass("active");
         }else
         $("#sys_main_dock_menu").addClass("active").find("a").removeClass("active").end()
         .find("li").eq(p).find("a").addClass("active");
         }/!*else{
         $("#sys_main_dock_menu").removeClass("active").find("a").removeClass("active").end()
         .find("li").eq(cateOffset.length-1).find("a").addClass("active");
         }*!/
         }else
         if(newPageOffetTop > cateOffset[p] && newPageOffetTop < cateOffset[p + 1]){
         $("#sys_main_dock_menu").addClass("active").find("a").removeClass("active").end()
         .find("li").eq(p).find("a").addClass("active");
         break;
         }
         }
         }*/
        if (pageOffetTop > height) {
            header.addClass("fixtop");
        } else {
            header.removeClass("fixtop");
        }
    });
});
