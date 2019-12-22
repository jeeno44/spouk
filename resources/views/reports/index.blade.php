@extends('layouts.master')

@section('title')Отчеты@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Отчеты</h3>
                            <ul class="list list-simple">
                                @if(count($listGroups) > 0)
                                <li>
                                    <a href="{{ url('reports-group') }}">
                                        <i class="fa fa-file-excel-o"></i>
                                        Выгрузка данных по поступившим
                                    </a>
                                </li>
                                @else
                                    <li>
                                        <span style="color: silver">
                                            <i class="fa fa-file-excel-o"></i>
                                            Выгрузка данных по поступившим (нет поступивших студентов)
                                        </span>
                                    </li>
                                @endif
                                @if(count($candidates) > 0)
                                        <li>
                                            <a href="{{ url('reports-abirs') }}">
                                                <i class="fa fa-file-excel-o"></i>
                                                Выгрузка данных по абитуриентам
                                            </a>
                                        </li>
                                @else
                                        <li>
                                        <span style="color: silver">
                                            <i class="fa fa-file-excel-o"></i>
                                            Выгрузка данных по абитуриентам (нет абитуриентов)
                                        </span>
                                        </li>
                                @endif
                                <li>
                                    <a href="#setGroup" data-toggle="modal">
                                        <i class="fa fa-file-excel-o"></i>
                                        Состав группы
                                    </a>
                                </li>

                                <li>
                                    <a href="#setParent" data-toggle="modal">
                                        <i class="fa fa-file-excel-o"></i>
                                        Родители
                                    </a>
                                </li>

                                <li>
                                    @if(count($listGroupsRecruits) > 0)
                                        <a href="{{ url('reports-recruits') }}">
                                            <i class="fa fa-file-excel-o"></i>
                                            Призывники
                                        </a>
                                    @else
                                        <span style="color: silver">
                                            <i class="fa fa-file-excel-o"></i>
                                            Призывники (нет зачисленных студентов)
                                        </span>
                                    @endif
                                </li>

                                <li>
                                    <a href="{{ url('/export/spo-1') }}">
                                        <i class="fa fa-file-excel-o"></i>
                                        Форма №СПО-1
                                    </a>
                                </li>

                                 <li>
                                    <a href="{{ url('') }}">
                                        <i class="fa fa-file-excel-o"></i>
                                        Запросы на справку по стипендии
                                    </a>
                                </li>

                                    <li>
                                        <a href="{{ url('/export/journal/rec-book') }}">
                                            <i class="fa fa-file-excel-o"></i>
                                            Журнал выдачи зачетных книжек
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/export/journal/sid') }}">
                                            <i class="fa fa-file-excel-o"></i>
                                            Журнал выдачи студенческих билетов
                                        </a>
                                    </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Состав группы  -->
<div class="modal fade" id="setGroup" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form method="POST" class="formSpec" action="{{ url('group-student-single') }}">
            {!! Form::token() !!}
            <input type="hidden" value="" name="actionID" />
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Сформировать состав студентов по группе</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Укажите группу</label>
                        <select class='form-control' name="listGroups" id="idListGroupsSelect">
                            @foreach($listGroups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-default checkProtContinue">Продолжить</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Родители  -->
 <div class="modal fade" id="setParent" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form method="POST" class="formSpec" action="{{ url('group-student-parent') }}">
            {!! Form::token() !!}
            <input type="hidden" value="" name="actionID" />
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Состав студентов и родителей по группе</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Укажите группу</label>
                        <select class='form-control' name="listGroups" id="idListGroupsSelect">
                            @foreach($listGroups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-default checkProtContinue">Продолжить</button>
                </div>
            </div>
        </form>
    </div>
</div>