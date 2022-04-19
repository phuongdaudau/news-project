
<div class="technology">
    <div class="technology_content">
        @foreach ($items as $item)
        @php
            $title = $item['title'];
            $thumb = $item['thumb'];
            $link = $item['link'];
            $pubDate = $item['pubDate'];
            $description = $item['description'];
        @endphp
        <div class="post_item post_h_large">
            <div class="row">
                <div class="col-lg-5">
                    <div class="post_image">
                        <img src="{{$thumb}}" alt="{{$title}}">
                    </div>               
                </div>
                <div class="col-lg-7">
                    <div class="post_content">
                        <div class="post_title"><a href="{{ $link}}">{{ $title }}</a></div>
                        <div class="post_info d-flex flex-row align-items-center justify-content-start">
                            <div class="post_date"><a href="#">{{ $pubDate}}</a></div> 
                        </div>
                        <div class="post_text"> <p>{!! $description !!}</p> </div>
                    </div>               
                 </div>
            </div>
        </div>
        @endforeach
    </div>
</div>