(function ($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    "use strict";

    $('.show-next').click(function (e) {
        $($(this).attr('data-target')).removeClass('hidden').show();
        $(this).hide();
        e.preventDefault();
    });
    
    $('input[name=is_commission]').change(function () {
        var id = $(this).val();
        $.ajax({
            url: "/api/commission/" + id,
        });
    });
    
    $('input.input-mask').inputmask();

    $('#idListGroupsSelect').select2();
    $('#idListTeacherSelect').select2();

    $('.append-doc').click(function (e) {
        $(this).parent().find('.appdoc').trigger('click');
        e.preventDefault();
    });
    $('.appdoc').change(function () {
        var filename = $(this).val().split('\\').pop();
        $(this).parent().find('span').text(filename);
    });
    $('[data-toggle=tooltip]').tooltip();
    showInternalPass();
    $('input[name=is_russian]').change(showInternalPass);
    $('.dpi').datepicker({format: 'dd.mm.yyyy', language: 'ru', locale: 'ru'});
    $('.dtp').datetimepicker();
}(jQuery));

function showInternalPass() {
    if ($('input[name=is_russian]:checked').val() == 1) {
        $('.ru-passport').show().find('input').prop('required', true);
        $('.in-passport').hide().find('textarea').prop('required', false);
    } else {
        $('.ru-passport').hide().find('input').prop('required', false);
        $('.in-passport').show().find('textarea').prop('required', true);
    }
}

function autoCompleteColleges() {
    $("#colleges").autocomplete({
        source: "/api/colleges?city_id=" + $('input[name=city_id]').val() + '&region_id=' +  + $('input[name=region_id]').val(),
        minLength: 0,
        select: function(event, ui) {
            $('input[name=college_id]').val(ui.item.id);
            $('input[name=city_id]').val(ui.item.city);
            $('input[name=region_id]').val(ui.item.region);
            $('#regions').val(ui.item.region_name);
            $('#cities').val(ui.item.city_name);
            autoCompleteRegions();
            autoCompleteCities();
        }
    }).focus(function(){
        $(this).keydown();
    });
}

function autoCompleteCities() {
    $("#cities").autocomplete({
        source: "/api/cities?&region_id=" +  + $('input[name=region_id]').val(),
        minLength: 0,
        select: function(event, ui) {
            $('input[name=college_id]').val('');
            $('#colleges').val('');
            $('input[name=city_id]').val(ui.item.id);
            $('input[name=region_id]').val(ui.item.region);
            $('#regions').val(ui.item.region_name);
            autoCompleteRegions();
            autoCompleteColleges();
        }
    }).focus(function(){
        $(this).keydown();
    });
}

function autoCompleteRegions() {
    $("#regions").autocomplete({
        source: "/api/regions",
        minLength: 0,
        select: function(event, ui) {
            $('input[name=college_id]').val('');
            $('#colleges').val('');
            $('input[name=city_id]').val('');
            $('input[name=region_id]').val(ui.item.id);
            $('#cities').val('');
            autoCompleteCities();
            autoCompleteColleges();
        }
    }).focus(function(){
        $(this).keydown();
    });
}
