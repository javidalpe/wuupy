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

//Basic
Route::get('/', function () { return view('welcome'); });
Route::get('/terms', function () { return view('terms'); });

//User
Route::group(['middleware' => 'auth'], function () {

    //Monetize
    Route::get('/home', 'MonetizeController@index')->name('home');

    //Connect Instagram Account
    Route::post('/connect', 'InstagramController@connect')->name('instagram.connect');

    //Plan
    Route::post('/plan', 'PlanController@store')->name('plan.store');

    //Account, banks & verification
    Route::post('/account', 'AccountController@store')->name('account.store');
    Route::put('/account', 'AccountController@update')->name('account.update');
    Route::resource('banks', 'BankController');
    Route::get('/verify', 'AccountController@edit')->name('account.edit');

    //Privacy check
    Route::post('/check', 'InstagramController@check')->name('instagram.check');

    //Check your balance
    Route::get('/balance', 'BalanceController@index')->name('balance.index');

    //Follow
    Route::get('/follow', 'SubscriptionController@index')->name('subscriptions.index');
    Route::delete('/follow/{id}', 'SubscriptionController@destroy')->name('subscriptions.destroy');

});


Auth::routes();

//Subscriptions
Route::get('/done', 'SubscriptionController@done')->name('subscriptions.done');
Route::post('/{nickname}', 'SubscriptionController@store')->name('subscriptions.store');
Route::get('/{nickname}', 'SubscriptionController@show')->name('subscriptions.show');
