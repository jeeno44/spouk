@extends('layouts.master')

@section('title'){{$item->title}}@stop

@section('content')
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">{{$item->title}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                           <table class="table table-bordered">
                                @foreach($courses as $course)
                                    <tr>
                                        <td rowspan="2">
                                            {{$course->title}}
                                        </td>
                                        <td>
                                            Семестр 1
                                        </td>
                                        <td>
                                            <?php $dics = $items->where('course_id', $course->id)->where('semester_id', 1)?>
                                            @foreach($dics as $dic)
                                                {{$dic->discipline->title}}:
                                                Всего: {{$dic->sum()}} , ЗЕТ: {{$dic->zet_hours}}, Контроль: {{$dic->control_type}}
                                                    <br>
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-default" href="/training/plans/{{$item->id}}/disciplines/{{$course->id}}/1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                   <tr>
                                       <td>
                                           Семестр 2
                                       </td>
                                       <td>
                                           <?php $dics = $items->where('course_id', $course->id)->where('semester_id', 2)?>
                                           @foreach($dics as $dic)
                                               {{$dic->discipline->title}}<br>
                                           @endforeach
                                       </td>
                                       <td class="text-right">
                                           <a class="btn btn-default" href="/training/plans/{{$item->id}}/disciplines/{{$course->id}}/2">
                                               <i class="fa fa-pencil"></i>
                                           </a>
                                       </td>
                                   </tr>
                                @endforeach
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
