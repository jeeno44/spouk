@extends('layouts.master')
@section('title')Редактировать студента@stop
@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($candidate, ['method' => 'put', 'url' => '/dec/students/'.$candidate->id, 'class' => 'panel panel-default']) !!}
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Редактировать студента</div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                    <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body form-horizontal">
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger"><strong>{{ $error }}</strong></div>
                            @endforeach
                        @endif

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Общие сведения</a></li>
                            <li><a href="#tab2" role="tab" data-toggle="tab">Документы</a></li>
                            <li><a href="#tab3" role="tab" data-toggle="tab">Родители</a></li>
                            <li><a href="#tab4" role="tab" data-toggle="tab">Файлы</a></li>
                        </ul>
                        <!-- TAB CONTENT -->
                        <div class="tab-content">
                            <div class="active tab-pane fade in" id="tab1">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Рег. Номер</label>
                                    <div class="col-md-6">
                                        {!! Form::text('reg_number', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Дата подачи документов</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-content">
                                                {!! Form::text('date_of_filing', old('date_of_filing') ? old('date_of_filing') : $candidate->date_of_filing != '0000-00-00' ? date('d.m.Y', strtotime($candidate->date_of_filing)) : '', ['class' => 'form-control js-datepicker']) !!}
                                                <span class="help-block" style="display: none;"></span>
                                            </div>
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Фамилия</label>
                                    <div class="col-md-6">
                                        {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'getFamily', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Имя</label>
                                    <div class="col-md-6">
                                        {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'getNames', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Отчество</label>
                                    <div class="col-md-6">
                                        {!! Form::text('middle_name', null, ['class' => 'form-control', 'id' => 'getMiddleName', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Пол</label>
                                    <div class="col-md-6">
                                        <label class="radio-inline radio-styled">
                                            {!! Form::radio('gender', 'male', null, ['required']) !!}
                                            <span>Юноша</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            {!! Form::radio('gender', 'female', null, ['required']) !!}
                                            <span>Девушка</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Дата рождения</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-content">
                                                {!! Form::text('birth_date', $candidate->birth_date != '0000-00-00' ? date('d.m.Y', strtotime($candidate->birth_date)) : '', ['class' => 'form-control js-datepicker']) !!}
                                                <span class="help-block" style="display: none;"></span>
                                            </div>
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Средний балл</label>
                                    <div class="col-md-2">
                                        {!! Form::text('gpa', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Приоритет</label>
                                    <div class="col-md-2">
                                        {!! Form::number('rate', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Форма обучения</label>
                                    <div class="col-md-2">
                                        <label class="radio-styled" style="margin-right: 10px;">
                                            {!! Form::radio('form_training', 1, null, ['checked']) !!}
                                            <span>Очная</span>
                                        </label>
                                        <label class="radio-styled" style="margin-right: 10px;">
                                            {!! Form::radio('form_training', 2, null, []) !!}
                                            <span>Заочная</span>
                                        </label>
                                        <label class="checkbox-styled" style="margin-right: 10px;">
                                            {!! Form::checkbox('inflow', 1, null, []) !!}
                                            <span>Приток</span>
                                        </label>
                                    </div>
                                    <label class="col-md-2 control-label">Вид финансирования</label>
                                    <div class="col-md-3">
                                        <label class="radio-styled" style="margin-right: 10px;">
                                            {!! Form::radio('monetary_basis', '1', null, ['checked']) !!}
                                            <span>Бюджетная основа</span>
                                        </label>
                                        <label class="radio-styled" style="margin-right: 10px;">
                                            {!! Form::radio('monetary_basis', '2', null, []) !!}
                                            <span>Платная основа</span>
                                        </label>
                                        <label class="radio-styled" style="margin-right: 10px;">
                                            {!! Form::radio('monetary_basis', 3, null, []) !!}
                                            <span>Целевой набор</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Окончил(а) классов:</label>
                                    <div class="col-md-2">
                                        {!! Form::text('graduatedClass', null, ['class' => 'form-control', 'id' => 'number1', 'data-rule-number' => 'true']) !!}
                                        <span id="number1-error" class="help-block" style="display: none;"></span>
                                    </div>
                                    <label class="col-md-2 control-label">в году:</label>
                                    <div class="col-md-2">
                                        {!! Form::text('graduatedYear', null, ['class' => 'yy-datepicker form-control', 'id' => 'number2', 'data-rule-number' => 'true']) !!}
                                        <span id="number2-error" class="help-block" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Поступает в </label>
                                    <div class="col-md-2">
                                        {!! Form::text('admissionYear', null, ['class' => 'yy-datepicker form-control', 'id' => 'number3', 'data-rule-number' => 'true']) !!}
                                        <span id="number3-error" class="help-block" style="display: none;"></span>
                                    </div>
                                    <label class="col-md-2 control-label" style="text-align: left !important;">году </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Телефон</label>
                                    <div class="col-md-8">
                                        <div class="row phone-row">
                                            <div id="dynamicPhones" class="col-md-9">
                                                @foreach($candidate->phones as $key => $phone)
                                                    <div class="row phone-row">
                                                        <div class="col-md-3">
                                                            <input name="phones[{{$key}}][phone]" value='{{$phone->phone}}'  type="text" class="form-control input-mask" data-inputmask="'mask': '+7 (999) 999-99-99'">
                                                            <p class="help-block">Номер телефона</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="phones[{{$key}}][comment]" value='{{$phone->pcomment}}' type="text" class="form-control">
                                                            <p class="help-block">Комментарий к номеру</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="control-label col-md-3">
                                                <a href="#" id="addPhoneDynamic">
                                                    <i class="fa fa-phone"></i> Добавить телефон
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">e-mail</label>
                                    <div class="col-md-6">
                                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Основная специальность/профессия *</label>
                                    <div class="col-md-6">
                                        {!! Form::select('specialization_id', $specs, null,
                                        ['class' => 'form-control', 'required', 'data-placeholder' => 'Выберите специальности', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Группа *</label>
                                    <div class="col-md-6">
                                        {!! Form::select('group_id', getGroupsSpec(Auth::user()->college_id, $candidate->specialization_id), $candidate->group_id,
                                        ['class' => 'form-control', 'required', 'data-placeholder' => 'Выберите группу', 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Является сиротой</label>
                                    <div class="col-md-6">
                                        {!! Form::checkbox('fatherless', 1, old('fatherless')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Является инвалидом</label>
                                    <div class="col-md-6">
                                        {!! Form::checkbox('is_invalid1', 1, $candidate->is_invalid1) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Причина инвалидности,<br /> при наличии</label>
                                    <div class="col-md-6">
                                        {!! Form::text('is_invalid', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2">
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Аттестат</h4>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Получил образование</label>
                                        <div class="col-md-9">
                                            {!! Form::select('education_id', getEducationsTypes(),  null,  ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <label class="col-md-2 control-label">Номер</label>
                                    <div class="col-md-2">
                                        {!! Form::text('certificate', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Дата выдачи</label>
                                    <div class="col-md-1">
                                        {!! Form::text('certificate_issued_at', $candidate->certificate_issued_at != '0000-00-00' ? date('d.m.Y', strtotime($candidate->certificate_issued_at)) : '', ['class' => 'form-control js-datepicker']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                {!! Form::checkbox('certificate_provided', 1, null) !!}
                                                <span>Предоставлен оригинал</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Школа</h4>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Регион школы</label>
                                    <div class="col-md-9">
                                        {!! Form::select('region_id', getRegions(), null, ['class' => 'form-control', 'id' => 'region_candidates']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Город школы</label>
                                    <div class="col-md-9">
                                        {!! Form::select('city_id', getCitys($candidate->region_id), null, ['class' => 'form-control', 'id' => 'citiesCandidates']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Наименование школы</label>
                                    <div class="col-md-9">
                                        {!! Form::text('school_name', !empty($candidate->school->title) ? $candidate->school->title : '', ['class' => 'form-control', 'id' => 'schools']) !!}
                                    </div>
                                    <input type="hidden" value="{{$candidate->school_id}}" name="school_id" />
                                </div>
                                <hr>
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Паспорт</h4>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Документ, удостоверяющий личность</h4>
                                    <div class="col-md-8">
                                        <label class="radio-inline radio-styled">
                                            {!! Form::radio('is_russian', 1, null, ['checked']) !!}
                                            <span>Гражданин РФ</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            {!! Form::radio('is_russian', 0, null, []) !!}
                                            <span>Иностранный гражданин</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group ru-passport">
                                    <label class="col-md-2 control-label">Серия и номер паспорта</label>
                                    <div class="col-md-2">
                                        {!! Form::text('passport_number', null, ['class' => 'form-control input-mask', 'data-inputmask' => "'mask': '9999 999999'"]) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Дата выдачи</label>
                                    <div class="col-md-1">
                                        {!! Form::text('passport_provided_at', null, ['class' => 'form-control js-datepicker']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Код подразделения</label>
                                    <div class="col-md-2">
                                        {!! Form::text('passport_place_code', null, ['class' => 'form-control input-mask', 'data-inputmask' => "'mask': '999-999'"]) !!}
                                    </div>
                                </div>
                                <div class="form-group ru-passport">
                                    <label class="col-md-2 control-label">Кем выдан:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('passport_provided_place', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group in-passport">
                                    <label class="col-md-2 control-label">Загранпаспорт:</label>
                                    <div class="col-md-9">
                                        {!! Form::textarea('international_passport', null, ['class' => 'form-control', 'rows' => 2]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Адрес прописки:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('law_address', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Адрес проживания</label>
                                    <div class="col-md-7">
                                        {!! Form::text('address', old('address'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-2"><a href="#" id="address-two">Совпадает с адресом прописки</a></div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Медицинский полис</h4>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Номер</label>
                                    <div class="col-md-2">
                                        {!! Form::text('medical_number', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Выдан организацией</label>
                                    <div class="col-md-5">
                                        {!! Form::text('medical_provided_place', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">СНИЛС</label>
                                    <div class="col-md-9">
                                        {!! Form::text('pension_certificate', null, ['class' => 'form-control input-mask', 'data-inputmask' => "'mask': '999-999-999 99'"]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                {!! Form::checkbox('photos_provided', 1, null) !!}
                                                <span>Предоставлено необходимое количество фотографий</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                {!! Form::checkbox('vaccinations_provided', 1, null) !!}
                                                <span>Предоставлен прививочный сертификат</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                {!! Form::checkbox('health_certificate_provided', 1, null) !!}
                                                <span>Предоставлена медицинская справка здоровья (086-У)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                {!! Form::checkbox('certificate_25u_provided', 1, null) !!}
                                                <span>Представлена справка 025-Ю, для юношей</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab3">
                                <div class="form-group">
                                    <div id="parents-wrap" class="col-md-12">
                                        @foreach($candidate->parents as $key => $parent)
                                            <div id="par_{{$key + 100}}" class="row doc-row">
                                                <div class="col-md-3">
                                                    <select name="parents[{{$key + 100}}][type]" class="form-control">
                                                        <option value="mom" @if($parent->type == 'mom') selected @endif>Мать</option>
                                                        <option value="dad" @if($parent->type == 'dad') selected @endif>Отец</option>
                                                        <option value="other" @if($parent->type == 'other') selected @endif>Иной законный представитель</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="col-md-6">
                                                        <input name="parents[{{$key + 100}}][fio]" type="text" class="form-control" value="{{$parent->fio}}">
                                                        <p class="help-block">ФИО</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input name="parents[{{$key + 100}}][phone]" type="text" class="form-control" value="{{$parent->phone}}">
                                                        <p class="help-block">Телефон</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input name="parents[{{$key + 100}}][year]" type="text" class="form-control yy-datepicker"  value="{{$parent->year}}">
                                                        <p class="help-block">Год рождения</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input name="parents[{{$key + 100}}][worklace]" type="text" class="form-control"  value="{{$parent->workplace}}">
                                                        <p class="help-block">Место работы</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 control-label">
                                                    <a href="#" onclick="removeParent({{$key + 100}});return false;" data-id="{{$key + 100}}"><i class="fa fa-remove"></i>&nbsp;Удалить</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 doc-row">
                                        <div class="control-label col-md-12 text-right">
                                            <a href="#" id="add-parent"><i class="fa fa-user"></i> Добавить родителя</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab4">
                                <div class="form-group">
                                    <div id="file-wrap" class="col-md-12">
                                        @foreach($candidate->docs as $doc)
                                            <div class="file-item row">
                                                <div class="col-sm-3">
                                                    <label class="control-label floating-label">Наименование</label>
                                                    <input type="text" class="form-control" name="file_names[]" value="{{$doc->original_name}}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label floating-label">Комментарий</label>
                                                    <input type="text" class="form-control" name="file_comments[]" value="{{$doc->fcomment}}">
                                                    <input type="hidden" name="file_paths[]" value="{{$doc->filename}}">
                                                    <input type="hidden" name="file_types[]" value="{{$doc->type}}">
                                                    <input type="hidden" name="file_sizes[]" value="{{$doc->size}}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label floating-label">Тип документа</label>
                                                    {!! Form::select('doc_types[]', \App\Models\DocType::lists('title', 'id'), $doc->doc_type_id, ['class' => 'form-control']) !!}
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label floating-label">&nbsp;</label><br>
                                                    <button type="button" class="btn btn-floating-action btn-danger remove-file btn-xs" data-path="{{$doc->filename}}"><i class="fa fa-times"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 doc-row">
                                        <div class="control-label col-md-12 text-right">
                                            <input type="file" id="file-uploader" class="hidden">
                                            <a href="#" id="add-file"><i class="fa fa-file-word-o"></i> Добавить документ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                    <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
