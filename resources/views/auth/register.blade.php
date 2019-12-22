@extends('layouts.frontend')
@section('title') Регистрация @endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card contain-sm card-underline">
	            <div class="card-head style-default-light"><header>Регистрация учебного заведения</header></div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" id="register-form">
                        {!! csrf_field() !!}
                        <h3 class="text-center">Выберите учебное заведение</h3>
                        <div class="form-group{{ $errors->has('region_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Регион *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="reg" value="{{ old('reg') }}" id="regions" required>
                                <input type="hidden" name="region_id" value="{{ old('region_id') }}">
                                @if ($errors->has('region_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Город *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cit" value="{{ old('cit') }}" id="cities" required>
                                <input type="hidden" name="city_id" value="{{ old('region_id') }}">
                                @if ($errors->has('city_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('college') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Учебное заведение *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="coll" value="{{ old('coll') }}" id="colleges" required>
                                <input type="hidden" name="college_id" value="{{ old('college_id') }}">
                                @if ($errors->has('college'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <a href="#" class="show-next" data-target="#new-college">Или добавьте новое</a>
                            <input type="hidden" name="new_college" value="0">
                        </div>

                        <div class="hidden" id="new-college">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Адрес</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="college_address" value="{{ old('college_address') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Телефон</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control input-mask" name="college_phone" value="{{ old('college_phone') }}" data-inputmask="'mask': '+7 (999) 999-99-99'">
                                </div>
                            </div>
                            <div class="form-group" id="edu-systems">
                                <label class="col-md-4 control-label">Реализуемые уровни образования</label>
                                <div class="col-md-6">
                                    @foreach(\App\Models\System::where('enabled', 1)->get() as $system)
                                        <div class="checkbox checkbox-inline checkbox-styled">
                                            <label>
                                                <input type="checkbox" class="sub-systems" name="sub_systems[]" value="{{$system->id}}">
                                                <span>{{$system->name}}</span>
                                            </label>
                                        </div><br>
                                    @endforeach
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h3 class="text-center">Информация для регистрации руководителя</h3>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">e-mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input type="tel" class="form-control input-mask" name="phone" value="{{ old('phone') }}" data-inputmask="'mask': '+7 (999) 999-99-99'">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Фамилия</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Имя</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Отчество</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Пароль</label>

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
                            <label class="col-md-4 control-label">Повторите пароль</label>

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
                            <div class="col-md-offset-4 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Регистрация
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
