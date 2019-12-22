@extends('layouts.master')

@section('title')Профиль@stop

@section('content')
    <section class="">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Настройки учетной записи</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">e-mail</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Телефон</label>

                                    <div class="col-md-6">
                                        <input type="tel" class="form-control input-mask" name="phone" value="{{ Auth::user()->phone }}" data-inputmask="'mask': '+7 (999) 999-99-99'">

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Фамилия</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Имя</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Отчество</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="middle_name" value="{{ Auth::user()->middle_name }}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Пароль</label>

                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Повторите пароль</label>

                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password_confirmation">

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
