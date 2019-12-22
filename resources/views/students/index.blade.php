@extends('layouts.master')

@section('title')Студенты@stop

@section('content')
<div id="filter" class="card" style="">
    <div class="card-body style-default-light">
        <div class="row">
            <div class="pull-left col-md-6">
            </div>
            <form class="form col-md-3 pull-right">
                <div class="form-group">
                    {!! Form::select('specs', getGroups(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                    <label>Фильтровать по группе</label>
                </div>
            </form>
        </div>
    </div>
</div>
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Студенты</div>
                                <div class="pull-right">
                                    <a class="btn btn-success btn-sm" href="/dec/students/create"><i class="fa fa-plus"></i> Добавить студента</a>
                                </div>
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
                                    <th>Поименной номер</th>
                                    <th>
                                        ФИО&nbsp;
                                        <a class="sort-link" href="#" data-filter="FIO" data-how="asc"><i class="fa fa-chevron-up"></i> </a>
                                        <a class="sort-link" href="#" data-filter="FIO" data-how="desc"><i class="fa fa-chevron-down"></i> </a>
                                    </th>
                                    <th>
                                        Дата рождения&nbsp;
                                        <a class="sort-link" href="#" data-filter="AGE" data-how="asc"><i class="fa fa-chevron-up"></i> </a>
                                        <a class="sort-link" href="#" data-filter="AGE" data-how="desc"><i class="fa fa-chevron-down"></i> </a>
                                    </th>
                                    <th>Телефоны</th>
                                    <th>Рейтинг&nbsp;
                                        <a class="sort-link" href="#" data-filter="RATE" data-how="asc"><i class="fa fa-chevron-up"></i> </a>
                                        <a class="sort-link" href="#" data-filter="RATE" data-how="desc" style="display: none"><i class="fa fa-chevron-down"></i> </a>
                                    </th>
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
