$(document).ready(function () {

    $('select[name=specialization_id]').change(function () {
        $('select[name=group_id]').load('/api/groups/' + $(this).val(), function () {
            $('select[name=group_id]').val('');
        });
    });

    $('.enroll-filter select').change(loadCandidates);
    $('.enroll-filter input').change(loadCandidates);

    $('.master-check').change(function () {
        if ($(this).is(':checked')) {
            $('.child-check').prop('checked', true)
        } else {
            $('.child-check').prop('checked', false)
        }
        diaAvaButtons();
    });

    $('.datepicker').datepicker({autoclose: true, todayHighlight: false, format: "dd.mm.yyyy", "locale": "ru"});

    $(document).on('change', '.child-check', diaAvaButtons);

    $('.child-check').change(diaAvaButtons);

    $('.ava-btn').click(function (e) {
        if ($(this).hasClass('disroll-btn')) {
            status = 0;
        } else {
            status = 1;
        }
        var candidates = [];
        $('.child-check').each(function () {
            if ($(this).is(':checked')) {
                candidates.push($(this).val());
            }
        });
        var group = $('select[name=group]').val();
        $.ajax({
            url: '/enroll-group/' + group,
            type: 'POST',
            data: {candidates: candidates, status: status},
            success: function () {
                $('input[type=checkbox]').prop('checked', false);
                loadCandidates();
            }
        });
        e.preventDefault();
    });

    $('.checkProtContinue').click(function () {
        $('#setProtocol').modal('hide');
    });

    $('.checkOrContinue').click(function () {
        $('#setOrder').modal('hide');
        $('.approve-order').show();
    });
});

function diaAvaButtons() {
    var checks = 0;
    $('.child-check').each(function () {
        if ($(this).is(':checked')) {
            checks++;
        }
    });
    if (checks > 0) {
        $('.ava-btn').prop('disabled', false);
    } else {
        $('.ava-btn').prop('disabled', true);
    }
}

function loadCandidates() {
    data = $('.enroll-filter select').serialize();
    console.log(data);
    $.ajax({
        url: '/enroll-filter',
        type: 'POST',
        data: data,
        success: function (answer) {
            $('#tableEnrollCandidates').html(answer);
            $('input[type=checkbox]').prop('checked', false);
            diaAvaButtons();
        }
    });
}