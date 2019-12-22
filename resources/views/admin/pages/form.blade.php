@extends('admin.layouts.master')

@section('title')
    Страницы
@stop

@section('content')
    @if (!empty($item))
        {!! Form::model($item, ['route' => ['admin.pages.update', 'id' => $item->id], 'method' => 'put', 'class' => 'js-validation-bootstrap']) !!}
    @else
        {!! Form::open(['route' => 'admin.pages.store', 'class' => 'js-validation-bootstrap']) !!}
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
                    <label class="col-xs-2 text-right" for="example-text-input">Название</label>
                    <div class="col-xs-6">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">URL</label>
                    <div class="col-xs-6">
                        {!! Form::text('slug', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Контент</label>
                    <div class="col-xs-9">
                        {!! Form::textarea('content', null, ['class' => 'form-control editor']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">meta title</label>
                    <div class="col-xs-6">
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">meta description</label>
                    <div class="col-xs-6">
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">meta keywords</label>
                    <div class="col-xs-6">
                        {!! Form::text('keywords', null, ['class' => 'form-control js-tags-input']) !!}
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