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

/*---- 講座媒合平台官網 ----*/

Route::get('/', [
    'as' => 'home', 'uses' => 'HomeController@home'
]);

Route::post('/lecture/createRequest', [
    'as' => 'lct.createRequest', 'uses' => 'LectureController@createRequest'
]);

Route::get('/lecture/searchRequest', [
    'as' => 'lct.searchRequest', 'uses' => 'LectureController@searchRequest'
]);

Route::post('/lecture/searchRequestPost', [
    'as' => 'lct.searchRequestPost', 'uses' => 'LectureController@searchRequestPost'
]);

Route::post('/lecture/cancelLectureRequestByAjax', [
    'as' => 'lct.cancelLectureRequestByAjax', 'uses' => 'LectureController@cancelLectureRequestByAjax'
]);

Route::get('/lecture/getLectureRequestServiceDatetimeByAjax', [
    'as' => 'lct.getLectureRequestServiceDatetimeByAjax', 'uses' => 'LectureController@getLectureRequestServiceDatetimeByAjax'
]);

Route::post('/lecture/rescheduleLectureRequestDatetimeByAjax', [
    'as' => 'lct.rescheduleLectureRequestDatetimeByAjax', 'uses' => 'LectureController@rescheduleLectureRequestDatetimeByAjax'
]);

Route::get('/lecture/getLectureOrderServiceDatetimeByAjax', [
    'as' => 'lct.getLectureOrderServiceDatetimeByAjax', 'uses' => 'LectureController@getLectureOrderServiceDatetimeByAjax'
]);

Route::post('/lecture/rescheduleLectureOrderDatetimeByAjax', [
    'as' => 'lct.rescheduleLectureOrderDatetimeByAjax', 'uses' => 'LectureController@rescheduleLectureOrderDatetimeByAjax'
]);


Route::get('/test', [
    'as' => 'lct.test', 'uses' => 'LectureController@test'
]);


Route::get('/lecture/getU2BContractByAjax', [
    'as' => 'lct.getU2BContractByAjax', 'uses' => 'LectureController@getU2BContractByAjax'
]);

Route::get('/company/login', [
    'as' => 'cpn.login', 'uses' => 'CompanyController@login'
]);

Route::post('/company/postLogin', [
    'as' => 'cpn.postLogin', 'uses' => 'CompanyController@postLogin'
]);

Route::get('/teacher/register', [
    'as' => 'tch.register', 'uses' => 'TeacherController@register'
]);

Route::get('/teacher/getU2TContractByAjax', [
    'as' => 'tch.getU2TContractByAjax', 'uses' => 'TeacherController@getU2TContractByAjax'
]);

Route::post('/teacher/registerPost', [
    'as' => 'tch.registerPost', 'uses' => 'TeacherController@registerPost'
]);

Route::get('/teacher/registerSuccess', function(){
    return view('teacher.registerSuccess');
});

Route::get('/teacher/login', [
    'as' => 'tch.login', 'uses' => 'TeacherController@login'
]);

Route::post('/teacher/postLogin', [
    'as' => 'tch.postLogin', 'uses' => 'TeacherController@postLogin'
]);

Route::get('/teacher/admin/logout', [
    'as' => 'tch.admin.logout', 'uses' => 'Teacher\TeacherController@logout'
]);

Route::get('/company/admin/logout', [
    'as' => 'cpn.admin.logout', 'uses' => 'Company\CompanyController@logout'
]);

/*----- 講師後台 -----*/
Route::group(['middleware' => 'auth'], function () {

    Route::get('/teacher/admin/main', [
        'as' => 'tch.admin.main', 'uses' => 'Teacher\TeacherController@main'
    ]);

    Route::get('/teacher/admin/editProfile', [
        'as' => 'tch.admin.editProfile', 'uses' => 'Teacher\TeacherController@editProfile'
    ]);

    Route::post('/teacher/admin/updateProfile', [
        'as' => 'tch.admin.updateProfile', 'uses' => 'Teacher\TeacherController@updateProfile'
    ]);

    Route::post('/teacher/admin/acceptLectureRequestByAjax', [
        'as' => 'tch.admin.acceptLectureRequestByAjax', 'uses' => 'Teacher\TeacherController@acceptLectureRequestByAjax'
    ]);

    Route::get('/teacher/admin/requestDetail/{request_id}', [
        'as' => 'tch.admin.requestDetail', 'uses' => 'Teacher\TeacherController@requestDetail'
    ]);

    Route::get('/teacher/admin/order/confirmedLists', [
        'as' => 'tch.admin.confirmedOrderLists', 'uses' => 'Teacher\OrderController@confirmedLists'
    ]);

    Route::get('/teacher/admin/order/inprogressLists', [
        'as' => 'tch.admin.inprogressOrderLists', 'uses' => 'Teacher\OrderController@inprogressLists'
    ]);

    Route::get('/teacher/admin/order/deliveredLists', [
        'as' => 'tch.admin.deliveredOrderLists', 'uses' => 'Teacher\OrderController@deliveredLists'
    ]);

    Route::get('/teacher/admin/order/canceledLists', [
        'as' => 'tch.admin.canceledOrderLists', 'uses' => 'Teacher\OrderController@canceledLists'
    ]);

    Route::get('/teacher/admin/orderDetail/{order_id}', [
        'as' => 'tch.admin.orderDetail', 'uses' => 'Teacher\OrderController@detail'
    ]);

    Route::post('/teacher/admin/orderCheckinByAjax', [
        'as' => 'tch.admin.orderCheckinByAjax', 'uses' => 'Teacher\OrderController@orderCheckinByAjax'
    ]);

    Route::post('/teacher/admin/orderCheckoutByAjax', [
        'as' => 'tch.admin.orderCheckoutByAjax', 'uses' => 'Teacher\OrderController@orderCheckoutByAjax'
    ]);

    Route::post('/teacher/admin/cancelLectureOrderByAjax', [
        'as' => 'tch.admin.cancelLectureOrderByAjax', 'uses' => 'Teacher\OrderController@cancelLectureOrderByAjax'
    ]);

});

/*----- 企業後台 -----*/
Route::group(['middleware' => 'auth.cpn'], function () {

    Route::get('/company/admin/main', [
        'as' => 'cpn.admin.main', 'uses' => 'Company\CompanyController@main'
    ]);

    Route::get('/company/admin/createLectureRequest/', [
        'as' => 'cpn.admin.createLectureRequest', 'uses' => 'Company\OrderController@createLectureRequest'
    ]);

    Route::post('/company/admin/postCreateLectureRequest/', [
        'as' => 'cpn.admin.postCreateLectureRequest', 'uses' => 'Company\OrderController@postCreateLectureRequest'
    ]);

    Route::get('/company/admin/editProfile', [
        'as' => 'cpn.admin.editProfile', 'uses' => 'Company\CompanyController@editProfile'
    ]);

    Route::post('/company/admin/updateProfile', [
        'as' => 'cpn.admin.updateProfile', 'uses' => 'Company\CompanyController@updateProfile'
    ]);

    Route::get('/company/admin/orderLists', [
        'as' => 'cpn.admin.orderLists', 'uses' => 'Company\OrderController@lists'
    ]);

    Route::get('/company/admin/orderDetail/{order_id}', [
        'as' => 'cpn.admin.orderDetail', 'uses' => 'Company\OrderController@detail'
    ]);

    Route::get('/company/admin/requestLists', [
        'as' => 'cpn.admin.requestLists', 'uses' => 'Company\OrderController@requestLists'
    ]);

    Route::get('/company/admin/requestDetail/{request_id}', [
        'as' => 'cpn.admin.requestDetail', 'uses' => 'Company\OrderController@requestDetail'
    ]);

    Route::post('/company/admin/cancelLectureRequestByAjax', [
        'as' => 'cpn.admin.cancelLectureRequestByAjax', 'uses' => 'Company\OrderController@cancelLectureRequestByAjax'
    ]);

    Route::get('/company/admin/getLectureRequestServiceDatetimeByAjax', [
        'as' => 'cpn.admin.getLectureRequestServiceDatetimeByAjax', 'uses' => 'Company\OrderController@getLectureRequestServiceDatetimeByAjax'
    ]);

    Route::post('/company/admin/rescheduleLectureRequestDatetimeByAjax', [
        'as' => 'cpn.admin.rescheduleLectureRequestDatetimeByAjax', 'uses' => 'Company\OrderController@rescheduleLectureRequestDatetimeByAjax'
    ]);

    Route::get('/company/admin/getLectureOrderServiceDatetimeByAjax', [
        'as' => 'cpn.admin.getLectureOrderServiceDatetimeByAjax', 'uses' => 'Company\OrderController@getLectureOrderServiceDatetimeByAjax'
    ]);

    Route::post('/company/admin/rescheduleLectureOrderDatetimeByAjax', [
        'as' => 'cpn.admin.rescheduleLectureOrderDatetimeByAjax', 'uses' => 'Company\OrderController@rescheduleLectureOrderDatetimeByAjax'
    ]);

});






