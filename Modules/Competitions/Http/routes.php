<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('competitions'), 'namespace' => 'Modules\Competitions\Http\Controllers'], function()
{
    Route::get('/', 'CompetitionsController@index')->name('competitions.page');
});
