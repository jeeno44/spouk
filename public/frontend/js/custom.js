(function ($) {
    "use strict";

    $('.show-next').click(function (e) {
        $($(this).attr('data-target')).removeClass('hidden').show();
        $(this).hide();
        $('input[name=new_college]').val(1);
        e.preventDefault();
    });

    autoCompleteCities();
    autoCompleteColleges();
    autoCompleteRegions();


}(jQuery));

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

(function ($) {
    $('#register-form').submit(function (e) {
        if ($('input[name=new_college]').val() == 1) {
            var checked = $(".sub-systems:checked").length;
            if(!checked) {
                $('#edu-systems').addClass('has-error').find('.help-block').text('Выберите минимум 1 значение');
                e.preventDefault();
            } else {
                $('#edu-systems').removeClass('has-error').find('.help-block').text('');
            }
        }
    })
}(jQuery));