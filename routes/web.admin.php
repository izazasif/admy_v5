<?php

use Illuminate\Http\Request;

Route::prefix('admin')->namespace('Admin')->group(function() {

    Route::get('/','HomeController@index')->name('admin');
    Route::get('/home','HomeController@home')->name('admin.home');

});
