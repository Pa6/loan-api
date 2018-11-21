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

    Route::get('/', function () {
        return view('welcome');
    });


    Route::post('authenticate', 'api\AuthenticationController@authenticate');

    Route::any('test-user','api\AuthenticationController@TestUser');
    Route::resource('user','api\UserController',['only' => ['store']]);

    Route::group(['middleware' => ['jwt.auth']], function () {

            /*
            |--------------------------------------------
            |       User route
            |--------------------------------------------
            */
            Route::resource('user','api\UserController',['except' => ['store']]);


            /*
            |--------------------------------------------
            |       Loan route
            |--------------------------------------------
            */
            Route::resource('loan','api\LoanController');


            /*
            |--------------------------------------------
            |       Payment route
            |--------------------------------------------
            */
            Route::resource('payment','api\PaymentController');
    });