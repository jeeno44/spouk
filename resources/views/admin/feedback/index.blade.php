@extends('admin.layouts.master')

@section('title')
    Письма
@stop

@section('content')
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="block-title">Письма</h3>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter">
                <thead>
                <tr>
                    <th >Имя</th>
                    <th >Емайл</th>
                    <th >Текст</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td >
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->email}}
                        </td>
                        <td >
                            {{$item->text}}
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