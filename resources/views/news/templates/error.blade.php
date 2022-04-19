@if (count($errors)>0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p><strong>{{ $error }}</strong></p>
        @endforeach
    </div>
@endif