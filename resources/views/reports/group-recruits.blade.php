<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .table-header td{
            font-weight: bold;
        }

    </style>

    <table>
        @foreach($listGroups as $group)
            <tr class="group-header">
                <td colspan="4"> {{ mb_strtoupper($group->title) }} </td>
            </tr>

            @php($i = 1)
            @php($listStudents = \App\Models\Candidate::getStudentsOfGroup($group->id))

            <tr class="table-header">
                <td>№</td>
                <td>Ф.И.О. студента</td>
                <td>Дата рождения</td>
                <td>Возраст</td>
            </tr>

            @foreach($listStudents as $student)
                <tr>
                    <td> {{ $i++ }} </td>
                    <td> {{ $student->last_name.' '.$student->first_name }} </td>
                    <td> {{ date('d.m.Y', strtotime($student->birth_date)) }} </td>
                    <td> {{ age($student->birth_date) }} </td>
                </tr>
            @endforeach
            <tr>
                <td> </td>
            </tr>

        @endforeach

    </table>
</html>
