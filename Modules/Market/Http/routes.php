<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('market'), 'namespace' => 'Modules\Market\Http\Controllers'], function()
{
    Route::get('/', 'MarketController@index');
});
