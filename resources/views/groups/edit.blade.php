@extends('layouts.master')

@section('title')Редактировать группу@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::model($item, ['method' => 'put', 'url' => '/dec/groups/'.$item->id, 'class' => 'panel panel-default']) !!}
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Редактировать группу</div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-sm" href="{{URL::previous()}}">Назад</a>
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="panel-body form-horizontal">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-md-2 control-label">Специальность</label>
                            <div class="col-md-6">
                                {!! Form::select('specialization_id', getSpecializations(Auth::user()->college_id), null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

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

                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Код</label>
                            <div class="col-md-6">
                                {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($educationSystemId == 2)
                            <div class="form-group">
                                <label class="col-md-2 control-label">Факультет</label>
                                <div class="col-md-6">
                                    {!! Form::select('faculty_id', \App\Models\Faculty::where('college_id', Auth::user()->college_id)->pluck('title', 'id'), null, ['class' => 'form-control']) !!}
                                    <select class='form-control' name="semester_id">
                                        @foreach($listSemester as $semester)
                                            <option value="{{ $semester }}">
                                                {{ $semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-md-2 control-label">Семестр</label>
                            <div class="col-md-6">
                                <select class='form-control' name="semester_id">
                                    @foreach($listSemester as $semester)
                                        <option {{ $item->semester_id == $semester ? 'selected' : '' }} value="{{ $semester }}">
                                            {{ $semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Курс</label>
                            <div class="col-md-6">
                                <select class='form-control' name="course_id">
                                    @foreach($listCourse as $course)
                                        <option {{ $item->course_id == $course->id ? 'selected' : '' }} value="{{ $course->id }}">
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Кол-во курсов</label>
                            <div class="col-md-6">
                                {!! Form::text('number_course', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Выберите куратора</label>
                            <div class="col-md-6">
                                <select class='form-control' name="teacher_id" id="idListTeacherSelect">
                                    @foreach($listTeachers as $teacher)
                                        <option  {{ $item->teacher_id == $teacher->id ? 'selected' : '' }}  value="{{ $teacher->id }}">
                                            {{ $teacher->last_name.' '.$teacher->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <input type="hidden" name="college_id" value="{{Auth::user()->college_id}}">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Год</label>
                            <div class="col-md-6">
                                {!! Form::text('year', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Бюджетных мест</label>
                            <div class="col-md-6">
                                {!! Form::number('free_places', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Внебюджетных мест</label>
                            <div class="col-md-6">
                                {!! Form::number('non_free_places', null, ['class' => 'form-control']) !!}
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
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
