$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var renderCalendar = function () {
    $('#calendar').fullCalendar({
        locale: 'ru',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: {
            url: '/training/schedules/ajax',
            type: 'POST'
        },
        editable: true,
        eventDrop:function (event) {
            $.ajax({
                url: '/training/schedules/drop/' + event.id,
                type: 'POST',
                data: {date: event.start.format()}
            });
        },
        eventClick: function(event, jsEvent, view) {
            $.ajax({
                url: '/training/schedules/' + event.id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#edit #event_id').val(data.id);
                    $('#edit input[name=date]').val(data.date);
                    $('#edit select[name=discipline_id]').val(data.discipline_id);
                    $('#edit select[name=hour_type_id]').val(data.hour_type_id);
                    $('#edit select[name=course_id]').val(data.course_id);
                    $('#edit select[name=semester_id]').val(data.semester_id);
                    $('#edit select[name=hall_id]').val(data.hall_id);
                    $('#edit').modal('show');
                    $('#remove').attr('data-id', data.id);
                }
            });
        }
        /*dayClick: function(date) {
            $('#dtp_1').val(date.format('DD.MM.YYYY') + ' 10:00');
            $('#create').modal('show');
        },*/
    });
}

$().ready(function () {

    $('#dtp_1').datetimepicker({
        locale: 'ru', stepping: 5
    });
    $('#dtp_2').datetimepicker({
        locale: 'ru', stepping: 5
    });
    $('#send').click(function (e) {
        var data = {};
        $('#create input, #create select').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });
        $.ajax({
            url: '/training/schedules',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function () {
                $('#calendar').fullCalendar('refetchEvents');
                $('#create').modal('hide');
            }
        });
        e.preventDefault();
    });
    $('#update').click(function (e) {
        var data = {};
        $('#edit input, #edit select').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });
        $.ajax({
            url: '/training/schedules/update/event',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function () {
                $('#calendar').fullCalendar('refetchEvents');
                $('#edit').modal('hide');
            }
        });
        e.preventDefault();
    });
    $('#remove').click(function (e) {
        var id = $(this).attr('data-id');
        if (id != '') {
            $.ajax({
                url: '/training/schedules/delete/' + id,
                type: 'POST',
                success: function () {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#edit').modal('hide');
                }
            });
        }
        e.preventDefault();
    });
    renderCalendar();
});








