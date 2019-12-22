<?php

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/home', 'HomeController@index');
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@store');

    Route::group(['middleware' => 'admin'], function ()
    {
        /* Справочники */
        Route::get('/dic-type', 'DictionaryController@dictionaryType');
        Route::get('/dic-type/create', 'DictionaryController@dictionaryTypeCreate');
        Route::post('/dic-type/store', 'DictionaryController@dictionaryTypeStore');
        Route::post('/dic-type/update/{id}', 'DictionaryController@dictionaryTypeUpdate');
        Route::post('/dic-type/delete/{id}', 'DictionaryController@dictionaryTypeDestroy');

    });

    Route::group(['middleware' => 'dictionary'], function () {

        Route::get('/dic-type/edit/{slug}', 'DictionaryController@dictionaryTypeEdit');
        Route::post('/dic/store', 'DictionaryController@dictionaryStore');
        Route::post('/dic/update/{id}', 'DictionaryController@dictionaryUpdate');
        Route::post('/dic/delete/{id}', 'DictionaryController@dictionaryDestroy');

    });

    Route::group(['middleware' => 'principal'], function ()
    {
        Route::resource('college/teachers', 'TeachersController');
        Route::get('/college', 'ProfileController@college');
        Route::post('/college', 'ProfileController@storeCollege');
        Route::resource('dic/specializations', 'SpecializationsController');
        Route::resource('dic/schools', 'SchoolsController');
        Route::resource('dec/groups', 'GroupsController');
        Route::resource('dic/courses', 'CoursesController');
        Route::resource('college/subdivisions', 'SubdivisionsController');
        Route::resource('college/events', 'EventsController');
        Route::resource('dic/enrollment-reasons', 'EnrollmentReasonsController');

        /* Движение, отчисление, выпуск контингента */
        Route::get ('dec/move-contingent', 'StudentsController@moveContingent');
        Route::get ('dec/output-contingent', 'StudentsController@outputContingent');
        Route::get ('dec/output-students/{group_id}', 'StudentsController@outputStudents');
        Route::post('dec/move-protocol', 'ProtocolController@moveProtocol');
        Route::post('dec/pre-move-download', 'ProtocolController@preMoveDownload');
        Route::get ('dec/move-download/{protocol_id}', 'ProtocolController@moveDownload');
        Route::post('/dec/move-contingent/move/{type}', 'StudentsController@moveMove');
        Route::get ('dec/output', 'StudentsController@output');
        Route::get ('dec/deduct', 'StudentsController@deduct');

        /* Отчеты */


        /* Приказы */
        Route::any('/dec/protocol', 'ProtocolController@index');
        Route::get('/dec/orders/{pid}', 'ProtocolController@download');
        Route::any('/dec/protocol/candidates', 'ProtocolController@candidates');
    });

    Route::get('/dec/reports', 'ReportController@index');
    Route::get('/reports-group', 'ReportController@groupStudent');
    Route::get('/reports-recruits', 'ReportController@groupRecruits');
    Route::get('/enroll/reports', 'ReportController@reportsCommission');
    Route::post('/group-student-single', 'ReportController@groupStudentSingle');
    Route::post('/group-student-parent', 'ReportController@groupStudentParent');
    Route::get('/reports-abirs', 'ReportController@groupCandidates');

    Route::resource('enroll/candidates', 'CandidatesController');
    Route::resource('dec/students', 'StudentsController');
    Route::resource('dec/faculties', 'FacultiesController');
    Route::post('/getListCandidates', 'AjaxController@candidates');
    Route::post('/getListStudents', 'AjaxController@students');
    Route::post('/saveRate', 'AjaxController@saveRate');
    Route::get('file/doc/{id}','FileController@getDoc');
    Route::get('/generateDoc/{id}', ['as' => 'doc.statement', 'uses' => 'FileController@generateStatement']);
    Route::post('/export/rate', 'FileController@excelRate');
    Route::get('/export/kcp', 'FileController@excelKcp');
    Route::get('/export/list', 'FileController@excelList');
    Route::get('/export/all-abirs', 'ExportController@allAbirs');
    Route::get('/export/region-abirs', 'ExportController@regionAbirs');
    Route::get('/export/journal/{type}', 'ExportController@journal');
    Route::post('/candidates/filterSpecialization', 'FormationOfOrdersController@showCandidates');
    Route::get('/candidates/filterSpecialization/protocol/download/{spec}', 'FormationOfOrdersController@generateProtocolCommission');
    Route::get('/candidates/filterSpecialization/generateOrderInstall/download/{spec}', 'FormationOfOrdersController@generateOrderInstall');
    Route::get('/enroll', 'EnrollmentController@index');
    Route::get('/api/groups/{id?}', 'EnrollmentController@getGroupBySpec');
    Route::post('enroll-filter', 'EnrollmentController@filter');
    Route::post('enroll-group/{group}', 'EnrollmentController@setGroup');
    Route::post('enroll/protocol', 'EnrollmentController@protocol');
    Route::post('enroll/order', 'EnrollmentController@order');
    Route::get('enroll/approve', 'EnrollmentController@approveOrder');

    Route::group(['middleware' => 'analyst'], function ()
    {
        Route::get('/statistics', 'AnalystController@statistics');
        Route::get('/dynamics', 'AnalystController@dynamics');
        Route::get('/dynamics-to-chart', 'AnalystController@getDynamicsToChart');
    });
    Route::get('export/spo-1', 'ExportController@spo');
});

Route::group(['prefix' => 'api'], function (){
    Route::get('colleges', 'ApiController@collegesAutocomplete');
    Route::get('cities', 'ApiController@citiesAutocomplete');
    Route::get('regions', 'ApiController@regionsAutocomplete');
    Route::get('commission/{id}', 'ApiController@commission');
    Route::get('schools', 'ApiController@schoolsAutocomplete');
    Route::get('getCitiesFromRegion', 'ApiController@getCities');
    Route::get('getNames', 'ApiController@autoCompleteName');
    Route::get('getFamily', 'ApiController@autoCompleteFamily');
    Route::get('getMiddleName', 'ApiController@autoCompleteMiddleName');
    Route::any('specs', 'ApiController@specs');
    Route::any('subdivs', 'ApiController@subdivs');

    Route::any('upload', 'ApiController@upload');
    Route::any('remove-file', 'ApiController@removeFile');
    Route::any('get-groups/{specID}', 'ApiController@getGroups');
});

