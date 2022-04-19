<div class="tags">
    <div class="sidebar_title">Tags</div>
    <div class="tags_content d-flex flex-row align-items-start justify-content-start flex-wrap">
        @php
            use App\Helpers\URL;
            $xhtml ='';
            foreach ($itemTag as $item){
                $linkCategory = URL::linkCategory($item['id'],$item['name']) ;
                $xhtml .= sprintf(' <div class="tag cat_%s"><a href="%s">%s</a></div>',Str::slug($item['name']),$linkCategory,$item['name']);
            }
        @endphp 
        {!! $xhtml !!}
    </div> 
</div> 