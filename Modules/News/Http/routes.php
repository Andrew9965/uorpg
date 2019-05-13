<?php

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('news'), 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::get('/', 'NewsController@index');
});

Route::group(['middleware' => 'web', 'prefix' => locale_prefix('news-archive'), 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::get('/', 'NewsController@news_archive')->name('news.archive');
});
