@extends('news.main')
@section('content')
    @include('news.block.slider')
    <div class="content_container">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main_content">
                        <!-- Featured -->
                        @include('news.block.featured', ['items' => $itemArticle ])
                        <!-- Category -->
                        @include('news.pages.home.child-index.category')
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar">
                        <!-- Latest Posts -->
                        @include('news.block.latest_posts', ['items' => $itemLatestArticle])
                        <!-- Advertisement -->
                        @include('news.block.advertisement', ['itemsAdvertisement' => [] ])
                        <!-- Most Viewed -->
                        @include('news.block.most_viewed', ['itemsMostViewed' => [] ])
                        <!-- Tags -->
                        @include('news.block.tags', ['itemTag' => $itemTag ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection