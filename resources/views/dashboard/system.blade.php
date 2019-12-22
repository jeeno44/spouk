@extends('layouts.app')

@section('title')Выбор подсистемы@stop

@section('content')
    <div class="card-body style-default-light">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                @foreach(\App\Models\System::where('enabled', 1)->get() as $system)
                    <a href="/sub-system/{{$system->id}}" class="list-group-item">
                        <div class="media">
                            <div class="media-body">
                                <h4 class="list-group-item-heading">Подсистема "{{$system->name}}"</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

