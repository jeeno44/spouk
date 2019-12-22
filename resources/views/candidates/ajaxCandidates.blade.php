@foreach ($candidates as $candidate)
    <tr>
        <td @if(!empty($candidate->is_invalid1)) style="border-left: 3px solid #d4fad6;" @endif>#{{$candidate->reg_number}}</td>
        <td><a href="/enroll/candidates/{{$candidate->id}}">{{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}</a></td>
        <td style="text-align: left;"> @if ($candidate->birth_date != '00.00.0000') {{date('d.m.Y', strtotime($candidate->birth_date))}} ({{$candidate->age}}) @endif </td>
        <td>
            @foreach ($candidate->phones()->orderBy('id', 'desc')->get() as $phone)
                <a href="tel:{{$phone->phone}}" style="display: inline-block;">{{$phone->phone}}</a>
                @break
            @endforeach
        </td>
        <td>
            {{$candidate->gpa}} ({{$candidate->rate}})
        </td>
        <td>
            @if(!empty($candidate->spec->title))
                {{$candidate->spec->code}} - {{$candidate->spec->title}}
                @if($candidate->specializations->count() > 0)
                    и {{$candidate->specializations->count()}} {{trans_choice('phrases.dops', $candidate->specializations->count())}}
                @endif
            @endif
        </td>
        <td class="text-right">
            <a class="btn btn-info btn-sm" href="/enroll/candidates/{{$candidate->id}}/edit"><i class="fa fa-pencil"></i> </a>
            <a class="btn btn-warning btn-sm" data-toggle="modal" href="#modal-{{$candidate->id}}"><i class="fa fa-times"></i> </a>

            <div class="modal fade" id="modal-{{$candidate->id}}">
                <div class="modal-dialog">
                    <form class="modal-content" method="post" action="/enroll/candidates/{{$candidate->id}}">
                        {!! method_field('DELETE') !!}
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-left">Удалить абитуриента</h4>
                        </div>
                        <div class="modal-body text-left">
                            Удалить абитуриента {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
@endforeach
