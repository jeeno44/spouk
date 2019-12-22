@extends('layouts.master')

@section('title')Группы@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Группы</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm" href="/dec/groups/create"><i class="fa fa-plus"></i> Добавить группу</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Код</th>
                                    <th>Семестр</th>
                                    <th>Курс</th>
                                    <th>Специальность</th>
                                    <th>Куратор</th>
                                    <th>Год</th>
                                    <th>Бюджетных мест</th>
                                    <th>Внебюджетных мест</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->code}}</td>

                                        <td>{{$item->semester_id}}</td>
                                        <td>{{$item->course   == null ? '' : $item->course->title  }}</td>


                                        <td>{{$item->specialization->title}}</td>
                                        <td>
                                            {{ $item->teacher == null ? '' : $item->teacher->last_name.' '.$item->teacher->first_name }}
                                        </td>
                                        <td>{{$item->year}}</td>
                                        <td>{{$item->free_places}}</td>
                                        <td>{{$item->non_free_places}}</td>
                                        <td class="text-right">
                                            <a href="/dec/groups/{{$item->id}}/edit" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" href="#modal-{{$item->id}}"><i class="fa fa-times"></i></a>
                                            <div class="modal fade" id="modal-{{$item->id}}">
                                            	<div class="modal-dialog">
                                            		<form class="modal-content" method="post" action="/dec/groups/{{$item->id}}">
                                                        {!! method_field('DELETE') !!}
                                                        {!! csrf_field() !!}
                                            			<div class="modal-header">
                                            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            				<h4 class="modal-title text-left">Удаление группы</h4>
                                            			</div>
                                            			<div class="modal-body text-left">
                                            				Удалить группу {{$item->email}}?
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
