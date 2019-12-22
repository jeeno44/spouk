$(document).ready(function () {

	 $('#cbAllStudent').change(function () {
        if ($(this).is(':checked')) {
            $('.cb-move-student').prop('checked', true)
        } else {
            $('.cb-move-student').prop('checked', false)
        }

        disabledButtons();
    });

    $('.datepicker').datepicker({autoclose: true, todayHighlight: false, format: "dd.mm.yyyy", "locale": "ru"});
    $(document).on('change', '.cb-move-student', disabledButtons);

    $('.cb-move-student').change(disabledButtons);
    $('#selectActionType').change(disabledButtons);

    $('.btn-move-contingent').click(function (e) {
		$("#moveProtocol").modal('show');
    });

	$('.btn-create-move-protocol').click(function (e) {
		var _token = $('input[name=_token]').val();

		var protocol_date = $('input[name=protocol_date]').val();
		var protocol_number = $('input[name=protocol_number]').val();
		var actionType = $('#selectActionType').val();
		var candidates = [];

        $('.cb-move-student').each(function () {
            if ($(this).is(':checked')) {
                candidates.push($(this).val());
            }
        });

        $.ajax({
            url: '/dec/move-protocol',
            type: 'POST',
            data: {candidates: candidates, actionType: actionType, _token: _token,
            	   protocol_date: protocol_date, protocol_number: protocol_number},

            success: function(response){
            	window.location.href = '/dec/pre-move-download/' + response;

            }
        });

        return false;

    });
});

function disabledButtons() {
    var checks = 0;
    $('.cb-move-student').each(function () {
        if ($(this).is(':checked')) {
            checks++;
        }
    });

    if (checks > 0) {
        $('.btn-move-contingent').prop('disabled', false);
    } else {
        $('.btn-move-contingent').prop('disabled', true);
    }

    var actionType = $('#selectActionType').val();
    if (actionType == '')
    	$('.btn-move-contingent').prop('disabled', true);
}

