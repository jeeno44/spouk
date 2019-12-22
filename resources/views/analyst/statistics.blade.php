@extends('layouts.master')

@section('title')Статистика@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Регион</th>
                                    <th>Абитуриентов</th>
                                    <th>Специальностей</th>
                                    <th>Преподавателей</th>
                                    <th>Количество авторизаций в неделю</th>
                                    <th>Количество авторизаций всего</th>
                                    <th>Активировался</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statistics as $item)
                                    <tr >
                                        <td>{{$item['name'] }}</td>
                                        <td>{{$item['countCandidate'] }}</td>
                                        <td>{{$item['countSpecialization'] }}</td>
                                        <td>{{$item['countTeacher'] }}</td>
                                        <td>{{$item['countAuthWeek'] }}</td>
                                        <td>{{$item['countAuthTotal'] }}</td>
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
