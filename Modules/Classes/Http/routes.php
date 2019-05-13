<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('classes_old'), 'namespace' => 'Modules\Classes\Http\Controllers'], function()
{
    Route::get('/', 'ClassesController@index');
});
