@extends('layouts.frontend')
@section('title') Регистрация @endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-3">
            <div class="card contain-sm card-underline">
	            <div class="card-head style-default-light"><header>Спасибо за регистрацию</header></div>
                <div class="card-body">
                    <div class="alert alert-success text-center">Мы оптравили на адрес <a href="mailto:{{Session::get('email', '')}}">{{Session::get('email', '')}}</a> письмо со ссылкой для подтверждения вышей учетной записи.
                    <br>Желаем вам приятного пользования данной платформой.</div>
                    <div class="form-group">
                        <div class="col-md-offset-4 text-center">
                            <a class="btn btn-primary" href="/login">
                                Ok
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
