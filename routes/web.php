<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'MainController@index');

Auth::routes();

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/previous', 'HomeController@PreviousPhoto');
    Route::get('/next', 'HomeController@NextPhoto');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('/photo', 'PhotoController');

    Route::group(['prefix' => 'photo'], function () {

    });

    Route::resource('/page', 'PageController');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('p/{id}', 'MainController@ViewPage');

    Route::group(['prefix' => 'survey'], function () {
        Route::get('{id}', 'SimpleSurveyController@getSurvey');
        //Route::post('{id}', 'SurveyController@postSurvey');
        //Route::get('{id}/step/{step}', 'SurveyController@generateSurvey');
        Route::post('{id}/step/{step}', 'SimpleSurveyController@postSurveyStep');
        Route::get('previous/{id}/{step}', 'SimpleSurveyController@previousStep');
        Route::get('done/{id}', 'SimpleSurveyController@getSurveyDone');
    });
});

