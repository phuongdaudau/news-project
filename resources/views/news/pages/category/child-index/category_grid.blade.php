
<div class="row world_row">
    <div class="col-lg-11">
        <div class="row">
            @foreach ($item['article'] as $article)
            <div class="col-lg-6">
                <div class="post_item post_v_small d-flex flex-column align-items-start justify-content-start">
                    @include('news.partials.article.image', ['item'=> $article])
                    @include('news.partials.article.content', ['item'=> $article, 'lengthContent' => 200, 'showCategory' =>false]) 
                </div>
            </div>
            @endforeach
        </div>
        @if(count($item['article'])>10)  
        <div class="row">
            <div class="home_button mx-auto text-center"><a href="#">Xem
                thêm</a></div>
        </div>
        @endif
    </div>
</div>

