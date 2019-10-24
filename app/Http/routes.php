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

Route::get('/', [
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

    Route::get('/admin/videoLists', [
        'as' => 'videoLists', 'uses' => 'Admin\VideoController@lists'
    ]);

//    Route::get('/teacher/admin/editProfile', [
//        'as' => 'tch.admin.editProfile', 'uses' => 'Teacher\TeacherController@editProfile'
//    ]);
//
//    Route::post('/teacher/admin/updateProfile', [
//        'as' => 'tch.admin.updateProfile', 'uses' => 'Teacher\TeacherController@updateProfile'
//    ]);
//
//    Route::post('/teacher/admin/acceptLectureRequestByAjax', [
//        'as' => 'tch.admin.acceptLectureRequestByAjax', 'uses' => 'Teacher\TeacherController@acceptLectureRequestByAjax'
//    ]);
//
//    Route::get('/teacher/admin/requestDetail/{request_id}', [
//        'as' => 'tch.admin.requestDetail', 'uses' => 'Teacher\TeacherController@requestDetail'
//    ]);
//
//    Route::get('/teacher/admin/order/confirmedLists', [
//        'as' => 'tch.admin.confirmedOrderLists', 'uses' => 'Teacher\OrderController@confirmedLists'
//    ]);
//
//    Route::get('/teacher/admin/order/inprogressLists', [
//        'as' => 'tch.admin.inprogressOrderLists', 'uses' => 'Teacher\OrderController@inprogressLists'
//    ]);
//
//    Route::get('/teacher/admin/order/deliveredLists', [
//        'as' => 'tch.admin.deliveredOrderLists', 'uses' => 'Teacher\OrderController@deliveredLists'
//    ]);
//
//    Route::get('/teacher/admin/order/canceledLists', [
//        'as' => 'tch.admin.canceledOrderLists', 'uses' => 'Teacher\OrderController@canceledLists'
//    ]);
//
//    Route::get('/teacher/admin/orderDetail/{order_id}', [
//        'as' => 'tch.admin.orderDetail', 'uses' => 'Teacher\OrderController@detail'
//    ]);
//
//    Route::post('/teacher/admin/orderCheckinByAjax', [
//        'as' => 'tch.admin.orderCheckinByAjax', 'uses' => 'Teacher\OrderController@orderCheckinByAjax'
//    ]);
//
//    Route::post('/teacher/admin/orderCheckoutByAjax', [
//        'as' => 'tch.admin.orderCheckoutByAjax', 'uses' => 'Teacher\OrderController@orderCheckoutByAjax'
//    ]);
//
//    Route::post('/teacher/admin/cancelLectureOrderByAjax', [
//        'as' => 'tch.admin.cancelLectureOrderByAjax', 'uses' => 'Teacher\OrderController@cancelLectureOrderByAjax'
//    ]);

});



