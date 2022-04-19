@php
    $pageTitle = 'Danh sách ' . ucfirst($prefix);

    $link = route($prefix .'/form');
    $icon = 'fa-plus-circle';
    $title = ' Thêm mới';

    if($pageIndex == false){
        $link = route($prefix);
        $icon = 'fa-arrow-left';
        $title = ' Quay về';
    }
    $button = sprintf(' <a href="%s" class="btn btn-success"> <i class="fa %s"></i> %s</a>', $link, $icon, $title);
@endphp

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{{ $pageTitle }}</h3>
    </div>
    <div class="zvn-add-new pull-right">
       {!!$button !!}
    </div>
</div>