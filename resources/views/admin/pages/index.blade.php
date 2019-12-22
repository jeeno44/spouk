@extends('admin.layouts.master')

@section('title')
    Страницы
@stop

@section('content')
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="block-title">Страницы</h3>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter">
                <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">ID</th>
                    <th class="text-center">Название</th>
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
                            {{$item->name}}
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/pages/{{$item->id}}/edit" data-toggle="tooltip" class="btn btn-default" data-original-title="Правка">
                                    <i class="fa fa-pencil text-primary"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <nav class="text-right">
                {!! $items->render() !!}
            </nav>
        </div>
    </div>
@stop