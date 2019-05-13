<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix(), 'namespace' => 'Modules\Page\Http\Controllers'], function()
{
    Route::get('/{page}', 'PageController@index')->name('page');
    Route::post('/client_generator/get', 'ClientGeneratorController@index')->name('client_generator');
});
