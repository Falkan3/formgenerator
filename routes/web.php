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

    Route::group(['prefix' => 'survey'], function () {
        Route::get('index', 'SurveyController@showSurveySteps');
        Route::get('show', 'SurveyController@showSurveyResults');
        Route::get('show/{id}/{step}', 'SurveyController@showSurveyResults');
        Route::get('allresults/{id}', 'SurveyController@showAllResults');
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::get('p/{id}', 'MainController@ViewPage');

    Route::group(['prefix' => 'survey'], function () {
        Route::get('gen/{id}/{step}', 'SimpleSurveyController@generateSurvey');
        //Route::get('previous/{id}/{step}', 'SimpleSurveyController@previousStep');
        Route::post('{id}/step/{step}', 'SimpleSurveyController@postSurveyStep');
        Route::get('{id}', 'SimpleSurveyController@getSurvey');
    });
});

