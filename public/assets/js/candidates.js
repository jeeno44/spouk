var phoneCount = 1;
var docsCount  = 1;
var currentPageNumber = 1;
var filter = '';
var how = 'desc';
var specID = 0;
var parentCount = 1;
var subID = 0;

(function ($) {
    autoCompleteSchools()
    $('#region_candidates').change(loadCitys)
    $('#citiesCandidates').change(autoCompleteSchools)
    $('#schools').keydown(function(){
        $('input[name=school_id]').val('');
    })
    url = window.location.pathname;
    if (url.indexOf("students/create") >= 0) {
        loadGroup();
    }
    $('select[name=specialization_id]').change(loadGroup);

    $('.js-datepicker').datepicker({autoclose: true, todayHighlight: false, format: "dd.mm.yyyy"});

    $('#addPhoneDynamic').on("click", function( event ) {
        addPhone()
        event.preventDefault()
    });

    $('#add-parent').on("click", function( event ) {
        addParent();
        event.preventDefault()
    });

    $('#addDocsDynamic').on("click", function( event ) {
        addDoc()
        event.preventDefault()
    });

    $('.btn-file').click(function (e) {
        $(this).closest('.files-block').find('input[type=file]').trigger('click');
        e.preventDefault();
    });
    $('.file-input').change(function () {
        var fullPath =$(this).val();
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $(this).closest('.files-block').find('.filename').text(filename);
        }
    });

    autoCompleteName('getFamily');
    autoCompleteName('getNames');
    autoCompleteName('getMiddleName');

    $('#specializationSelect').select2();


    $('#ajaxLoadCandidates').on('submit', function(event){
        loadCandidates(1)
        event.preventDefault()
    })

    $('.paginationAjax>ul>li>a').click(function(e){
        currentPageNumber = $(this).attr('href').split('page=')[1];
        loadCandidates(currentPageNumber);
        e.preventDefault();
    });

    $('.sort-link').click(function (e) {
        $('.sort-link').show();
        $(this).hide();
        filter = $(this).attr('data-filter');
        how = $(this).attr('data-how');
        loadCandidates(currentPageNumber);
        e.preventDefault();
    })

    $('.export-rate').click(function (e) {
        if (specID == 0) {
            e.preventDefault();
            $('#selectSpecs').modal('show');
        } else {
            window.location.href='/export/rate/'+specID;
        }
    });

    $('.setDocument').click(function (e) {
        action = $(this).attr('data-actionID');
        if (specID == 0) {
            e.preventDefault();
            $('#selectSpecs').modal('show');
        } else {
            if (action == 1) {
                window.location.href='/candidates/filterSpecialization/protocol/download/'+specID;
            } else {
                window.location.href='/candidates/filterSpecialization/generateOrderInstall/download/'+specID;
            }
        }
    });

    /**
     * file uploader start
     */
    $('#add-file').click(function (e) {
        $('#file-uploader').trigger('click')
    });
    $('#file-uploader').change(function () {
        uploadImage($(this), $('#file-wrap'))
    });
    $(document).on('click', '.remove-file', function(e) {
        var path = $(this).attr('data-path');
        $(this).closest('.file-item').remove();
        e.preventDefault();
        $.ajax({
            url: '/api/remove-file',
            type: 'POST',
            data: {path: path, _token: $('input[name=_token]').val()}
        });
    });
    /**
     * file uploader end
     */

    $('#address-two').click(function (e) {
        e.preventDefault();
        $('input[name=address]').val($('input[name=law_address]').val())
    });
    $('.yy-datepicker').datepicker({autoclose: true, todayHighlight: false, format: "yyyy", minViewMode:2});
    $('select[name=subdivs]').change(function () {
        subID = $(this).val();
        loadCandidates(1)
        $('select[name=specs]').load("/api/specs?subID="+subID)
    });
    $('select[name=specs]').change(function () {
        specID = $(this).val();
        loadCandidates(1)
    });
}(jQuery));

function autoCompleteSchools() {
    $("#schools").autocomplete({
        source: "/api/schools?" + 'city_id=' + $('select[name=city_id]').val() + '&region_id=' + $('select[name=region_id]').val(),
        minLength: 2,
        select: function (event, ui) {
            $('input[name=school_id]').val(ui.item.id);
            $('#schools').val(ui.item.title)
        }
    }).focus(function () {
        $(this).keydown();
    });
}

function loadCandidates(page)
{
    $.ajax({
        url         : "/getListCandidates?page=" + page,
        type        : 'POST',
        data        : {filter: filter, how: how, specID: specID, _token: $('input[name=_token]').val(), subID: subID},
        dataType    : 'json',
        success     : function(res)
        {
            $('#dynamicLoadDataTableCandidates').empty().html(res.table);
            $('.paginationAjax').empty().html(res.pages);

            $('.paginationAjax>ul>li>a').click(function(e){
                currentPageNumber = $(this).attr('href').split('page=')[1];
                loadCandidates(currentPageNumber);
                e.preventDefault();
            });
        }
    })
}

function autoCompleteName(name) {
    $("#"+name).autocomplete({
        source: "/api/" + name,
        minLength: 1,
        select: function (event, ui) {
            $("#"+name).val(ui.item.title)
        }
    }).focus(function () {
        $(this).keydown();
    });
}

function loadCitys()
{
    $.getJSON('/api/getCitiesFromRegion?region_id=' + $('select[name=region_id]').val(), function(json)
    {
        var $el = $("#citiesCandidates");
        $el.empty(); // remove old options
        $.each(json.cities, function(value,key) {
            $el.append($("<option></option>").attr("value", value).text(key));
        });

        autoCompleteSchools()
    })
}

function addPhone()
{
    var html = '<div id="phone_'+phoneCount+'" class="row phone-row">'
    html += '<div class="col-md-3">'
    html += '<input name="phones['+phoneCount+'][phone]" type="text" class="form-control">'
    html += '<p class="help-block">Номер телефона</p>'
    html += '</div>'
    html += '<div class="col-md-6">'
    html += '<input name="phones['+phoneCount+'][comment]" type="text" class="form-control">'
    html += '<p class="help-block">Комментарий к номеру</p>'
    html += '</div>'
    html += '<div class="control-label col-md-3">'
    html += '<a href="#" onclick="removePhone('+phoneCount+');return false;" data-id="'+phoneCount+'">'
    html += '<i class="fa fa-remove"></i>&nbsp;Удалить телефон</a>'
    html += '</div></div>'

    $('#dynamicPhones').append(html)
    phoneCount++
}

function removeDoc(id)
{
    $('#doc_'+id).remove()
    docsCount--
}

function addDoc()
{
    var html = '<div id="doc_'+docsCount+'" class="row doc-row">'
    html += '<div class="col-md-4 files-block">'
    html += '<input name="docs['+docsCount+'][file]" type="file" class="form-control col-lg-3">'
    html += '<p class="help-block">Укажите файл</p>'
    html += '</div>'
    html += '<div class="col-md-4">'
    html += '<input name="docs['+docsCount+'][comment]" type="text" class="form-control">'
    html += '<p class="help-block">Комментарий к файлу</p>'
    html += '</div>'
    html += '<div class="control-label col-md-3">'
    html += '<a href="#" onclick="removeDoc('+docsCount+');return false;" data-id="'+docsCount+'">'
    html += '<i class="fa fa-remove"></i>&nbsp;Удалить файл</a>'
    html += '</div></div>'

    $('#dynamicDocs').append(html)
    docsCount++
}

function addParent()
{
    var html = '<div id="par_'+parentCount+'" class="row doc-row">'
    html += '<div class="col-md-3 parents-block">'
    html += '<select name="parents['+parentCount+'][type]" class="form-control">'
    html += '<option value="mom">Мать</option>'
    html += '<option value="dad">Отец</option>'
    html += '<option value="other">Иной законный представитель</option>'
    html += '</select>'
    html += '</div>'
    html += '<div class="col-md-8"><div class="col-md-6">'
    html += '<input name="parents['+parentCount+'][fio]" type="text" class="form-control">'
    html += '<p class="help-block">ФИО</p>'
    html += '</div>'
    html += '<div class="col-md-6">'
    html += '<input name="parents['+parentCount+'][phone]" type="text" class="form-control">'
    html += '<p class="help-block">Телефон</p>'
    html += '</div>'
    html += '<div class="col-md-6">'
    html += '<input name="parents['+parentCount+'][year]" type="text" class="form-control yy-datepicker">'
    html += '<p class="help-block">Год рождения</p>'
    html += '</div>'
    html += '<div class="col-md-6">'
    html += '<input name="parents['+parentCount+'][worklace]" type="text" class="form-control">'
    html += '<p class="help-block">Место работы</p>'
    html += '</div></div>'
    html += '<div class="control-label col-md-1">'
    html += '<a href="#" onclick="removeParent('+parentCount+');return false;" data-id="'+parentCount+'">'
    html += '<i class="fa fa-remove"></i>&nbsp;Удалить</a>'
    html += '</div></div>'

    $('#parents-wrap').append(html)
    parentCount++
    $('.yy-datepicker').datepicker({autoclose: true, todayHighlight: false, format: "yyyy", minViewMode:2});
}

function removePhone(id)
{
    $('#phone_'+id).remove()
    phoneCount--
}

function removeParent(id)
{
    $('#par_'+id).remove()
    parentCount--;
}

function showRateEdit(ob)
{
    var candidate_id = $(ob).attr('data-id');
    $('#rate_' + candidate_id).css('display', 'block');
    $('#rate_input_' + candidate_id).focus();
    $('#link_rate_' + candidate_id).css('display', 'none');
}

function cancelRateEdit(id)
{
    $('#rate_' + id).css('display', 'none')
    $('#link_rate_' + id).css('display', 'inline')
}

function saveRate(id)
{
    $.ajax({
        url         : "/saveRate",
        type        : 'POST',
        data        : {rate: $('#rate_input_' + id).val(), candidate_id: id, '_token': $('input[name=_token]').val()},
        success     : function(res)
        {
            $('#link_rate_' + id).html($('#rate_input_' + id).val())
            cancelRateEdit(id)
        }
    })
}

function uploadImage (fInput, filesWrap)
{
    var data = new FormData();
    var error = '';
    jQuery.each(fInput[0].files, function(i, file) {
        if(file.name.length < 1) {
            error = error + 'Файл имеет неправильный размер!';
        }
        data.append('files', file);
    });
    data.append('_token', $('input[name=_token]').val());
    if (error == '') {
        $.ajax({
            url: '/api/upload',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData:false,
            success: function(data) {
                filesWrap.append(data);
            }
        });
    }
}

function loadGroup() {
    spec = $('select[name=specialization_id]').val();
    $('select[name=group_id]').load('/api/get-groups/' + spec);
}
