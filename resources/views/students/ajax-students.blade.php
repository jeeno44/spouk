@foreach ($students as $candidate)
    <tr>
        <td @if(!empty($candidate->is_invalid1)) style="border-left: 3px solid #d4fad6;" @endif>
            #{{$candidate->reg_number}}
        </td>
        <td>
            {{$candidate->name_number}}
        </td>
        <td>
            <a href="/dec/students/{{$candidate->id}}">
                {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}
            </a>
        </td>

        <td style="text-align: left;">
            @if ($candidate->birth_date != '00.00.0000')
                {{date('d.m.Y', strtotime($candidate->birth_date))}} ({{$candidate->age}})
            @endif
        </td>

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
            @if(!empty($candidate->group))
                {{$candidate->group->title}}
            @endif
        </td>
        <td class="text-right">
            <a class="btn btn-info btn-sm" href="/dec/students/{{$candidate->id}}/edit"><i class="fa fa-pencil"></i> </a>
            <a class="btn btn-warning btn-sm" data-toggle="modal" href="#modal-{{$candidate->id}}"><i class="fa fa-times"></i> </a>

            <div class="modal fade" id="modal-{{$candidate->id}}">
                <div class="modal-dialog">
                    <form class="modal-content" method="post" action="/dec/students/{{$candidate->id}}">
                        {!! method_field('DELETE') !!}
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-left">Удалить студента</h4>
                        </div>
                        <div class="modal-body text-left">
                            Удалить студента {{$candidate->last_name}} {{$candidate->first_name}} {{$candidate->middle_name}}?
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
