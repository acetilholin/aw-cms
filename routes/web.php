<?php

/*  public routes */
Route::post('/login-user', ['as' => 'loginUser', 'uses' => 'Auth\LoginController@login']);
Route::post('/register-user', ['as' => 'registerUser', 'uses' => 'Auth\RegisterController@register']);
Route::post('/send-token', ['as' => 'sendToken', 'uses' => 'Auth\ForgotPasswordController@sendToken']);
Route::post('/reset-password', ['as' => 'resetPassword', 'uses' => 'Auth\ResetPasswordController@resetPassword']);

Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomePageController@index']);
Route::get('/en', ['as' => 'english', 'uses' => 'WelcomePageController@index']);
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@checkCookie']);
Route::get('/inquiry', ['as' => 'inquiry', 'uses' => 'ContactController@inquiry']);
Route::get('/contact', ['as' => 'contactForm', 'uses' => 'ContactController@sendContactEmail']);
Route::get('/camper-inquiry', ['as' => 'camperInquiry', 'uses' => 'ContactController@camperInquiry']);
Route::get('/camper-availability', ['as' => 'camperAvailability', 'uses' => 'WelcomePageController@camperAvailability']);

Route::get('/register', function () {
    return view('register');
});
Route::get('/change-password', function () {
    return view('password');
});
Route::get('/token', function () {
    return view('token');
});

Route::group(['middleware' =>'authUser'], function ($router) {
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/main', ['as' => 'main', 'uses' => 'CarController@index']);
    Route::post('/add', ['as' => 'add', 'uses' => 'CarController@store']);
    Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'CarController@destroy']);
    Route::get('/load-image', ['as' => 'loadImage', 'uses' => 'CarController@loadImage']);
    Route::get('/users', ['as' => 'users', 'uses' => 'UserController@index']);
    Route::get('/load', ['as' => 'loadCar', 'uses' => 'CarController@edit']);
    Route::post('/update', ['as' => 'update', 'uses' => 'CarController@update']);
    Route::post('/delete-car-image', ['as' => 'deleteCarImage', 'uses' => 'CarController@deleteImage']);
    Route::post('/set-cover-image', ['as' => 'setCoverImage', 'uses' => 'CarController@setCoverImage']);
    Route::get('/statistics', ['as' => 'statistics', 'uses' => 'StatisticsController@index']);
    Route::get('/load-statistics', ['as' => 'loadStatistics', 'uses' => 'StatisticsController@getData']);
    Route::get('/show-hide/{id}', ['as' => 'showOrHide', 'uses' => 'CarController@showHide']);
    Route::get('/delete-user/{id}', ['as' => 'deleteUser', 'uses' => 'UserController@destroy']);
    Route::get('/lock/{id}', ['as' => 'lockUnlock', 'uses' => 'UserController@lockUnlock']);
    Route::get('/reservations', ['as' => 'reservations', 'uses' => 'ReservationController@index']);
    Route::post('/toggle-camper', ['as' => 'toggleCamper', 'uses' => 'ReservationController@toggleCamper']);
    Route::get('/load-reservation', ['as' => 'loadReservation', 'uses' => 'ReservationController@edit']);
    Route::post('/update-reservation', ['as' => 'updateReservation', 'uses' => 'ReservationController@update']);
    Route::get('/delete-reservation/{id}', ['as' => 'deleteReservation', 'uses' => 'ReservationController@destroy']);
    Route::post('/add-calendar', ['as' => 'addCalendar', 'uses' => 'CalendarController@store']);
    Route::get('/load-calendar', ['as' => 'loadCalendar', 'uses' => 'CalendarController@edit']);
    Route::post('/update-calendar', ['as' => 'updateCalendar', 'uses' => 'CalendarController@update']);
    Route::get('/delete-calendar/{id}', ['as' => 'deleteCalendar', 'uses' => 'CalendarController@destroy']);
});










