@extends('admin.layouts.master')

@section('title')
    Баннеры
@stop

@section('content')
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="block-title">Баннеры</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="/admin/banners/create/">
                        <i class="fa fa-plus"></i>&nbsp;Добавить баннер
                    </a>
                </div>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter">
                <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">ID</th>
                    <th class="text-left">Баннер</th>
                    <th class="text-right">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="text-center">
                            {{$item->id}}
                        </td>
                        <td class="hidden-xs">
                            <img src="/uploads/images/{{$item->image}}" height="100">
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/banners/{{$item->id}}/edit" data-toggle="tooltip" class="btn btn-default" data-original-title="Правка">
                                    <i class="fa fa-pencil text-primary"></i>
                                </a>
                                <a href="#remove{{$item->id}}" data-toggle="modal" class="btn btn-default"><i class="fa fa-times text-danger"></i></a>
                                <div class="modal fade" id="remove{{$item->id}}">
                                	<div class="modal-dialog">
                                		<form class="modal-content" action="/admin/banners/{{$item->id}}" method="post">
                                            {!! method_field('delete') !!}
                                            {!! csrf_field() !!}
                                			<div class="modal-header text-left">
                                				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                				<h4 class="modal-title">Удаление</h4>
                                			</div>
                                			<div class="modal-body text-left text-danger">
                                				Удалить баннер?
                                			</div>
                                			<div class="modal-footer">
                                				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                				<button type="submit" class="btn btn-danger">Удалить</button>
                                			</div>
                                		</form><!-- /.modal-content -->
                                	</div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop