@extends('admin.layouts.master')

@section('title')
    Баннеры
@stop

@section('content')
    @if (!empty($item))
        {!! Form::model($item, ['route' => ['admin.banners.update', 'id' => $item->id], 'method' => 'put', 'class' => 'js-validation-bootstrap', 'enctype' => 'multipart/form-data']) !!}
    @else
        {!! Form::open(['route' => 'admin.banners.store', 'class' => 'js-validation-bootstrap', 'enctype' => 'multipart/form-data']) !!}
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
                    <label class="col-xs-2 text-right" for="example-text-input">Ссылка</label>
                    <div class="col-xs-6">
                        {!! Form::text('link', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Изображение для баннера</label>
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

                <div class="form-group">
                    <label class="col-xs-2 text-right" for="example-text-input">Текст</label>
                    <div class="col-xs-9">
                        {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
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