$(document).ready(function(){

    $('#banner_page_id').change(function() {
        if(this.value == 2) {
            $('#sys_mc_category_id').show();
        } else {
            $('#sys_mc_category_id').hide();
        }
    });

});