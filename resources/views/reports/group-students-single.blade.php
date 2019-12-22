<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .table-header td{
            font-weight: bold;
        }

    </style>

    <table>
        @php($i = 1)
        <tr class="table-header">
            <td>№</td>
            <td>Ф.И.О. студента</td>
            <td>Год рождения</td>
        </tr>

        @foreach($listStudents as $student)
            <tr>
                <td> {{ $i++ }} </td>
                <td> {{ $student->last_name.' '.$student->first_name }} </td>
                <td> {{ date('Y', strtotime($student->birth_date)) }} </td>
            </tr>
        @endforeach
    </table>
</html>
