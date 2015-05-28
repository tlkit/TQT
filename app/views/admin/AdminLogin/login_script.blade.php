<script>
    $('.list-inline li > a').click(function () {
        $(this).parent().addClass("hidden").siblings().removeClass("hidden");
        var activeForm = $(this).attr('href') + ' > form';
        //console.log(activeForm);
        $(activeForm).addClass('magictime swap');
        //set timer to 1 seconds, after that, unload the magic animation
        setTimeout(function () {
            $(activeForm).removeClass('magictime swap');
        }, 1000);
    });

    @if(isset($code))
        @if($code == 201 || $code == 203)
        $( document ).ready(function() {
            $("#user_name").focus();
            $("#user_name").css( "background-color","yellow");
        });
    @elseif($code == 202)
    $( document ).ready(function() {
        $("#password").focus();
        $("#password").css( "background-color","red");
    });
    @endif
    @endif
</script>