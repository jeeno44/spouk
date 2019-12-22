@extends('layouts.master')

@section('title')Учебные планы@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Учебные планы</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm" href="/training/plans/create"><i class="fa fa-plus"></i> Добавить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Наименование</th>
                                    <th>Дата утверждения</th>
                                    <th>Дата создания</th>
                                    <th>Год</th>
                                    <th>Статус</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><a href="/training/plans/{{$item->id}}" data-toggle="tooltip" title="Редактировать дисциплины">{{$item->title}}</a> </td>
                                        <td>{{$item->approved_date}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->year}}</td>
                                        <td>{{$item->status->title}}</td>
                                        <td class="text-right">
                                            <a href="/training/plans/{{$item->id}}/edit" class="btn btn-info btn-sm">Редактировать</a>
                                            @if($item->college_id == Auth::user()->college_id)
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" href="#modal-{{$item->id}}">Удалить</a>
                                            <div class="modal fade" id="modal-{{$item->id}}">
                                            	<div class="modal-dialog">
                                            		<form class="modal-content" method="post" action="/training/plans/{{$item->id}}">
                                                        {!! method_field('DELETE') !!}
                                                        {!! csrf_field() !!}
                                            			<div class="modal-header">
                                            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            				<h4 class="modal-title text-left">Удаление кафедры</h4>
                                            			</div>
                                            			<div class="modal-body text-left">
                                            				Удалить кафедру {{$item->title}}?
                                            			</div>
                                            			<div class="modal-footer">
                                            				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                            				<button type="submit" class="btn btn-danger">Удалить</button>
                                            			</div>
                                            		</form>
                                            	</div>
                                            </div>
                                        </td>
                                        @endif
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