@extends('layouts.master')

@section('title')Дисциплины@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <form class="col-lg-12" method="post" action="">
                    {!! csrf_field() !!}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Дисциплины</div>
                                    <div class="pull-right">
                                        <a class="btn btn-success btn-sm add-disc" href="#"><i class="fa fa-plus"></i> Добавить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    Дисциплина
                                </div>
                                <div class="col-sm-1">
                                    Лекц.
                                </div>
                                <div class="col-sm-1">
                                    Лаб.
                                </div>
                                <div class="col-sm-1">
                                    Пр.
                                </div>
                                <div class="col-sm-1">
                                    СРС
                                </div>
                                <div class="col-sm-1">
                                    Контроль
                                </div>
                                <div class="col-sm-1">
                                    ЗЕТ
                                </div>
                                <div class="col-sm-1">
                                    Недель
                                </div>
                                <div class="col-sm-1">
                                    Контроль
                                </div>
                                <div class="col-sm-1">

                                </div>
                            </div>
                            <div class="discs-load">
                                @foreach($items as $item)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            {!! Form::select('disciplines[]', $disciplines, $item->discipline_id, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="lecture[]" value="{{$item->lecture_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="lab[]" value="{{$item->lab_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="practical[]" value="{{$item->practical_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="solo[]" value="{{$item->solo_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="exam[]" value="{{$item->exam_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="zet[]" value="{{$item->zet_hours}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="weeks[]" value="{{$item->weeks_count}}">
                                        </div>
                                        <div class="col-sm-1">
                                            {!! Form::select('controls[]', ['нет' => 'нет', 'экзамен' => 'экзамен', 'зачет' => 'зачет'], $item->control_type, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col-sm-1">
                                            <a class="btn btn-danger rem-disc-row btn-s pull-right" href="#"><i class="fa fa-times"></i> </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
