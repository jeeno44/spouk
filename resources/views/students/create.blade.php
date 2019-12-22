@extends('layouts.master')
@section('title')Новый студент@stop
@section('content')
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <form id="create-candidate" class="panel panel-default form-validate" enctype="multipart/form-data" method="post" action="/dec/students">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Новый студент</div>
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
                                                {!! Form::text('date_of_filing', old('date_of_filing') ? old('date_of_filing') : date("d.m.Y"), ['class' => 'form-control js-datepicker', 'required']) !!}
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
                                                {!! Form::text('birth_date', old('birth_date'), ['class' => 'form-control js-datepicker']) !!}
                                            </div>
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Средний балл</label>
                                    <div class="col-md-2">
                                        {!! Form::number('gpa', old('gpa'), ['class' => 'form-control']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Приоритет</label>
                                    <div class="col-md-2">
                                        {!! Form::number('rate', old('rate'), ['class' => 'form-control']) !!}
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
                                        {!! Form::text('graduatedClass', old('graduatedClass'), ['class' => 'form-control', 'id' => 'number1', 'data-rule-number' => 'true']) !!}
                                        <span id="number1-error" class="help-block" style="display: none;"></span>
                                    </div>
                                    <label class="col-md-2 control-label">в году:</label>
                                    <div class="col-md-2">
                                        {!! Form::text('graduatedYear', old('graduatedYear'), ['class' => 'yy-datepicker form-control', 'id' => 'number2', 'data-rule-number' => 'true']) !!}
                                        <span id="number2-error" class="help-block" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Поступает в </label>
                                    <div class="col-md-2">
                                        {!! Form::text('admissionYear', old('admissionYear'), ['class' => 'yy-datepicker form-control', 'id' => 'number3', 'data-rule-number' => 'true']) !!}
                                        <span id="number3-error" class="help-block" style="display: none;"></span>
                                    </div>
                                    <label class="col-md-2 control-label" style="text-align: left !important;">году </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Телефон</label>
                                    <div class="col-md-8">
                                        <div class="row phone-row">
                                            <div class="col-md-3">
                                                <input name="phones[0][phone]" value='{{old('phones[0][phone]')}}'  type="text" class="form-control input-mask" data-inputmask="'mask': '+7 (999) 999-99-99'">
                                                <p class="help-block">Номер телефона</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input name="phones[0][comment]" value='{{old('phones[0][comment]')}}' type="text" class="form-control">
                                                <p class="help-block">Комментарий к номеру</p>
                                            </div>
                                            <div class="control-label col-md-3">
                                                <a href="#" id="addPhoneDynamic">
                                                    <i class="fa fa-phone"></i> Добавить телефон
                                                </a>
                                            </div>
                                        </div>
                                        <div id="dynamicPhones">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">e-mail</label>
                                    <div class="col-md-6">
                                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
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
                                        {!! Form::select('group_id', [], null,
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
                                        {!! Form::checkbox('is_invalid1', 1, old('is_invalid1')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Причина инвалидности,<br /> при наличии</label>
                                    <div class="col-md-6">
                                        {!! Form::text('is_invalid', old('is_invalid'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab2">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Получил образование</label>
                                    <div class="col-md-9">
                                        {!! Form::select('education_id', getEducationsTypes(),  null,  ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-md-2 text-right">Аттестат</h4>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Номер</label>
                                    <div class="col-md-2">
                                        {!! Form::text('certificate', old('certificate'), ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <label class="col-md-2 control-label">Дата выдачи</label>
                                    <div class="col-md-1">
                                        {!! Form::text('certificate_issued_at', null, ['class' => 'form-control js-datepicker']) !!}
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
                                        {!! Form::select('region_id', getRegions(),
                                        old('region_id') ? old('region_id') : Auth::user()->college->region_id,
                                        ['class' => 'form-control', 'id' => 'region_candidates']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Город школы</label>
                                    <div class="col-md-9">
                                        {!! Form::select('city_id', getCitys(Auth::user()->college->region_id),
                                        old('city_id') ? old('city_id') : Auth::user()->college->city_id,
                                        ['class' => 'form-control', 'id' => 'citiesCandidates']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Наименование школы</label>
                                    <div class="col-md-9">
                                        {!! Form::text('school_name', old('school_name'), ['class' => 'form-control', 'id' => 'schools']) !!}
                                    </div>
                                    <input type="hidden" value="" name="school_id" />
                                </div>
                                <hr>

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

                                <div class="nationality-ru">
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
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
