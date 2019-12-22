@extends('layouts.master')

@section('title')Новая специальность@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="panel panel-default" method="post" action="/dic/specializations">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Новая специальность</div>
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
                                    {!! Form::textarea('title', null, ['class' => 'form-control', 'required', 'rows' => 3]) !!}
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
                                <label class="col-md-2 control-label">Контрольные цифры приема</label>
                                <div class="col-md-6">
                                    {!! Form::number('kcp', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            @if(count(getSubdivisions(Auth::user()->college_id)))
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Подразделение</label>
                                    <div class="col-md-6">
                                        {!! Form::select('subdivision_id',getSubdivisions(Auth::user()->college_id), null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endif
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
