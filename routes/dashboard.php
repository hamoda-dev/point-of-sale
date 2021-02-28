<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:web' ]], function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // index dashboard route
        Route::get('/', 'DashboardController@index')->name('index');

        //users route
        Route::resource('users', 'UserController')->except('show');
    });
});
