<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/change-password', function () {
    return view('password');
});
Route::get('/token', function () {
    return view('token');
});

/* POST */
Route::post('/login-user', ['as' => 'loginUser', 'uses' => 'UserController@login']);
Route::post('/register-user', ['as' => 'registerUser', 'uses' => 'UserController@register']);
Route::post('/send-token', ['as' => 'sendToken', 'uses' => 'UserController@sendToken']);
Route::post('/validate-token', ['as' => 'validateToken', 'uses' => 'UserController@validateToken']);
Route::post('/add', ['as' => 'add', 'uses' => 'CarsController@addCar']);
Route::post('/update', ['as' => 'update', 'uses' => 'CarsController@updateCar']);

/* GET */
Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomePageController@index']);
Route::get('/en', ['as' => 'english', 'uses' => 'WelcomePageController@indexEN']);
Route::get('/main', ['as' => 'main', 'uses' => 'CarsController@index']);
Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'CarsController@edit']);
Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'CarsController@delete']);
Route::get('/load', ['as' => 'loadCar', 'uses' => 'CarsController@loadCar']);
Route::get('/contact', ['as' => 'contactForm', 'uses' => 'ContactController@sendContactEmail']);
Route::get('/contact-en', ['as' => 'contactFormEn', 'uses' => 'ContactController@sendContactEmailEnglish']);
Route::get('/users', ['as' => 'users', 'uses' => 'UserController@index']);
Route::get('/lock/{id}', ['as' => 'lock', 'uses' => 'UserController@lockUser']);
Route::get('/unlock/{id}', ['as' => 'unlock', 'uses' => 'UserController@unlockUser']);
Route::get('/delete-user/{id}', ['as' => 'deleteUser', 'uses' => 'UserController@deleteUser']);

/*Logout*/
Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
