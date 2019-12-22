@extends('layouts.master')

@section('title'){{$item->title}}@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($item, ['method' => 'put', 'url' => '/training/competences/'.$item->id, 'class' => 'panel panel-default']) !!}
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">{{$item->title}}</div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="panel-body form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-2">Название</label>
                            <div class="col-md-6">
                                {{$item->title}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">Код</label>
                            <div class="col-md-6">
                                {{$item->code}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">Дисциплины</label>
                            <div class="col-md-6">
                                @foreach($item->disciplines as $d)
                                    {{$d->title}}
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
