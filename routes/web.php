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
    Route::post('/plan', 'PlanController@store')->name('plan.store');
    Route::post('/account', 'AccountController@store')->name('account.store');
    Route::get('/verify', 'AccountController@edit')->name('account.edit');
    Route::put('/account', 'AccountController@update')->name('account.update');
    Route::resource('banks', 'BankController');
    Route::post('/check', 'InstagramController@check')->name('instagram.check');
    Route::get('/balance', 'BalanceController@index')->name('balance.index');

    //Follow
    Route::get('/follow', 'SubscriptionController@index')->name('subscriptions.index');
    Route::delete('/follow/{id}', 'SubscriptionController@destroy')->name('subscriptions.destroy');

    //logout
    Route::post('/logout', function () { Auth::logout(); return redirect('/'); });
});

//Auth
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('/register', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

//Subscriptions
Route::get('/done', 'SubscriptionController@done')->name('subscriptions.done');
Route::post('/{nickname}', 'SubscriptionController@store')->name('subscriptions.store');
Route::get('/{nickname}', 'SubscriptionController@show')->name('subscriptions.show');
