@extends('layouts.master')

@section('title')Рабочий стол@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-6">
                    <h2 style="margin-top: 0">События</h2>
                    @foreach($events as $event)
                    <div class="card style-default-light">
                        <div class="card-body small-padding">
                            <p>
                                <span class="text-medium">{{$event->title}}</span><br>
                                <span class="opacity-50">{{$event->date}}</span>
                            </p>
                            {{$event->text}}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-sm-6">
                    <h2 style="margin-top: 0">&nbsp;</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="well card style-default-light" href="/dec/groups">
                                Учебных групп: {{\App\Models\SpecializationGroup::whereIn('specialization_id', $college->specializations()->pluck('id'))->count() }}
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a class="well card style-default-light" href="/dec/students">Студентов: {{$college->candidates()->where('is_student', 1)->count()}}</a>
                            <a class="well card style-default-light" href="/college/teachers">Сотрудников: {{$college->users()->count()}}</a>
                        </div>
                        <div class="col-sm-6">
                            <a class="well card style-default-light" href="/enroll/candidates">Абитуриентов: {{$college->candidates()->where('is_student', 0)->count()}}</a>
                            <div class="well card style-default-light">Родителей: {{\App\Models\CandidateParent::whereIn('candidate_id', $college->candidates()->pluck('id'))->count() }}</div>
                        </div>
                    </div>
                    <p>{{$college->title}}</p>
                    <p>{{$college->region->title}}, {{$college->city->title}}, {{$college->address}}, {{$college->phone}}</p>
                </div>
            </div>
        </div>
    </section>

@endsection
