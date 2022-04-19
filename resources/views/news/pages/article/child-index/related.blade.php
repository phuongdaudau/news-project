@if(count($item['relatedArticle'])>0)
   <div class="section_title_container d-flex flex-row align-items-start justify-content-start zvn-title-category">
      <div>
         <div class="section_title">Bài viết cùng chuyên mục</div>
      </div>
      <div class="section_bar"></div>
   </div>
   @foreach ($item['relatedArticle'] as $item)
      <div class="post_item post_h_large">
         <div class="row">
            <div class="col-lg-5">
               @include('news.partials.article.image', ['item'=> $item])
            </div>
            <div class="col-lg-7">
               @include('news.partials.article.content', ['item'=> $item, 'lengthContent' => 200, 'showCategory' =>false]) 
            </div>
         </div>
      </div>
   @endforeach
@endif