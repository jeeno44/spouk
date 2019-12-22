@extends('layouts.master')

@section('title')Абитуриенты@stop

@section('content')
<div id="filter" class="card" style="">
    <div class="card-body style-default-light">
        <div class="row">
            <div class="pull-left col-md-6">

                <div class="modal fade" id="setDocument">
                    <div class="modal-dialog">
                        <form method="POST" class="formSpec" action="/candidates/filterSpecialization">
                            {!! Form::token() !!}
                            <input type="hidden" value="" name="actionID" />
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Выберите специальность</h4>
                                </div>
                                <div class="modal-body">
                                    {!! Form::select('specID', getSpecializations(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-default checkSpecsContinue">Продолжить</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade" id="selectSpecs">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Не выбрана специальность</h4>
                            </div>
                            <div class="modal-body">
                                Укажите специальность
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ОК</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
            <form class="form col-md-3 pull-right">
                <div class="form-group">
                    {!! Form::select('specs', getSpecializations(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                    <label>Фильтровать по специальности</label>
                </div>
            </form>
            @if(count(getSubdivisions(Auth::user()->college_id)) > 1)
            <form class="form col-md-3 pull-right">
                <div class="form-group">
                    {!! Form::select('subdivs', getSubdivisions(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                    <label>Фильтровать по подразделению</label>
                </div>
            </form>
            @endif
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
                                <div class="pull-left">Абитуриенты</div>
                                <div class="pull-right">
                                    <a class="btn btn-success btn-sm" href="/enroll/candidates/create"><i class="fa fa-plus"></i> Добавить Абитуриента</a>
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
                                    <th>Специальности</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody id="dynamicLoadDataTableCandidates">
                                @include('candidates.ajaxCandidates')
                            </tbody>
                        </table>
                        {!! csrf_field() !!}
                        <div align="center">
                            @if (!empty($candidates->render()))
                            <div class="paginationAjax">
                                {{$candidates->render()}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Абитуриенты, забравшие документы</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Рег. номер</th>
                                <th>ФИО</th>
                                <th>Забрал документы</th>
                                <th>Телефоны</th>
                                <th>Рейтинг</th>
                                <th>Специальности</th>
                                <th class="text-right">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($offCandidates as $candidate)
                                <tr>
                                    <td @if(!empty($candidate->is_invalid1)) style="border-left: 3px solid #d4fad6;" @endif>#{{$candidate->reg_number}}</td>
                                    <td>
                                        <a href="/enroll/candidates/{{$candidate->id}}">{{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}
                                        </a></td>
                                    <td style="text-align: left;">{{date('d.m.Y', strtotime($candidate->date_took))}}</td>
                                    <td>
                                        @foreach ($candidate->phones()->orderBy('id', 'desc')->get() as $phone)
                                            <a href="tel:{{$phone->phone}}" style="display: inline-block;">{{$phone->phone}}</a>
                                            @break
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$candidate->gpa}} ({{$candidate->rate}})
                                    </td>
                                    <td>
                                        @if(!empty($candidate->spec->title))
                                            {{$candidate->spec->code}} - {{$candidate->spec->title}}
                                            @if($candidate->specializations->count() > 0)
                                                и {{$candidate->specializations->count()}} {{trans_choice('phrases.dops', $candidate->specializations->count())}}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-warning btn-sm" data-toggle="modal" href="#modal-{{$candidate->id}}"><i class="fa fa-times"></i> </a>
                                        <div class="modal fade" id="modal-{{$candidate->id}}">
                                            <div class="modal-dialog">
                                                <form class="modal-content" method="post" action="/enroll/candidates/{{$candidate->id}}">
                                                    {!! method_field('DELETE') !!}
                                                    {!! csrf_field() !!}
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title text-left">Удалить абитуриента</h4>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Удалить абитуриента {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                        <button type="submit" class="btn btn-primary">Удалить</button>
                                                    </div>
                                                </form><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
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
