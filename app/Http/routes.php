<?php
Route::group(['domain' => config('app.domain')], function () {
    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin'], function () {
        Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);
        Route::resource('pages', 'Admin\PagesController');
        Route::get('logout', function () {
            Auth::logout();
            return redirect('admin/login');
        });
        Route::resource('articles', 'Admin\ArticlesController');
        Route::resource('banners', 'Admin\BannersController');
        Route::resource('letters', 'Admin\FeedbackController');
    });

    Route::get('/feedback', 'FrontendController@getFeedback');
    Route::post('/feedback', 'FrontendController@postFeedback');
    Route::get('/', ['as'=>'main','uses'=>'FrontendController@index']);
    Route::get('/sub-system/{id?}', 'HomeController@changeEducationSystem');
    Route::get('auth/two-step', 'Auth\AuthController@getTwoStep');
    Route::post('auth/two-step', 'Auth\AuthController@postTwoStep');
    Route::auth();
    Route::get('registered', 'Auth\AuthController@registered');
    Route::get('activate', 'Auth\AuthController@activate');
    Route::get('/news/{slug?}', 'FrontendController@news');
    Route::get('/{page}', 'FrontendController@page');

    Route::any('callback/statement', ['as' => 'callback.statement', 'uses' => 'FileController@callbackStatement']);
});
Route::group(['domain' => 'spo.'.config('app.domain'), 'middleware' => 'check'], function () {
    Route::get('/', 'HomeController@index');
    include 'base.php';
    include 'training.php';
});
Route::group(['domain' => 'vo.'.config('app.domain'), 'middleware' => 'check'], function () {
    Route::get('/', 'HomeController@index');
    include 'base.php';
    include 'training.php';
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
Route::get('/qauth/{id}', function($id) {
    $user = \App\Models\User::find($id);
    Auth::login($user);
    if ($user->college->systems->count() == 1) {
        if ($user->college->systems->first()->id == 1) {
            return redirect('http://spo.'.config('app.domain'));
        }
        if ($user->college->systems->first()->id == 2) {
            return redirect('http://vo.'.config('app.domain'));
        }
    } else {
        return redirect('sub-system');
    }
});

Route::get('test', ['middleware' => 'check_role:owner,view,test,principal', function() {

}]);