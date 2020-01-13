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

Route::middleware(['auth'])->group(function() {

    Route::group(['as' => 'flower.'], function() {
        Route::get('/', 'FlowerController@index')->name('index');
        Route::get('flower/{id}', 'FlowerController@show')->name('show');
        Route::get('search', 'FlowerController@search')->name('search');
    });

    Route::group(['as' => 'cart.'], function() {
        Route::post('flower/{id}', 'CartController@add_item')->name('add_item');
        Route::get('cart', 'CartController@index')->name('index');
        Route::delete('cart/{id}', 'CartController@delete_item')->name('delete_item');
    });

    Route::group(['as' => 'user.'], function() {
        Route::get('profile', 'UserController@edit')->name('edit');
        Route::put('profile', 'UserController@update')->name('update');
    });
    
    Route::post('cart', 'TransactionController@store')->name('transaction.store');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {

        Route::group(['prefix' => 'flower', 'as' => 'flower.'], function() {
            Route::get('/', 'FlowerController@index_admin')->name('index_admin');
            Route::get('insert', 'FlowerController@create')->name('create');
            Route::post('/', 'FlowerController@store')->name('store');
            Route::get('{id}/edit', 'FlowerController@edit')->name('edit');
            Route::put('{id}', 'FlowerController@update')->name('update');
            Route::delete('{id}', 'FlowerController@delete')->name('delete');
            Route::get('search', 'FlowerController@search_admin')->name('search_admin');
        });
    
        Route::group(['prefix' => 'flower-type', 'as' => 'flower_type.'], function () {
            Route::get('/', 'FlowerTypeController@index')->name('index');
            Route::get('insert', 'FlowerTypeController@create')->name('create');
            Route::post('/', 'FlowerTypeController@store')->name('store');
            Route::get('{id}/edit', 'FlowerTypeController@edit')->name('edit');
            Route::put('{id}', 'FlowerTypeController@update')->name('update');
            Route::delete('{id}', 'FlowerTypeController@delete')->name('delete');
            Route::get('search', 'FlowerTypeController@search')->name('search');
        });
    
        Route::group(['prefix' => 'courier', 'as' => 'courier.'], function() {
            Route::get('/', 'CourierController@index')->name('index');
            Route::get('insert', 'CourierController@create')->name('create');
            Route::post('/', 'CourierController@store')->name('store');
            Route::get('{id}/edit', 'CourierController@edit')->name('edit');
            Route::put('{id}', 'CourierController@update')->name('update');
            Route::delete('{id}', 'CourierController@delete')->name('delete');
            Route::get('search', 'CourierController@search')->name('search');
        });
    
        Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
            Route::get('/', 'UserController@index')->name('index');
            Route::get('{id}/edit', 'UserController@edit_admin')->name('edit_admin');
            Route::put('{id}', 'UserController@update_admin')->name('update_admin');
            Route::delete('{id}', 'UserController@delete')->name('delete');
            Route::get('search', 'UserController@search')->name('search');
        });
    
        Route::get('transaction', 'TransactionController@index')->name('transaction.index');
    });
});


Route::middleware(['guest'])->group(function() {
    Route::get('login', 'AuthController@loginPage')->name('login');
    Route::get('register', 'AuthController@registerPage')->name('register');
    Route::post('login', 'AuthController@postLogin');
    Route::post('register', 'AuthController@postRegister');
});

Route::fallback(function() {
    return response()->view('errors.404', [] , 404);
});