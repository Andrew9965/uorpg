<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('information_old'), 'namespace' => 'Modules\Information\Http\Controllers'], function()
{
    Route::get('/', 'InformationController@index');
});
