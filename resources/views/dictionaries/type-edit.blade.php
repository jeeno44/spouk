@extends('layouts.master')

@section('title')Редактировать справочник@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @if(\Auth::user()->hasRole('admin'))

                    {!! Form::model($item, ['method' => 'post', 'url' => '/dic-type/update/'.$item->id, 'class' => 'panel panel-default']) !!}
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Редактирование справочника </div>
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
                            <label class="col-md-2 control-label">Наименование</label>
                            <div class="col-md-6">
                                {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
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
                                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
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
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">{{ $item->title }}</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm" href="#dicCreate" data-toggle="modal"><i class="fa fa-plus"></i>Добавить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Код</th>
                                    <th>Наименование</th>
                                    <th>Значение</th>

                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listDirectories as $directory)
                                    <tr>
                                        <td>{{$directory->id}}</td>
                                        <td>{{$directory->slug}}</td>
                                        <td>{{$directory->title}}</td>
                                        <td>{{$directory->value}}</td>

                                        <td class="text-right">
                                            @if (($directory->college_id != 0) ||  (\Auth::user()->hasRole('admin') && $directory->college_id == 0 ))
                                                <a href="#dicEdit-{{ $directory->id }}" data-toggle="modal" class="btn btn-info btn-sm">Редактировать</a>
                                                <div class="modal fade" id="dicEdit-{{ $directory->id }}">
                                                    <div class="modal-dialog">
                                                        <form method="POST" class="modal-content" action="{{ url('dic/update/'.$directory->id) }}">
                                                            {!! Form::token() !!}
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title">Редактирование значения</h4>
                                                                </div>

                                                                <input type="hidden" name="slug_type"  value="{{ $item->slug }}">

                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label class="">Укажите наименование</label>
                                                                        <input type="text" class="form-control" name="dictionary_title" required value="{{ $directory->title }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="">Укажите значение (необязательно)</label>
                                                                        <input type="text" class="form-control" name="dictionary_value" value="{{ $directory->value }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="">Укажите код (необязательно)</label>
                                                                        <input type="text" class="form-control" name="dictionary_slug" value="{{ $directory->slug }}">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                                    <button type="submit" class="btn btn-info">Сохранить</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (($directory->college_id != 0) ||  (\Auth::user()->hasRole('admin') && $directory->college_id == 0 ))
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" href="#modal-{{$directory->id}}">Удалить</a>
                                                <div class="modal fade" id="modal-{{$directory->id}}">
                                                    <div class="modal-dialog">
                                                        <form class="modal-content" method="post" action="{{ url('/dic/delete/'.$directory->id) }}">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="slug_type"  value="{{ $item->slug }}">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title text-left">Удалить справочник</h4>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                Удалить значение <b> {{$directory->title}} </b> из справочника?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="dicCreate" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <form method="POST" class="formSpec" action="{{ url('dic/store') }}">
                {!! Form::token() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Добавление в справочник</h4>
                    </div>
                    <input type="hidden" name="type_id"  value="{{ $item->id }}">
                    <input type="hidden" name="slug_type"  value="{{ $item->slug }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Укажите наименование</label>
                            <input type="text" class="form-control" name="dictionary_title" required>
                        </div>

                         <div class="form-group">
                            <label>Укажите значение (необязательно)</label>
                            <input type="text" class="form-control" name="dictionary_value" >
                        </div>

                        <div class="form-group">
                            <label>Укажите код (необязательно)</label>
                            <input type="text" class="form-control" name="dictionary_slug" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection



