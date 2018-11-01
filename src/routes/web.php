<?php

Route::group(['prefix' => config('djadmin.url'), 'namespace' => 'Reddevs\\DjaLaraAdmin\\Controllers', 'middleware' => ['web']], function(){
    Route::get('/', 'AdminController@index');
    Route::get('login', 'LoginController@showLoginForm')->name('admin-login');
    Route::post('login', 'LoginController@login');
});