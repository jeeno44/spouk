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
                                <li>
                                    <a href="/export/kcp">
                                        <i class="fa fa-file-excel-o"></i>
                                        Сформировать "Журнал выполнения КЦП"
                                    </a>
                                </li>
                                <li>
                                    <a href="/export/list">
                                        <i class="fa fa-file-excel-o"></i>
                                        Сформировать "Журнал регистрации абитуриентов"
                                    </a>
                                </li>
                                <li>
                                    <a href="#modal-id" class="export-rate" data-toggle="modal">
                                        <i class="fa fa-file-excel-o"></i>
                                        Сформировать рейтинг по специальностям / профессиям
                                    </a>
                                </li>
                                <li>
                                    <a href="/export/all-abirs" class="export-rate">
                                        <i class="fa fa-file-excel-o"></i>
                                        Выгрузка всех абитуриентов
                                    </a>
                                </li>
                                <li>
                                    <a href="/export/region-abirs" class="export-rate">
                                        <i class="fa fa-file-excel-o"></i>
                                        Региональное распределение абитуриентов
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['url' => '/export/rate']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Сформировать рейтинг по специальностям / профессиям</h4>
                    </div>
                    <div class="modal-body">
                        <label>Выберите специальность</label>
                        <select name="spec_id" class="form-control">
                            @foreach($specs as $spec)
                                <option value="{{$spec->id}}">{{$spec->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сформировать</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
