//do cover
$(function(){
    $("#sys_wrap_option_color > div").on("click",function(){
        var getCodeColor = $(this).attr("data-code-color");
        $("#sys_frame_preview").contents().find(".cover").attr("style", "background-color:" + getCodeColor);
        $("#sys_color_val").val(getCodeColor);
        $("#sys_cover_val").val('');
    });

//upload anh len va preview
    var urlAjaxUpload = document.getElementById('sys_urlAjaxInsertImageToDesc').value ;
    new AjaxUpload(jQuery('#sys_set_img_cover'), {
        action: urlAjaxUpload,
        name: 'uploadfile',
        responseType: 'json',
        onSubmit: function(file, ext){
            $('#img_loading').show();
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                alert('Only JPG, PNG or GIF files are allowed');
                return false;
            }
        },
        onComplete: function(file, xhr){
            if(xhr.intReturn == 1)
            {
                var getLinkImg = xhr.info.src;
                $("#sys_frame_preview").contents().find(".cover").css("background-image", "url(" + getLinkImg + ")");
                $("#sys_color_val").val('');
                $("#sys_cover_val").val(xhr.info.name_img_orther);
            }else{
                alert('Chưa upload được ảnh');
            }
            $('#img_loading').hide();
        }
    });

    $("#sys_font_size").on("change",function(){
        $("#sys_frame_preview").contents().find(".cover .big-tit span").css("font-size",$(this).find(":selected").text());
    });

    $("#sys_next_banner").on("click",function(){
        $('#sys_next_banner').attr('disabled', true);
    });
});




