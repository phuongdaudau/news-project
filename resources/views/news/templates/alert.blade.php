@if (session('Notify'))
<div class="row">
    <div class="alert alert-danger" role= "alert">
        <button type = "button" class = "close" data-dismiss= "alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
        <strong>{{ session('Notify') }}</strong>
    </div>
</div>
@endif