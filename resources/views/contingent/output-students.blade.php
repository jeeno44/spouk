@extends('layouts.master')

@section('title')Список студентов - отчисление и выпуск@stop

@section('content')
    <section>
        <form method="POST" class="formSpec" action="{{ url('dec/pre-move-download') }}">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Cтуденты ({{ count($listStudent) }}  ) группы {{ $group->title }}</div>

                                    <div class="pull-right">
									    <button type="button" class="btn btn-success btn-move-contingent" disabled>Сформировать</button>
                                    </div>

                                    <div class="pull-right" style="margin-right: 20px;">
                                        <select id="selectActionType" class="form-control" required name="type">
                                            <option value="">Выберите действие</option>
                                            <option value="output">Выпустить</option>
                                            <option value="deduct">Отчислить</option>
                                            <option value="move">Перевести</option>
                                            <option value="disposal">Оформить выбытие</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="moveProtocol" tabindex="-1" role="dialog">
                            <div class="modal-dialog">

                                    {!! Form::token() !!}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Сформировать приказ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Номер приказа</label>
                                                {!! Form::text('protocol_number', null, ['class' => 'form-control', 'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label>Дата приказа</label>
                                                {!! Form::text('protocol_date', date('d.m.Y'), ['class' => 'form-control datepicker', 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-default btn-set-output">Продолжить</button>
                                        </div>
                                    </div><!-- /.modal-content -->

                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <div class="panel-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">
                                         <label>
											<input id="cbAllStudent" type="checkbox">
										</label>
                                    </th>

                                    <th>
										Ф.И.О. студента
                                    </th>
                                    <th>Дата рождения</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($listStudent as $student)
                                        <tr>
                                            <td>
                                                <label>
											        <input value="{{ $student->id }}" class="cb-move-student" type="checkbox" name="students[]">
										        </label>

                                            </td>

                                            <td>
											    {{ $student->last_name.' '.$student->first_name }}
                                            </td>

                                            <td> {{ datetime('d.m.Y', $student->birth_date) }} </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
@endsection
