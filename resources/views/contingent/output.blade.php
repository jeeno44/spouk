@extends('layouts.master')

@section('title')Отчисление и выпуск@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Отчисление и выпуск</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Код</th>
                                    <th>Группа</th>
                                    <th class="text-right">Кол-во студентов</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($listGroup as $group)
                                        <tr>
                                            <td> {{ $group->code }} </td>

                                            <td>
                                                <a href="{{ url('dec/output-students/'.$group->id) }}">
                                                    {{ $group->title }}
                                                </a>
                                            </td>

                                            <td class="text-right"> {{ $group->students()->count() }} </td>
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
