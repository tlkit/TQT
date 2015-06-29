{{ HTML::style('assets/site/countdown/assets/css/css.css'); }}
{{ HTML::style('assets/site/countdown/assets/css/styles.css'); }}
{{ HTML::style('assets/site/countdown/assets/countdown/jquery.countdown.css'); }}

{{HTML::script('assets/site/countdown/assets/js/html5.js');}}
{{HTML::script('assets/site/countdown/assets/js/jquery-1.7.1.min.js');}}
{{HTML::script('assets/site/countdown/assets/countdown/jquery.countdown.js');}}
{{HTML::script('assets/site/countdown/assets/js/script.js');}}


<div class="form-group text-center" style="text-align: center">
    <img src="{{$url_src_icon}}">

    <!-- dếm ngược -->
    <div style="clear: both; margin-top: 50px"></div>
    <div id="countdown"></div>
    <p id="note"></p>

</div>




