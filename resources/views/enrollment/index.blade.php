@extends('layouts.master')

@section('title')Зачисление@stop

@section('content')
<div id="filter" class="card" style="">
    <div class="card-body style-default-light">
        <div class="row">
            <div class="pull-left col-md-2">
                <a href="#setProtocol" class="btn btn-default btn-xs" data-toggle="modal">Сформировать протокол</a>
                <a href="#setOrder" class="btn btn-default btn-xs" data-toggle="modal">Сформировать приказ</a>
                <a class="btn btn-primary btn-xs approve-order" data-toggle="modal" href="#modal-id" @if(empty($notApprovedOrder)) style="display: none" @endif>Утвердить приказ</a>
                <div class="modal fade" id="setProtocol" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <form method="POST" class="formSpec" action="/enroll/protocol">
                            {!! Form::token() !!}
                            <input type="hidden" value="" name="actionID" />
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Сформировать протокол работы приемной комиссии</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Номер протокола</label>
                                        {!! Form::text('protocol_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Дата протокола</label>
                                        {!! Form::text('protocol_date', date('d.m.Y'), ['class' => 'form-control datepicker', 'required']) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-default checkProtContinue">Продолжить</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade" id="setOrder" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <form method="POST" class="formSpec" action="/enroll/order">
                            {!! Form::token() !!}
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Сформировать приказ о зачислении</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Номер приказа</label>
                                        {!! Form::text('order_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Дата приказа</label>
                                        {!! Form::text('order_date', date('d.m.Y'), ['class' => 'form-control datepicker', 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Дата протокола</label>
                                        {!! Form::text('protocol_date', date('d.m.Y'), ['class' => 'form-control datepicker', 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Дата зачисления</label>
                                        {!! Form::text('enroll_date', date('d.m.Y'), ['class' => 'form-control datepicker', 'required']) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-default checkOrContinue">Продолжить</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="modal fade" id="modal-id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Утвердить приказ</h4>
                            </div>
                            <div class="modal-body">
                                Утвердить приказ о зачислении и перевести указанных абитуриентов в студенты?
                                Данное действие не может быть отменено.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <a class="btn btn-primary" href="/enroll/approve">Утвердить</a>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
            <div class="col-md-10 enroll-filter">
                <div class="form col-md-2">
                    <div class="form-group">
                        {!! Form::select('specialization_id', getSpecializations(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                        <label>Специальность</label>
                    </div>
                </div>
                <div class="form col-md-2">
                    <div class="form-group">
                        {!! Form::select('group_id', getFilterGroups(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                        <label>Группа</label>
                    </div>
                </div>
                <div class="form col-md-2">
                    <div class="form-group">
                        {!! Form::select('form_training', getFormTrainings(), null, ['class' => 'form-control']) !!}
                        <label>Форма обучения</label>
                    </div>
                </div>
                <div class="form col-md-2">
                    <div class="form-group">
                        {!! Form::select('monetary_basis', getMonetaryBasis(), null, ['class' => 'form-control']) !!}
                        <label>Форма финансирования</label>
                    </div>
                </div>
                <div class="form col-md-2">
                    <div class="form-group">
                        {!! Form::select('education_id', getEducationTypes(), null, ['class' => 'form-control']) !!}
                        <label>Тип образования</label>
                    </div>
                </div>
                <div class="form col-md-2">
                    <div class="form-group">
                        <select name="certificate_provided" class="form-control">
                            <option value="1">Предоставлены</option>
                            <option value="0">Не предоставлены</option>
                        </select>
                        <label>
                            Оригиналы документов
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section style="margin-bottom: -24px;">
    <div class="row">
        <div class="col-sm-8">
            <label>Группа</label>
            {!! Form::select('group', $groups, null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-4 text-right">
            <label style="display: block">&nbsp;</label>
            <button type="button" class="btn btn-success ava-btn enroll-btn" disabled>Зачислить в группу</button>
            <button type="button" class="btn btn-warning ava-btn disroll-btn" disabled>Исключить из группы</button>
        </div>
    </div>
</section>
<section style="padding-top: 0">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Абитуриенты к зачислению</div>
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
                        <table class="table no-margin abiturients">
                            <thead>
                                <tr>
                                    <th>
                                        {!! Form::checkbox('master', null, null, ['class' => 'master-check']) !!}
                                    </th>
                                    <th>Рег. номер</th>
                                    <th>ФИО</th>
                                    <th>Дата рождения</th>
                                    <th>Телефоны</th>
                                    <th>Рейтинг</th>
                                    <th>Специальности</th>
                                    <th>Группа</th>
                                </tr>
                            </thead>
                            <tbody id="tableEnrollCandidates">
                                @include('enrollment.ajaxCandidates')
                            </tbody>
                        </table>
                        {!! csrf_field() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
