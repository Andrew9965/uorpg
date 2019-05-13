<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('media'), 'namespace' => 'Modules\Media\Http\Controllers'], function()
{
    Route::get('/', 'MediaController@index')->name('media.page');
});
