@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card contain-sm card-underline">
	            <div class="card-head style-default-light"><header>Авторизация</header></div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/two-step') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <div class="col-md-8 col-md-offset-2">
                                @if (config('sms.driver') == 'log')
                                    <span class="help-block">
                                        На ваш телефон выслан код подтверждения
                                    </span>
                                @endif
                                {!! Form::text('code', $sms->code, ['class' => 'form-control', 'required', 'placeholder' => 'Введите код из sms-сообщения']) !!}
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Войти
                                </button>
                                <br><br>
                                @if((strtotime($sms->created_at) + 300) > time())
                                    Повторно запросить код можно через {{abs(time() - strtotime($sms->created_at) - 300)}} секунд
                                @else
                                    <a class="btn btn-default" href="{{ url('/auth/two-step') }}">Выслать код повторно</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
