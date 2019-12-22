@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card contain-sm card-underline">
	            <div class="card-head style-default-light"><header>Авторизация</header></div>
                <div class="card-body">
                    <form class="form floating-label" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            <label class="control-label">Ваш e-mail</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" name="password">
							<label class="control-label">Пароль</label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <p class="help-block"><a href="{{ url('/password/reset') }}">Восстановить пароль?</a></p>
                        </div>
                        <div class="row login-btn">
							<div class="col-xs-5">
								<div class="checkbox checkbox-inline checkbox-styled">
									<label>
										<input type="checkbox" name="remember">
										<span>Запомнить меня</span>
									</label>
								</div>
							</div><!--end .col -->	
							<div class="col-xs-5 col-md-offset-2 text-right">
								<button class="btn btn-primary btn-raised login-btn-sub" type="submit">Вход</button>
							</div><!--end .col -->
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
