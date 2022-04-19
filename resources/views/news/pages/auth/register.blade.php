<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="{{asset('auth/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('auth/css/my-login.css')}}">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="{{asset('auth/img/logo.jpg')}}">
					</div>
					<div class="card fat">
						<div class="card-body">
                            @php
                                $inputHiddenTask = Form::hidden('task','register');
                            @endphp
							<h4 class="card-title">Đăng ký</h4>
                            @include('news.templates.error')
                            @include('news.templates.alert')
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route("$prefix/postRegister"),
                                'id' => 'auth-form'
                            ]) !!}
                            <div class="form-group">
                                {!! Form::label('username', 'Username') !!}
                                {!! Form::text('username', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                            </div>
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
                                    <input type="checkbox" name="aggree" value="1"> Tôi đồng ý với các điều khoản dịch vụ
                                </label>
                            </div>
                            <div class="form-group no-margin">
                                {!!  $inputHiddenTask.Form::submit('Đăng ký', ['class' => 'btn btn-primary btn-block']) !!}
                            </div>
                            <div class="margin-top20 text-center">
                                Đã có tài khoản? <a href="{{route('auth/login')}}">Đăng nhập</a>
                            </div>
                            {!! Form::close() !!}
						</div>
					</div>
					<div class="footer">
						Copyright &copy; PDDIM
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{asset('auth/js/jquery.min.js')}}"></script>
	<script src="{{asset('auth/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('auth/js/my-login.js')}}"></script>
</body>
</html>