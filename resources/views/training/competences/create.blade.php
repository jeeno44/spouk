@extends('layouts.master')

@section('title')Новая компетенция@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="panel panel-default" method="post" action="/training/competences">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Новая компетенция</div>
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
                            <div class="form-group">
                                <label class="col-md-2 control-label">Код</label>
                                <div class="col-md-6">
                                    {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Дисциплины</label>
                                <div class="col-md-6">
                                    @foreach($disciplines as $d)
                                        <div class="checkbox checkbox-inline checkbox-styled">
                                            <label>
                                                <input type="checkbox" class="" name="disciplines[]" value="{{$d->id}}">
                                                <span>{{$d->title}}</span>
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
