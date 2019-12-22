@extends('layouts.master')
@section('title'){{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}@stop
@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="panel panel-default form-validate">
                        <div class="panel-body form-horizontal">
                            @if (count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger"><strong>{{ $error }}</strong></div>
                            @endforeach
                        @endif
                        <!-- TAB NAVIGATION -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Общие сведения</a></li>
                                <li><a href="#tab2" role="tab" data-toggle="tab">Документы</a></li>
                                <li><a href="#tab3" role="tab" data-toggle="tab">Родители</a></li>
                                <li><a href="#tab4" role="tab" data-toggle="tab">Файлы</a></li>
                            </ul>
                            <!-- TAB CONTENT -->
                            <div class="tab-content">
                                <div class="active tab-pane fade in" id="tab1">
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Регистрационный номер</label>
                                        <div class="col-md-6">
                                            {{$candidate->reg_number}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Поименной номер</label>
                                        <div class="col-md-6">
                                            {{$candidate->name_number}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">ФИО</label>
                                        <div class="col-md-6">
                                            {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a class="btn btn-success" download='download' href="{{URL::route('doc.statement', [$candidate->id])}}">Заявление на поступление</a>
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Пол</label>
                                        <div class="col-md-6">
                                            @if($candidate->gender == 'male') Юноша @else Девушка @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Дата рождения</label>
                                        <div class="col-md-3">
                                            @if ($candidate->birth_date != '0000-00-00')
                                                {{date('d.m.Y', strtotime($candidate->birth_date))}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Средний балл</label>
                                        <div class="col-md-2">
                                            {{$candidate->gpa}} ({{$candidate->rate}})
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Форма обучения</label>
                                        <div class="col-md-6">
                                            @if(!empty($candidate->formTraining))
                                                {{$candidate->formTraining->title}}
                                            @endif
                                            @if(!empty($candidate->inflow))
                                                (Приток)
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Вид финансирования</label>
                                        <div class="col-md-6">
                                            @if(!empty($candidate->monetaryBasis))
                                                {{$candidate->monetaryBasis->title}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Окончил(а) классов:</label>
                                        <div class="col-md-6">
                                            {{$candidate->graduatedClass}} в {{$candidate->graduatedYear}} г.
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Поступает в </label>
                                        <div class="col-md-2">
                                            {{$candidate->admissionYear}} г.
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Телефоны</label>
                                        <div class="col-md-8">
                                            @foreach ($candidate->phones()->orderBy('id', 'desc')->get() as $phone)
                                                <a href="tel:{{$phone->phone}}" style="display: inline-block;">{{$phone->phone}}</a> {{$phone->pcomment}}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">e-mail</label>
                                        <div class="col-md-6">
                                            {{$candidate->email}}
                                        </div>
                                    </div>

                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Дата подачи документов</label>
                                        <div class="col-md-6">
                                            @if ($candidate->date_of_filing != '0000-00-00')
                                                {{date('d.m.Y', strtotime($candidate->date_of_filing))}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Рег. Номер</label>
                                        <div class="col-md-6">
                                            {{$candidate->reg_number}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Основная специальность/профессия</label>
                                        <div class="col-md-6">
                                            @if(!empty($candidate->spec->title))
                                                {{$candidate->spec->title}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Дополнительные специальности/профессии</label>
                                        <div class="col-md-6">
                                            @foreach($candidate->specializations as $spec)
                                                {{$spec->code}} {{$spec->title}}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Является сиротой</label>
                                        <div class="col-md-6">
                                            {{$candidate->fatherless ? 'Да' : 'Нет'}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Является индвалидом</label>
                                        <div class="col-md-6">
                                            {{$candidate->is_invalid1 ? 'Да' : 'Нет'}}
                                        </div>
                                    </div>
                                    @if(!empty($candidate->is_invalid))
                                        <div class="form-group no-padding-top">
                                            <label class="col-md-2 control-label">Причина инвалидности</label>
                                            <div class="col-md-6">
                                                {{$candidate->is_invalid}}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($candidate->date_took and $candidate->date_took != '0000-00-00')
                                        <div class="form-group no-padding-top">
                                            <label class="col-md-2 control-label">Забрал документы, дата</label>
                                            <div class="col-md-6">
                                                {{date('d.m.Y', strtotime($candidate->date_took))}}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Получил образование</label>
                                        <div class="col-md-9">
                                            {{$candidate->educationType->title}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <h4 class="col-md-2 text-right">Аттестат</h4>
                                        <div class="col-md-2">
                                            @foreach($candidate->docs()->where('doc_type_id', 2)->get() as $d)
                                                <a href="/file/doc/{{$d->id}}" class="btn btn-xs btn-info" style="margin-bottom: -15px;" target="_blank">Загрузить</a>
                                                @break
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Номер</label>
                                        <div class="col-md-2">
                                            {{$candidate->certificate}}
                                        </div>
                                        <label class="col-md-2 control-label">Дата выдачи</label>
                                        <div class="col-md-1">
                                            @if ($candidate->certificate_issued_at != '0000-00-00')
                                                {{date('d.m.Y', strtotime($candidate->certificate_issued_at))}}
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            Предоставлен оригинал: @if($candidate->certificate_provided == 1) Да @else Нет @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group no-padding-top">
                                        <h4 class="col-md-2 text-right">Школа</h4>
                                        <br>
                                        <div class="col-md-9 col-md-offset-2">
                                            @if(!empty($candidate->school))
                                                {{$candidate->school->title}}, {{$candidate->school->city->title}}, {{$candidate->school->region->title}}
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group no-padding-top">
                                        <h4 class="col-md-2 text-right">Документ, удостоверяющий личность</h4>
                                        <div class="col-md-2">
                                            @foreach($candidate->docs()->where('doc_type_id', 1)->get() as $d)
                                                <a href="/file/doc/{{$d->id}}" class="btn btn-xs btn-info" style="margin-bottom: -15px;" target="_blank">Загрузить</a>
                                                @break
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($candidate->is_rusian)
                                        <div class="form-group no-padding-top">
                                            <label class="col-md-2 control-label">Серия и номер паспорта</label>
                                            <div class="col-md-2">
                                                {{$candidate->passport_number}}
                                            </div>
                                            <label class="col-md-2 control-label">Дата выдачи</label>
                                            <div class="col-md-1">
                                                @if ($candidate->passport_provided_at != '0000-00-00')
                                                    {{date('d.m.Y', strtotime($candidate->passport_provided_at))}}
                                                @endif
                                            </div>
                                            <label class="col-md-2 control-label">Код подразделения</label>
                                            <div class="col-md-2">
                                                {{$candidate->passport_place_code}}
                                            </div>
                                        </div>
                                        <div class="form-group no-padding-top">
                                            <label class="col-md-2 control-label">Кем выдан:</label>
                                            <div class="col-md-9">
                                                {{$candidate->passport_provided_place}}
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group no-padding-top">
                                            <label class="col-md-2 control-label">Загранпаспорт:</label>
                                            <div class="col-md-9">
                                                {{$candidate->international_passport}}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Адрес прописки:</label>
                                        <div class="col-md-9">
                                            {{$candidate->law_address}}
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Адрес проживания</label>
                                        <div class="col-md-6">
                                            {{$candidate->region->title}}, {{$candidate->city->title}}, {{$candidate->address}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group no-padding-top">
                                        <h4 class="col-md-2 text-right">Медицинский полис</h4>
                                        <div class="col-md-2">
                                            @foreach($candidate->docs()->where('doc_type_id', 4)->get() as $d)
                                                <a href="/file/doc/{{$d->id}}" class="btn btn-xs btn-info" style="margin-bottom: -15px;" target="_blank">Загрузить</a>
                                                @break
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Номер</label>
                                        <div class="col-md-2">
                                            {{$candidate->medical_number}}
                                        </div>
                                        <label class="col-md-2 control-label">Выдан организацией</label>
                                        <div class="col-md-5">
                                            {{$candidate->medical_provided_place}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">СНИЛС</label>
                                        <div class="col-md-2">
                                            @foreach($candidate->docs()->where('doc_type_id', 4)->get() as $d)
                                                <a href="/file/doc/{{$d->id}}" class="btn btn-xs btn-info" target="_blank">Загрузить</a>
                                                @break
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            {{$candidate->pension_certificate}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Предоставлено необходимое количество фотографи</label>
                                        <div class="col-md-2">
                                            @if($candidate->photos_provided == 1) Да @else Нет @endif
                                        </div>
                                        <label class="col-md-2 control-label">Предоставлени прививочный сертификат</label>
                                        <div class="col-md-2">
                                            @if($candidate->vaccinations_provided == 1) Да @else Нет @endif
                                        </div>
                                    </div>
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-2 control-label">Предоставлена медицинская справка здоровья (086-У)</label>
                                        <div class="col-md-2">
                                            @if($candidate->health_certificate_provided == 1) Да @else Нет @endif
                                        </div>
                                        <label class="col-md-2 control-label">Представлена справка 025-Ю, для юношей</label>
                                        <div class="col-md-2">
                                            @if($candidate->certificate_25u_provided == 1) Да @else Нет @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <div class="form-group no-padding-top">
                                        <div class="col-md-11">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ФИО</th>
                                                    <th>Телефон</th>
                                                    <th>Год рождения</th>
                                                    <th>Место работы</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($candidate->parents as $parent)
                                                    <tr>
                                                        <td>{{getParentType($parent->type)}}</td>
                                                        <td>{{$parent->fio}}</td>
                                                        <td>{{$parent->phone}}</td>
                                                        <td>{{$parent->year}}</td>
                                                        <td>{{$parent->workplace}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab4">
                                    <div class="form-group no-padding-top">
                                        <label class="col-md-1 control-label"></label>
                                        <div class="col-md-8">
                                            @foreach($candidate->docs as $doc)
                                                <a href="/file/doc/{{$doc->id}}" style="display: inline-block;">{{$doc->original_name}}</a> ({{$doc->fcomment}})
                                                - {{!empty($doc->docType->title) ? $doc->docType->title: 'Иной документ'}}
                                                <br>
                                            @endforeach
                                        </div>
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
