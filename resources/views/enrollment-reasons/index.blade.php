@extends('layouts.master')

@section('title')Причины зачисления@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Причины зачисления</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm" href="/dic/enrollment-reasons/create"><i class="fa fa-plus"></i> Добавить причину</a>
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
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td class="text-right">

                                            @if($item->college_id == Auth::user()->college_id)
                                                <a href="/dic/enrollment-reasons/{{$item->id}}/edit" class="btn btn-info btn-sm">Редактировать</a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" href="#modal-{{$item->id}}">Удалить</a>
                                            <div class="modal fade" id="modal-{{$item->id}}">
                                            	<div class="modal-dialog">
                                            		<form class="modal-content" method="post" action="/dic/enrollment-reasons/{{$item->id}}">
                                                        {!! method_field('DELETE') !!}
                                                        {!! csrf_field() !!}
                                            			<div class="modal-header">
                                            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            				<h4 class="modal-title text-left">Удаление причины</h4>
                                            			</div>
                                            			<div class="modal-body text-left">
                                            				Удалить причину {{$item->title}}?
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
