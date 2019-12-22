@extends('layouts.master')

@section('title')Абитуриенты@stop

@section('content')
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{$actionID['action']}}" @if (\Request::get('actionID') == 2)id="generateOrder" @endif method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Абитуриенты</div>
                                    <div class="pull-right form-inline">
                                        <a class="btn btn-info btn-sm" href="/candidates"><i class="fa fa-backward"></i>&nbsp;Назад</a>
                                        @if (\Request::get('actionID') == 2)
                                        {!! Form::select('groupID', getGroupsSpec(Auth::user()->college_id, \Request::get('specID')), null, ['class' => 'form-control selectGroup']) !!}
                                        @endif
                                        <button type="submit" class=" btn btn-success btn-sm"><i class="fa fa-download"></i>&nbsp;{{$actionID['name']}}</button>
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
                            @if (\Request::get('actionID') == 2)
                            <div style="width: 500px;">
                                <div class="form-group">
                                    <label class="control-label">Дата приказа</label>
                                    <div>
                                        <div class="input-group">
                                            <div class="input-group-content">
                                                {!! Form::text('date', old('date') ? old('date_of_filing') : date("d.m.Y"), ['class' => 'form-control js-datepicker', 'required']) !!}
                                                <span class="help-block" style="display: none;"></span>
                                            </div>
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Номер приказа</label>
                                    {!! Form::text('number_order', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            @endif 
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Рег. номер</th>
                                        <th>
                                            ФИО
                                        </th>
                                        <th>
                                            Дата рождения
                                        </th>
                                        <th>Телефоны</th>
                                        <th>Рейтинг
                                        </th>
                                        <th>Специальности</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidates as $candidate)
                                    <tr>
                                        <td><input type="checkbox" value="{{$candidate->id}}" name="candidates[]" /></td>
                                        <td @if(!empty($candidate->is_invalid1)) style="border-left: 3px solid #d4fad6;" @endif>#{{$candidate->reg_number}}</td>
                                        <td><a href="/candidates/{{$candidate->id}}">{{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}</a></td>
                                        <td style="text-align: left;">{{date('d.m.Y', strtotime($candidate->birth_date))}} ({{$candidate->age}})</td>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" name="specID" value="{{\Request::get('specID')}}" />
                            {!! csrf_field() !!}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="selectGroup">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Не выбрана группа или дата указ</h4>
                        </div>
                        <div class="modal-body">
                            Укажите группу
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">ОК</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
</section>
@endsection
