@extends('layouts.master')

@section('title')Сотрудники@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Сотрудники</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm" href="/college/teachers/create"><i class="fa fa-plus"></i> Добавить сотрудника</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ФИО</th>
                                    <th>E-mail</th>
                                    <th>Телефон</th>
                                    @if(count(getSubdivisions(Auth::user()->college_id)) > 0)
                                        <th>Подразделение</th>
                                    @endif
                                    <th>Модули</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->last_name}} {{$item->first_name}} {{$item->middle_name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->phone}}</td>
                                        @if(count(getSubdivisions(Auth::user()->college_id)) > 0)
                                            <td>
                                                @if(!empty($item->subdivision))
                                                    {{$item->subdivision->title}}
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @foreach($item->access as $level)
                                                {{$level->desc}}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            <a href="/college/teachers/{{$item->id}}/edit" class="btn btn-info btn-sm">Редактировать</a>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" href="#modal-{{$item->id}}">Удалить</a>
                                            <div class="modal fade" id="modal-{{$item->id}}">
                                            	<div class="modal-dialog">
                                            		<form class="modal-content" method="post" action="/college/teachers/{{$item->id}}">
                                                        {!! method_field('DELETE') !!}
                                                        {!! csrf_field() !!}
                                            			<div class="modal-header">
                                            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            				<h4 class="modal-title text-left">Удаление сотрудника</h4>
                                            			</div>
                                            			<div class="modal-body text-left">
                                            				Удалить сотрудника {{$item->name}}?
                                            			</div>
                                            			<div class="modal-footer">
                                            				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                            				<button type="submit" class="btn btn-danger">Удалить</button>
                                            			</div>
                                            		</form>
                                            	</div>
                                            </div>
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
@endsection
