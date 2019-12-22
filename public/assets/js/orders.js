(function ($) {

    "use strict";

    $('.pagination-orders').on('click', 'a', function (e) {
        getOrders($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });
    autoCompleteCandidates();
    $("#candidates").keyup(function () {
        if ($(this).val() == '') {
            $('input[name=person]').val(0);
            getOrders(1);
        }
    });
    $('select[name=type]').change(function () {
        getOrders(1);
    });
}(jQuery));

function getOrders(page) {
    $.ajax({
        url : '/dec/protocol?page=' + page,
        dataType: 'json',
        type: 'post',
        data: {person: $('input[name=person]').val(), type: $('select[name=type]').val()}
    }).done(function (data) {
        $('#orders-table').html(data[0]);
        $('.pagination-orders').html(data[1]);
    }).fail(function () {
        console.log('candidates could not be loaded.');
    });
}


function autoCompleteCandidates() {
    $("#candidates").autocomplete({
        source: "/dec/protocol/candidates",
        minLength: 1,
        select: function(event, ui) {
            $('input[name=person]').val(ui.item.id);
            getOrders(1);
        }
    }).focus(function(){
        if ($("#candidates").val() != '') {
            $("#candidates").val('');
            $('input[name=person]').val(0);
            getOrders(1);
        }
    });
}
