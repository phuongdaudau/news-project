@extends('admin.main')
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')

    @if(isset($item['id']))
    <div class="row">
        @include('admin.user.form_info')
        @include('admin.user.form_change_password')
        @include('admin.user.form_change_level')
    </div>
    @else
        @include('admin.user.form_add')
    @endif
@endsection