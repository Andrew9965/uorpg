<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('files'), 'namespace' => 'Modules\Files\Http\Controllers'], function()
{
    Route::get('/', 'FilesController@index');
});
