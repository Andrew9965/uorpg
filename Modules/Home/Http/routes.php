<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix(), 'namespace' => 'Modules\Home\Http\Controllers'], function()
{
    Route::get('/', 'HomeController@index');
    Route::post('/regmail', 'HomeController@regmail')->name('regmail');
    Route::get('/ACTIVATE/{CODE}', 'HomeController@ACTIVATE')->name('ACTIVATE.CODE');
    Route::post('/re_password', 'HomeController@re_password')->name('re_password');
    Route::get('/RESET/{CODE}', 'HomeController@RESET')->name('RESET.CODE');
});
