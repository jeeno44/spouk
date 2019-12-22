@extends('layouts.master')

@section('title')Редактировать курс@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($item, ['method' => 'put', 'url' => '/dic/courses/'.$item->id, 'class' => 'panel panel-default']) !!}
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Редактировать курс</div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="panel-body form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Название</label>
                            <div class="col-md-6">
                                {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Номер курса</label>
                            <div class="col-md-6">
                                {!! Form::text('number', null, ['class' => 'form-control', 'required']) !!}
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('number') }}</strong>
                                            </span>
                                @endif
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
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
