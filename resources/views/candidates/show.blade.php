@extends('layouts.master')
@section('title'){{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}@stop
@section('content')
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <form class="panel panel-default form-validate" enctype="multipart/form-data" method="post" action="/enroll/candidates">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">{{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}</div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-2 control-label">ФИО:</label>
                            <div class="col-md-6">
                                {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Дата рождения:</label>
                            <div class="col-md-3 date">
                                {{date('d.m.Y', strtotime($candidate->birth_date))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Аттестат №:</label>
                            <div class="col-md-3 date">
                                {{$candidate->certificate}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Получил образование:</label>
                            <div class="col-md-3 date">
                                {{$candidate->educationType->title}}
                            </div>
                        </div>
                        @if(!empty($candidate->school))
                            <div class="form-group">
                                <label class="col-md-2 control-label">Школа:</label>
                                <div class="col-md-6">
                                    {{$candidate->school->title}}, {{$candidate->school->city->title}}, {{$candidate->school->region->title}}
                                </div>
                            </div>
                        @endif
                         <div class="form-group">
                            <label class="col-md-2 control-label">Рейтинг</label>
                            <div class="col-md-6">
                                {{$candidate->rate}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Средний балл</label>
                            <div class="col-md-6">
                                {{$candidate->gpa}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Окончил(а) классов:</label>
                            <div class="col-md-6">
                                {{$candidate->graduatedClass}} в {{$candidate->graduatedYear}} г.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Поступает в колледж в:</label>
                            <div class="col-md-6">
                                {{$candidate->admissionYear}} г.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Адрес проживания:</label>
                            <div class="col-md-6">
                                {{$candidate->region->title}}, {{$candidate->city->title}}, {{$candidate->address}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Телефоны:</label>
                            <div class="col-md-6">
                                @foreach ($candidate->phones()->orderBy('id', 'desc')->get() as $phone)
                                    <a href="tel:{{$phone->phone}}" style="display: inline-block;">{{$phone->phone}}</a> ({{$phone->pcomment}})<br>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">e-mail</label>
                            <div class="col-md-6">
                                {{$candidate->email}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Поступает на специальности</label>
                            <div class="col-md-6">
                                @foreach($candidate->specializations as $spec)
                                    {{$spec->code}} {{$spec->title}}<br>
                                @endforeach
                            </div>
                        </div>
                        
                        @if(!empty($candidate->is_invalid))
                            <div class="form-group">
                                <label class="col-md-2 control-label">Причина инвалидности</label>
                                <div class="col-md-6">
                                    {{$candidate->is_invalid}}
                                </div>
                            </div>
                        @endif
                        
                        @if($candidate->docs()->count() > 0)
                            <div class="form-group">
                                <label class="col-md-2 control-label">Документы</label>
                                <div class="col-md-8">
                                    @foreach($candidate->docs as $doc)
                                        <a href="/file/doc/{{$doc->id}}" style="display: inline-block;">{{$doc->filename}}</a> ({{$doc->fcomment}})<br>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
