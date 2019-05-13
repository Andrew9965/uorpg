<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('fractions_old'), 'namespace' => 'Modules\Fractions\Http\Controllers'], function()
{
    Route::get('/', 'FractionsController@index');
});
