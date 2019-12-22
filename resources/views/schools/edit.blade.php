@extends('layouts.master')

@section('title')Редактировать школу@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($item, ['method' => 'put', 'url' => '/dic/schools/'.$item->id, 'class' => 'panel panel-default']) !!}
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Редактировать школу</div>
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
                                {!! Form::textarea('title', null, ['class' => 'form-control', 'required', 'rows' => 3]) !!}
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
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
