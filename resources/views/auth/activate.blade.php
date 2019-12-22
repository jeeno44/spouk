@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card contain-sm card-underline">
	            <div class="card-head style-default-light"><header>Регистрация</header></div>
                <div class="card-body">
                    @if($status == 'success')
                        <div class="alert alert-success">Учетная запись успешно активирована, теперь вы можете <a href="/login">войти</a> в систему, используя email и пароль</div>
                    @else
                        <div class="alert alert-danger">Неверный код активации</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
