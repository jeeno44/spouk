@extends('layouts.master')

@section('title')Отчисленные студенты@stop

@section('content')
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Отчисленные студенты</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('status') }}
                        </div>
                        @endif
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Рег. номер</th>
                                    <th>ФИО</th>
                                    <th>Дата рождения&nbsp</th>
                                    <th>Телефоны</th>
                                    <th>Рейтинг</th>
                                    <th>Группа</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody id="dynamicLoadDataTableStudents">
                                @include('students.ajax-students')
                            </tbody>
                        </table>
                        {!! csrf_field() !!}
                        <div align="center">
                            @if (!empty($students->render()))
                            <div class="paginationAjax">
                                {{$students->render()}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
