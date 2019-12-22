@extends('layouts.master')

@section('title')Движение контингента@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Движение контингента</div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body" id="move-contingent">

                            @include('contingent.move-inner')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="next-sem-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Перевод на 2 семестр текущего курса</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Номер приказа</label>
                        <input type="text" class="form-control" id="sem-number">
                    </div>
                    <div class="form-group">
                        <label for="">Дата приказа</label>
                        <input type="text" class="form-control datepicker" id="sem-data">
                    </div>
                    Перевести выбранные группы на второй семестр?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary approve-next-sem">Перевести</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="next-course-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Перевод на следующий курс</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Номер приказа</label>
                        <input type="text" class="form-control" id="course-number">
                    </div>
                    <div class="form-group">
                        <label for="">Дата приказа</label>
                        <input type="text" class="form-control datepicker" id="course-data">
                    </div>
                    <div class="form-group">
                        <label for="">Группы</label>
                        <div id="code-groups"></div>
                    </div>
                    Перевести выбранные группы на следующий курс?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary approve-next-course">Перевести</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="out-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Выпускные группы</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Номер приказа</label>
                        <input type="text" class="form-control" id="out-number">
                    </div>
                    <div class="form-group">
                        <label for="">Дата приказа</label>
                        <input type="text" class="form-control datepicker" id="out-data">
                    </div>
                    Выпустить выбранные группы?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary approve-out">Выпустить</button>
                </div>
            </div>
        </div>
    </div>
@endsection
