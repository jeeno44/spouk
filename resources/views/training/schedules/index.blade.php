@extends('layouts.master')

@section('title')Расписание занятий@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Расписание занятий</div>
                                    <div class="pull-right">


                                        <a class="btn btn-success btn-sm" data-toggle="modal" href="#create" id="add"><i class="fa fa-plus"></i> Добавить</a>

                                        <div class="modal fade" id="create">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="" method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                                        <h4 class="modal-title">Добавить дисциплину к расписанию</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="">Дата и время:</label>
                                                            {!! Form::text('date',null,['class'=>'form-control', 'id' => 'dtp_1']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Дисциплина:</label>
                                                            {!! Form::select('discipline_id',disciplines($educationSystemId),null,['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Курс:</label>
                                                            {!! Form::select('course_id',courses($educationSystemId),null,['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Семестр:</label>
                                                            {!! Form::select('semester_id', [1 => 1, 2 => 2],null,['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Тип занятия:</label>
                                                            {!! Form::select('hour_type_id', hourTypes(), null, ['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Аудитория:</label>
                                                            {!! Form::select('hall_id', halls($educationSystemId), null, ['class'=>'form-control']) !!}
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                        <button type="button" class="btn btn-primary" id="send">Сохранить</button>
                                                    </div>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <div class="modal fade" id="edit">
                                            <div class="modal-dialog">
                                                <form class="modal-content" action="" method="post">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                                                        <h4 class="modal-title">Редактировать дисциплину</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="" id="event_id">
                                                        <div class="form-group">
                                                            <label for="">Дата и время:</label>
                                                            {!! Form::text('date', null, ['class'=>'form-control', 'id' => 'dtp_2']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Дисциплина:</label>
                                                            {!! Form::select('discipline_id', disciplines($educationSystemId), null, ['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Курс:</label>
                                                            {!! Form::select('course_id', courses($educationSystemId), null ,['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Семестр:</label>
                                                            {!! Form::select('semester_id', [1 => 1, 2 => 2],null,['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Тип занятия:</label>
                                                            {!! Form::select('hour_type_id', hourTypes(), null, ['class'=>'form-control']) !!}
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Аудитория:</label>
                                                            {!! Form::select('hall_id', halls($educationSystemId), null, ['class'=>'form-control']) !!}
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                        <button type="button" class="btn btn-primary" id="update">Сохранить</button>
                                                        <button type="button" class="btn btn-danger" id="remove" data-id="">Удалить дисциплину</button>
                                                    </div>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="cont">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
