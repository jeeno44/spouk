<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .table-header td{
            font-weight: bold;
        }

    </style>

    <table>
        @php($listStudents = \App\Models\Candidate::where('college_id', \Auth::user()->college_id)->where('is_student', 0)->get())
        @php($i = 1)
        <tr class="table-header">
            <td>№</td>
            <td>Ф.И.О. абитуриента</td>
            <td>Год рождения</td>
            <td>Специальность</td>
            <td>СНИЛС</td>
            <td>№ паспорта и серия</td>
            <td>№ медицинский полис</td>
            <td>Домашний адрес</td>
            <td>Телефон</td>
        </tr>

        @foreach($listStudents as $student)
            <tr>
                <td> {{ $i++ }} </td>
                <td> {{ $student->last_name.' '.$student->first_name.' '.$student->middle_name }} </td>
                <td> {{ date('Y', strtotime($student->birth_date)) }} </td>
                <td>
                    @if(!empty($student->spec->title))
                        {{$student->spec->code}} - {{$student->spec->title}}
                    @endif
                </td>
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

    </table>
</html>
