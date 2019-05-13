<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('active_players'), 'namespace' => 'Modules\ActivePlayers\Http\Controllers'], function()
{
    Route::get('/', 'ActivePlayersController@index')->name('active_players');
});
