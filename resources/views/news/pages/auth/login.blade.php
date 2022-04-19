@extends('news.login')
@section('content')
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Đăng nhập</h4>
            @php
                $inputHiddenTask = Form::hidden('task','login');
            @endphp
            @include('news.templates.error')
            @include('news.templates.alert')
            {!! Form::open([
                'method' => 'POST',
                'url' => route("$prefix/postLogin"),
                'id' => 'auth-form'
            ]) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Mật khẩu') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>

                <div class="form-group no-margin">
                    {!!  $inputHiddenTask.Form::submit('Đăng nhập', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
                <div class="margin-top20 text-center">
                    Bạn chưa có tài khoản? <a href="{{route('auth/register')}}">Đăng ký</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="footer">
        Copyright &copy; 2017
    </div>
@endsection