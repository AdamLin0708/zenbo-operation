<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*---- Zenbo----*/

Route::get('/login', [
    'as' => 'home', 'uses' => 'HomeController@home'
]);

Route::post('/postLogin', [
    'as' => 'postLogin', 'uses' => 'HomeController@postLogin'
]);

Route::get('/admin/logout', [
    'as' => 'logout', 'uses' => 'HomeController@logout'
]);

/*----- 講師後台 -----*/
Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin/main', [
        'as' => 'main', 'uses' => 'Admin\HomeController@main'
    ]);

    Route::get('/admin/memberLists', [
        'as' => 'memberLists', 'uses' => 'Admin\HomeController@memberLists'
    ]);

    Route::get('/admin/videoAnswerLists/{user_id}', [
        'as' => 'videoAnswerLists', 'uses' => 'Admin\HomeController@videoAnswerLists'
    ]);

    Route::get('/admin/videoLists', [
        'as' => 'videoLists', 'uses' => 'Admin\VideoController@lists'
    ]);

    Route::get('/admin/videoCreate', [
        'as' => 'videoCreate', 'uses' => 'Admin\VideoController@create'
    ]);

    Route::post('/admin/videoCreatePost', [
        'as' => 'videoCreatePost', 'uses' => 'Admin\VideoController@createPost'
    ]);

    Route::get('/admin/videoEdit/{video_id}', [
        'as' => 'videoEdit', 'uses' => 'Admin\VideoController@edit'
    ]);

    Route::post('/admin/videoEditPost/{video_id}', [
        'as' => 'videoEditPost', 'uses' => 'Admin\VideoController@editPost'
    ]);

    Route::get('/admin/videoQuizCreate/{video_id}', [
        'as' => 'videoQuizCreate', 'uses' => 'Admin\VideoController@quizCreate'
    ]);

    Route::post('/admin/videoQuizCreatePost/{video_id}', [
        'as' => 'videoQuizCreatePost', 'uses' => 'Admin\VideoController@quizCreatePost'
    ]);

    Route::get('/admin/videoQuizEdit/{quiz_id}', [
        'as' => 'videoQuizEdit', 'uses' => 'Admin\VideoController@quizEdit'
    ]);

    Route::post('/admin/videoQuizEditPost/{quiz_id}', [
        'as' => 'videoQuizEditPost', 'uses' => 'Admin\VideoController@quizEditPost'
    ]);

    Route::get('/admin/getQuizListsByAjax/', [
        'as' => 'getQuizListsByAjax', 'uses' => 'Admin\VideoController@getQuizListsByAjax'
    ]);

    Route::get('/admin/videoQuizDelete/{quiz_id}', [
        'as' => 'videoQuizDelete', 'uses' => 'Admin\VideoController@quizDelete'
    ]);




});



