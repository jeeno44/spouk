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
                <td colspan="6"> {{ mb_strtoupper($group->title) }} </td>
            </tr>

            @php($i = 1)
            @php($listStudents = \App\Models\Candidate::getStudentsOfGroup($group->id))

            <tr class="table-header">
                <td>№</td>
                <td>Ф.И.О. студента</td>
                <td>Год рождения</td>
                <td>СНИЛС</td>
                <td>№ паспорта и серия</td>
                <td>№ медицинский полис</td>
                <td>Домашний адрес</td>
                <td>Телефон</td>
            </tr>

            @foreach($listStudents as $student)
                <tr>
                    <td> {{ $i++ }} </td>
                    <td> {{ $student->last_name.' '.$student->first_name }} </td>
                    <td> {{ date('Y', strtotime($student->birth_date)) }} </td>
                    <td> {{ $student->pension_certificate }} </td>
                    <td> {{ $student->passport_number }} </td>
                    <td> {{ $student->medical_number }} </td>
                    <td> {{ $student->address }} </td>
                    <td>
                        @foreach ($student->phones()->orderBy('id', 'desc')->get() as $phone)
                            {{$phone->phone}}
                            @break
                        @endforeach
                    </td>
                </tr>
            @endforeach
            <tr>
                <td> </td>
            </tr>

        @endforeach

    </table>
</html>
