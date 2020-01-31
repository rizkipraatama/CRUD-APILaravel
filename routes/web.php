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
Route::get('/','User\Auth\LoginController@showLoginForm')->name('login');
Route::post('/','User\Auth\LoginController@login');
Route::get('/admin','Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin','Admin\Auth\LoginController@login');

Auth::routes([ 'verify' => true ]);


Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    
    /**
     * Admin Auth Route(s)
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout');

    });

    Route::get('/dashboard','DashboardController@index')->name('home')->middleware('verified');
    Route::get('/allUser','DashboardController@showUser')->name('users');
    Route::post('/user/storeUser','DashboardController@storeUser');
    Route::get('/user/{id}/edit', 'DashboardController@edit');
    Route::get('/user/deleteUser/{id}', 'DashboardController@destroy');
    Route::get('/allBooks','BookController@index')->name('books');
    Route::post('/book/storeBook','BookController@store');
    Route::get('/book/{id}/edit', 'BookController@edit');
    Route::get('/book/deleteBook/{id}', 'BookController@destroy');
});

Route::prefix('/user')->name('user.')->namespace('User')->group(function(){
    
    /**
     * User Auth Route(s)
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout');

    });
    Route::get('/allBooks','DashboardController@index')->name('books');
    Route::get('/try/{id}/get', 'DashboardController@edit');

    Route::post('/submission', 'DashboardController@store');
    Route::get('/adding/{$id}','form@store');
    Route::get('/test', 'form@index');
});