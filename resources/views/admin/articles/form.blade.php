@extends('admin.layouts.master')

@section('title')
    Новости
@stop

@section('content')
    @if (!empty($item))
        {!! Form::model($item, ['route' => ['admin.articles.update', 'id' => $item->id], 'method' => 'put', 'class' => 'js-validation-bootstrap', 'enctype' => 'multipart/form-data']) !!}
    @else
        {!! Form::open(['route' => 'admin.articles.store', 'class' => 'js-validation-bootstrap', 'enctype' => 'multipart/form-data']) !!}
    @endif
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="block-title">{{$title}}</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-arrow-left"></i>&nbsp;Назад</a>
                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="form-horizontal">

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Название *</label>
                    <div class="col-xs-6">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Картинка</label>
                    <div class="col-xs-6">
                        @if(!empty($item->image))
                            <div>
                                <img src="/uploads/images/{{$item->image}}" class="img img-rounded" style="max-height: 180px;">
                            </div>
                            <br>
                            {!! Form::file('image') !!}
                        @else
                            {!! Form::file('image') !!}
                        @endif
                    </div>
                </div>

                @if(!empty($item) && !empty($item->date))
                    <div class="form-group">
                        <label class="col-xs-2 text-right" for="example-text-input">Дата *</label>
                        <div class="col-xs-6">
                            {!! Form::text('timestamp', date('d.m.Y H:i', $item->date), ['class' => 'form-control datepicker', 'required']) !!}
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <label class="col-xs-2 text-right" for="example-text-input">Дата *</label>
                        <div class="col-xs-6">
                            {!! Form::text('timestamp', date('d.m.Y H:i'), ['class' => 'form-control datepicker', 'required']) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Краткое описание</label>
                    <div class="col-xs-9">
                        {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Контент</label>
                    <div class="col-xs-9">
                        {!! Form::textarea('content', null, ['class' => 'form-control editor']) !!}
                    </div>
                </div>

            </div>

        </div>
        <div class="block-header bg-gray-lighter">
            <div class="text-right">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-arrow-left"></i>&nbsp;Назад</a>
                <button class="btn btn-success" type="submit"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop