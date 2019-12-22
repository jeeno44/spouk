@extends('layouts.master')

@section('title') @if(\Cookie::get('educationSystemId', 1) == 2) Вуз @else Колледж @endif @stop

@section('content')
    <section class="">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Настройки информации о @if(\Cookie::get('educationSystemId', 1) == 2) вузе @else колледже @endif</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Название</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="title" value="{{ $college->title }}">
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label">Телефон</label>

                                    <div class="col-md-6">
                                        <input type="tel" class="form-control input-mask" name="phone" value="{{ $college->phone }}" data-inputmask="'mask': '+7 (999) 999-99-99'">

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Адрес</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="address" value="{{ $college->address }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
