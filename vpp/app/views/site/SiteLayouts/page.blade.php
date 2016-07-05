<div id="content" style="overflow-x: hidden">
    @if($page)
        {{htmlspecialchars_decode($page['page_content'])}}
    @endif
</div>