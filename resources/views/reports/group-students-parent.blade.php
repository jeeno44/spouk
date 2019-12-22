<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .table-header td{
            font-weight: bold;
        }

    </style>

    <table>

        <tr class="table-header">
            <td>№</td>
            <td>Ф.И.О. студента</td>
            <td>Ф.И.О родителя</td>
            <td>Телефон родителя</td>
        </tr>

        @php($j = 1)
        @foreach($listStudents as $student)
            <tr>
                <td> {{ $j++ }} </td>
                <td> {{ $student->last_name.' '.$student->first_name }} </td>

                @if(count($student->parents) > 0)
                    <td>{{getParentType($student->parents[0]->type).' - '.$student->parents[0]->fio }} </td>
                    <td>{{$student->parents[0]->phone}}</td>
                @endif
            </tr>

            @if(count($student->parents) > 1)
                @for($i = 1; $i < count($student->parents); $i++)
                    <tr>
                        <td></td><td></td>
                        <td>{{getParentType($student->parents[$i]->type).' - '.$student->parents[$i]->fio }} </td>
                        <td>{{$student->parents[$i]->phone}}</td>
                    </tr>
                @endfor
            @endif

            <tr>
                <td> </td>
            </tr>

        @endforeach
    </table>
</html>
