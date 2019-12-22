@extends('layouts.master')

@section('title')Скачать приказ@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">Приказ</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <a  href="{{ url('dec/move-download/'.$protocol->id) }}">
                                {{ 'Скачать '.(empty($protocol->dicType->title) ? '' : $protocol->dicType->title).' №'.$protocol->order_number.' от '.datetime('d.m.Y', $protocol->order_date) }}

                            </a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
