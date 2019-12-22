<?php

Route::group(['prefix' => 'training'], function () {
    Route::resource('pulpits', 'Training\PulpitsController');
    Route::resource('disciplines', 'Training\DisciplinesController');
    Route::resource('competences', 'Training\CompetencesController');
    Route::resource('halls', 'Training\HallsController');
    Route::resource('plans', 'Training\PlanController');
    Route::resource('reports', 'Training\ReportsController');
    Route::post('schedules/ajax',  'Training\SchedulesController@ajax');
    Route::get('schedules',  'Training\SchedulesController@index');
    Route::post('schedules',  'Training\SchedulesController@store');
    Route::post('schedules/drop/{id}',  'Training\SchedulesController@drop');
    Route::post('schedules/update/event',  'Training\SchedulesController@update');
    Route::post('schedules/{id}',  'Training\SchedulesController@show');
    Route::post('schedules/delete/{id}',  'Training\SchedulesController@destroy');
    //Route::resource('schedules', 'Training\SchedulesController');
    Route::get('plans/{planId}/disciplines/{courseId}/{semesterId}',  'Training\PlanController@disciplines');
    Route::post('plans/{planId}/disciplines/{courseId}/{semesterId}',  'Training\PlanController@disciplinesStore');
    Route::post('plans/disciplines/form',  'Training\PlanController@disciplinesLoadForm');
});