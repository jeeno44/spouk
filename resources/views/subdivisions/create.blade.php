@extends('layouts.master')

@section('title')Добавить подразделение@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="panel panel-default" method="post" action="/college/subdivisions">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Добавить подразделение</div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Название</label>
                                <div class="col-md-6">
                                    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="college_id" value="{{Auth::user()->college_id}}">

                            <div class="form-group">
                                <label class="col-md-2 control-label">Код</label>
                                <div class="col-md-6">
                                    {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ИНН</label>
                                <div class="col-md-6">
                                    {!! Form::text('inn', null, ['class' => 'form-control', 'placeholder' => 'По этому полю при загрузке будет проводиться идентификация образовательной организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОГРН</label>
                                <div class="col-md-6">
                                    {!! Form::text('ogrn', null, ['class' => 'form-control', 'placeholder' => 'Указать ОГРН организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Тип организации </label>
                                <div class="col-md-6">
                                    {!! Form::text('type', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Полное наименование ОО</label>
                                <div class="col-md-6">
                                    {!! Form::textarea('full_title', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Организационная форма</label>
                                <div class="col-md-6">
                                    {!! Form::text('full_title', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ИНН управляющей организации </label>
                                <div class="col-md-6">
                                    {!! Form::text('parent_inn', null, ['class' => 'form-control', 'placeholder' => 'по этому полю при загрузке будет устанавливаться иерархия подчинения ']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Виды образовательной деятельности </label>
                                <div class="col-md-6">
                                    {!! Form::textarea('views', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКОПФ</label>
                                <div class="col-md-6">
                                    {!! Form::text('okopf', null, ['class' => 'form-control', 'placeholder' => 'указать ОКОПФ организации в соответствии с ОК 028-2012']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКФС</label>
                                <div class="col-md-6">
                                    {!! Form::text('okfs', null, ['class' => 'form-control', 'placeholder' => 'указать ОКФС организации в соответствии с ОК 027-99']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКВЭД</label>
                                <div class="col-md-6">
                                    {!! Form::text('okved', null, ['class' => 'form-control', 'placeholder' => 'указать ОКВЭД организации в соответствии с ОК 029-2014. В случае, если ОКВЭД несколько - указать их через запятую']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Организационная структура</label>
                                <div class="col-md-6">
                                    {!! Form::text('strukture', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата образования ОО</label>
                                <div class="col-md-6">
                                    {!! Form::text('make_date', null, ['class' => 'form-control', 'placeholder' => 'Указать дату образования организации в соответствии с учредительными документами']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Данные об учредителе(ях) </label>
                                <div class="col-md-6">
                                    {!! Form::textarea('uchred', null, ['class' => 'form-control', 'placeholder' => 'В текстовом виде наименование учредителя (МОУО, РОИВ).']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Юридический адрес</label>
                                <div class="col-md-6">
                                    {!! Form::textarea('law_address', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Почтовый адрес </label>
                                <div class="col-md-6">
                                    {!! Form::textarea('post_address', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Населенный пункт</label>
                                <div class="col-md-6">
                                    {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Указать населенный пункт. Для города - наименование самого города (например: город Самара)']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКПО</label>
                                <div class="col-md-6">
                                    {!! Form::text('okpo', null, ['class' => 'form-control', 'placeholder' => 'код ОКПО организации согласно ОК 007-93']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКТМО</label>
                                <div class="col-md-6">
                                    {!! Form::text('oktmo', null, ['class' => 'form-control', 'placeholder' => '11-значный код ОКТМО населенного пункта согласно ОК 33-2013. ']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">ОКАТО</label>
                                <div class="col-md-6">
                                    {!! Form::text('okato', null, ['class' => 'form-control', 'placeholder' => 'код ОКАТО объекта административно-территориального деления согласно ОК 019-95']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата/время актуальности</label>
                                <div class="col-md-6">
                                    {!! Form::text('actual_date', null, ['class' => 'form-control', 'placeholder' => 'Дата актуальности передаваемых в файле данных. Например, текущая дата, или 1 число месяца']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Статус ОО</label>
                                <div class="col-md-6">
                                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Телефон</label>
                                <div class="col-md-6">
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Телефон организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Факс </label>
                                <div class="col-md-6">
                                    {!! Form::text('fax', null, ['class' => 'form-control', 'placeholder' => 'Факс организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Email </label>
                                <div class="col-md-6">
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Адрес официального сайта </label>
                                <div class="col-md-6">
                                    {!! Form::text('site', null, ['class' => 'form-control', 'placeholder' => 'Сайт организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Регистрационный номер лицензии</label>
                                <div class="col-md-6">
                                    {!! Form::text('licence_number', null, ['class' => 'form-control', 'placeholder' => 'Номер лицензии организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата выдачи лицензии</label>
                                <div class="col-md-6">
                                    {!! Form::text('licence_date', null, ['class' => 'form-control', 'placeholder' => 'Дата выдачи лицензии организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Серия, номер бланка лицензии</label>
                                <div class="col-md-6">
                                    {!! Form::text('licence_serie', null, ['class' => 'form-control', 'placeholder' => 'Серия, номер бланка лицензии организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата окончания действия лицензии</label>
                                <div class="col-md-6">
                                    {!! Form::text('licence_date_finish', null, ['class' => 'form-control', 'placeholder' => 'Дата окончания действия лицензии организации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Регистрационный номер</label>
                                <div class="col-md-6">
                                    {!! Form::text('reg_number', null, ['class' => 'form-control', 'placeholder' => 'Номер  свидетельства о государственной аккредитации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата выдачи свидетельства </label>
                                <div class="col-md-6">
                                    {!! Form::text('blank_date', null, ['class' => 'form-control', 'placeholder' => 'Дата выдачи свидетельства о государственной аккредитации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Серия, номер бланка свидетельства</label>
                                <div class="col-md-6">
                                    {!! Form::text('blank_number', null, ['class' => 'form-control', 'placeholder' => 'Серия, номер бланка  свидетельства о государственной аккредитации']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Дата окончания действия свидетельства</label>
                                <div class="col-md-6">
                                    {!! Form::text('blank_finish', null, ['class' => 'form-control', 'placeholder' => 'Дата окончания действия  свидетельства о государственной аккредитации']) !!}
                                </div>
                            </div>


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
