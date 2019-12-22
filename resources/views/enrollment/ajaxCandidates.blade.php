@foreach ($candidates as $candidate)
    <tr>
        <td>
            {!! Form::checkbox('candidates[]', $candidate->id, null, ['class' => 'child-check']) !!}
        </td>
        <td @if(!empty($candidate->is_invalid1)) style="border-left: 3px solid #d4fad6;" @endif>
            #{{$candidate->reg_number}}
        </td>

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
        <td>
            @if(!empty($candidate->group)) {{$candidate->group->title}} @else - @endif
        </td>
    </tr>
@endforeach
