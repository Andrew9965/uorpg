<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('resources_old'), 'namespace' => 'Modules\Resources\Http\Controllers'], function()
{
    Route::get('/', 'ResourcesController@index');
});
