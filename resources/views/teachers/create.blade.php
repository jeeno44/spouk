@extends('layouts.master')

@section('title')Новый сотрудник@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="panel panel-default" method="post" action="/college/teachers">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Новый сотрудник</div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">e-mail</label>
                                <div class="col-md-6">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="college_id" value="{{Auth::user()->college_id}}">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Телефон</label>

                                <div class="col-md-6">
                                    {!! Form::text('phone', null, ['class' => 'form-control input-mask', 'required', 'data-inputmask' => "'mask': '+7 (999) 999-99-99'"]) !!}
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
                                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Имя</label>
                                <div class="col-md-6">
                                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Отчество</label>
                                <div class="col-md-6">
                                    {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
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
                            @if(count(getSubdivisions(Auth::user()->college_id)))
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Подразделение</label>
                                    <div class="col-md-6">
                                        {!! Form::select('subdivision_id',getSubdivisions(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-2 control-label">Доступные модули</label>
                                <div class="col-md-6">
                                    @foreach(\App\Models\AccessLevel::all() as $level)
                                        <div class="checkbox checkbox-inline checkbox-styled">
                                            <label>
                                                <input type="checkbox" class="" name="levels[]" value="{{$level->id}}">
                                                <span>{{$level->desc}}</span>
                                            </label>
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
