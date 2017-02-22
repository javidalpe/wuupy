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

//User
Route::group(['middleware' => 'auth'], function () {

    //Monetize
    Route::get('/home', 'MonetizeController@index')->name('home');
    Route::post('/plan', 'PlanController@store')->name('plan.store');
    Route::post('/account', 'AccountController@store')->name('account.store');

    Route::resource('banks', 'BankController');

    //logout
    Route::post('/logout', function () { Auth::logout(); return redirect('/'); });
});


//Auth
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('/register', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

//Subscriptions
Route::get('/follow', 'SubscriptionController@index')->name('subscriptions.index');
Route::delete('/follow/{id}', 'SubscriptionController@destroy')->name('subscriptions.destroy');
Route::get('/{nickname}', 'SubscriptionController@show')->name('subscriptions.show');
Route::get('/follow/{nickname}', 'SubscriptionController@create')->name('subscriptions.create');
Route::post('/follow/{nickname}', 'SubscriptionController@store')->name('subscriptions.store');
