/**
 * Created by ChungDuc on 7/23/14.
 */
var Admin_Validate = {
    config: {},
    displayValError: function(id, mess,scrollToElement){
        this.disableValError(id);
        $('#'+id).css({'background-color':'#ffc1c1'}).focus().parent().append('<span id="show-error" style="color:#f00;font-size:11px">' + mess + '</span>');
        if(scrollToElement == undefined || scrollToElement == true) {
            var top = $('#'+id).offset().top;
            $("html, body").animate({ scrollTop: top-80 }, 500);
        }
    },

    disableValError: function(id){
        $('#add-posts input, #add-posts select').css({'background-color':'#fff!important'});
        $('#show-error').remove();
    },

    postsValid: function() {
        var sys_category_id = parseInt($('#sys_category_id').val());
        var sys_books_id = parseInt($('#sys_books_id').val());
        var sys_posts_title = $('#sys_posts_title').val();
        var sys_posts_content = $('#sys_posts_content').val();
        var sys_posts_tags = $('#sys_posts_tags').val();

        if(sys_category_id == undefined || sys_category_id == 0) {
            this.displayValError('sys_category_id', 'Bạn chưa chọn chuyên mục');
            $('#sys_category_id').attr('disabled', false);
            return false;
        }

        if(sys_books_id == undefined || sys_books_id == 0) {
            this.displayValError('sys_books_id', 'Bạn chưa chọn sách');
            $('#sys_books_id').attr('disabled', false);
            return false;
        }

        if(sys_posts_title == undefined || sys_posts_title == '') {
            this.displayValError('sys_posts_title', 'Bạn chưa nhập tiêu đề');
            $('#sys_posts_title').attr('disabled', false);
            return false;
        }

        if(sys_posts_content == undefined || sys_posts_content == '') {
            this.displayValError('sys_posts_content', 'Bạn chưa nhập nội dung');
            $('#sys_posts_content').attr('disabled', false);
            return false;
        }

        if(sys_posts_tags == undefined || sys_posts_tags == '') {
            this.displayValError('sys_posts_tags', 'Bạn chưa nhập tags');
            $('#sys_posts_tags').attr('disabled', false);
            return false;
        }

        $('#add-posts').submit();
        return true;
    }
}

