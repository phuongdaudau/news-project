
<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">
                <span class="label label-info label-pagination">{{$items->perPage()}} phần tử trên 1 trang</span>
                 <span class="label label-success label-pagination">Tống {{$items->total()}} phẩn tử</span>
                <span class="label label-danger label-pagination">{{$items->lastPage()}} trang</span>
            </p>
        </div>
        <div class="col-md-6">
            {{ //$items->links('pagination.pagination_backend') 
                $items->appends(request()->input())->links('pagination.pagination_backend') 
            }}
        </div>
    </div>
</div>