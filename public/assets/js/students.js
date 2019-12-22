var currentPageNumber = 1;
var filter = '';
var how = 'desc';
var specID = 0;
var subID = 0;

(function ($) {
    $('#ajaxLoadStudents').on('submit', function(event){
        loadCandidates(1);
        event.preventDefault()
    });

    $('.paginationAjax>ul>li>a').click(function(e){
        currentPageNumber = $(this).attr('href').split('page=')[1];
        loadCandidates(currentPageNumber);
        e.preventDefault();
    });
    $('.approve-next-sem').unbind().click(function (e) {
        data = {};
        $('.sems').each(function (i) {
            if ($(this).is(':checked')) {
                data[i] = $(this).val();
            }
        });
        $('#next-sem-modal').modal('hide');
        $.ajax({
            url         : "/dec/move-contingent/move/semester",
            type        : 'POST',
            data        : {groups: data, date:$('#sem-data').val(), number:$('#sem-number').val()},
            dataType    : 'json',
            success     : function(id) {
                $('#move-contingent').load('/dec/move-contingent');
                window.location.href = '/dec/orders/' + id;
            }
        });
        e.preventDefault();
    });
    $('.approve-next-course').unbind().click(function (e) {
        data = {};
        codes = {};
        titles = {};
        $('.courses').each(function (i) {
            if ($(this).is(':checked')) {
                data[i] = $(this).val();
            }
        });
        $('.codes').each(function (i) {
            codes[$(this).attr('data-id')] = $(this).val();
        });
        $('.titles').each(function (i) {
            titles[$(this).attr('data-id')] = $(this).val();
        });
        $('#next-course-modal').modal('hide');
        $.ajax({
            url         : "/dec/move-contingent/move/course",
            type        : 'POST',
            data        : {
                groups: data,
                date:$('#course-data').val(),
                number:$('#course-number').val(),
                codes: codes,
                titles: titles
            },
            dataType    : 'json',
            success     : function(id) {
                $('#move-contingent').load('/dec/move-contingent');
                window.location.href = '/dec/orders/' + id;
            }
        });
        e.preventDefault();
    });
    $('.approve-out').unbind().click(function (e) {
        data = {};
        $('.groups').each(function (i) {
            if ($(this).is(':checked')) {
                data[i] = $(this).val();
            }
        });
        $('#out-modal').modal('hide');
        $.ajax({
            url         : "/dec/move-contingent/move/out",
            type        : 'POST',
            data        : {groups: data, date:$('#out-data').val(), number:$('#out-number').val()},
            dataType    : 'json',
            success     : function(id) {
                $('#move-contingent').load('/dec/move-contingent');
                window.location.href = '/dec/orders/' + id;
            }
        });
        e.preventDefault();
    });

    $('.sort-link').unbind().click(function (e) {
        $('.sort-link').show();
        $(this).hide();
        filter = $(this).attr('data-filter');
        how = $(this).attr('data-how');
        loadCandidates(currentPageNumber);
        e.preventDefault();
    });
    $('.btn-set-output').unbind().click(function (e) {
        setTimeout(function(){
            $('.cb-move-student').each(function () {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').remove();
                }
            });
        }, 1000);
    });

    $('select[name=specs]').unbind().change(function () {
        specID = $(this).val();
        loadCandidates(1)
    });

    $(document).on('change', '#next-sem', function () {
        if ($(this).is(':checked')) {
            $('.sems').prop('checked', true);
            $('#next-sem-btn').removeClass('disabled');
        } else {
            $('.sems').prop('checked', false);
            $('#next-sem-btn').addClass('disabled');
        }
    });
    $(document).on('change', '.sems', function () {
        $('#next-sem').prop('checked', false);
        if ($('.sems:checked').length) {
            $('#next-sem-btn').removeClass('disabled');
        } else {
            $('#next-sem-btn').addClass('disabled');
        }
    });
    $(document).on('change', '#next-course', function () {
        if ($(this).is(':checked')) {
            $('.courses').prop('checked', true);
            $('#next-course-btn').removeClass('disabled');
        } else {
            $('.courses').prop('checked', false);
            $('#next-course-btn').addClass('disabled');
        }
    });
    $(document).on('change', '.courses', function () {
        $('#next-course').prop('checked', false);
        if ($('.courses:checked').length) {
            $('#next-course-btn').removeClass('disabled');
        } else {
            $('#next-course-btn').addClass('disabled');
        }
    });
    $(document).on('change', '#out-group', function () {
        if ($(this).is(':checked')) {
            $('.groups').prop('checked', true);
            $('#out-group-btn').removeClass('disabled');
        } else {
            $('.groups').prop('checked', false);
            $('#out-group-btn').addClass('disabled');
        }
    });
    $(document).on('change', '.groups', function () {
        $('#out-group').prop('checked', false);
        if ($('.groups:checked').length) {
            $('#out-group-btn').removeClass('disabled');
        } else {
            $('#out-group-btn').addClass('disabled');
        }
    });
    $(document).on('click', '#next-course-btn', function () {
        var html = '';
        $('.courses').each(function (i) {
            if ($(this).is(':checked')) {
                html += '<div class="row">' +
                    '<div class="col-sm-6">' +
                    '<input class="form-control codes" data-id="'+$(this).val()+'" placeholder="Код группы" value="'+$(this).attr('data-code')+'">' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                    '<input class="form-control titles" data-id="'+$(this).val()+'" placeholder="Наименование" value="'+$(this).attr('data-title')+'">' +
                    '</div>' +
                    '</div>';
            }
        });
        $('#code-groups').html(html);
    });
}(jQuery));

function loadCandidates(page)
{
    $.ajax({
        url         : "/getListStudents?page=" + page,
        type        : 'POST',
        data        : {filter: filter, how: how, specID: specID, _token: $('input[name=_token]').val(), subID: subID},
        dataType    : 'json',
        success     : function(res)
        {
            $('#dynamicLoadDataTableStudents').empty().html(res.table);
            $('.paginationAjax').empty().html(res.pages);

            $('.paginationAjax>ul>li>a').click(function(e){
                currentPageNumber = $(this).attr('href').split('page=')[1];
                loadCandidates(currentPageNumber);
                e.preventDefault();
            });
        }
    })
}

