@extends('layouts.master')

@section('title')Приказы@stop

@section('content')
<div id="filter" class="card" style="">
    <div class="card-body style-default-light  order-filter">
        <div class="form col-md-6">
            <div class="form-group">
                {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
                <label>Тип приказа</label>
            </div>
        </div>
        <div class="form col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" class="person-autocomplete" id="candidates">
                <input type="hidden" name="person" value="0">
                <label>Персона</label>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">Приказы</div>
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
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Тип</th>
                                    <th>
                                        Номер&nbsp;
                                    </th>
                                    <th>
                                        Дата приказа&nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="orders-table">
                                @include('protocol.ajaxProtocol')
                            </tbody>
                        </table>
                        {!! csrf_field() !!}
                        <div align="center">
                            @if (!empty($orders->render()))
                            <div class="pagination-orders">
                                {{$orders->render()}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
