@php
    use App\Helpers\URL;
    $linkCategory = URL::linkCategory($item['id'],$item['name']) ;
@endphp
<div class="technology">
    <div class="section_title_container d-flex flex-row align-items-start justify-content-start">
        <div>
            <div class="section_title">{!!$item['name']!!}</div>
        </div>
        <div class="section_bar"></div>
    </div>
    <div class="technology_content">
        @foreach ($item['article'] as $article)
        <div class="post_item post_h_large">
            <div class="row">
                <div class="col-lg-5">
                    @include('news.partials.article.image', ['item'=> $article])
                </div>
                <div class="col-lg-7">
                    @include('news.partials.article.content', ['item'=> $article, 'lengthContent' => 200, 'showCategory' =>false]) 
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="{{$linkCategory}}">Xemthêm</a></div>
        </div>
    </div>
</div>