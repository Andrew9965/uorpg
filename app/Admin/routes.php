<?php

use Illuminate\Routing\Router;
use Lia\Facades\Admin;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('lia.route.prefix'),
    'namespace'     => config('lia.route.namespace'),
    'middleware'    => config('lia.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/site-menu', 'MenuController@index');
    $router->post('/site-menu', 'MenuController@store');
    $router->match(['put','patch'], '/site-menu/{menu}', 'MenuController@update');
    $router->get('/site-menu/{menu}/edit', 'MenuController@edit');
    $router->delete('/site-menu/{menu}', 'MenuController@destroy');


    Route::group(['as' => 'lang.'], function($router){

        $router->get('/languages/live_translate', 'TranslateController@google_translate')->name('google_translate');
        $router->get('/languages/view/{group?}', 'TranslateController@getView')->name('getView');
        $router->post('/languages/delete/{group}/{key}', 'TranslateController@postDelete')->name('postDelete');
        $router->post('/languages/import', 'TranslateController@postImport')->name('postImport');
        $router->post('/languages/find', 'TranslateController@postFind')->name('postFind');
        $router->post('/languages/add_group', 'TranslateController@postAddGroup')->name('postAddGroup');
        $router->post('/languages/add/{group?}', 'TranslateController@postAdd')->name('postAdd');
        $router->post('/languages/remove_locale', 'TranslateController@postRemoveLocale')->name('postRemoveLocale');
        $router->post('/languages/add_locale', 'TranslateController@postAddLocale')->name('postAddLocale');
        $router->post('/languages/publish/{group?}', 'TranslateController@postPublish')->name('postPublish');
        $router->put('/languages/edit/{group?}', 'TranslateController@postEdit')->name('postEdit');
        $router->get('/languages/{group?}', 'TranslateController@getIndex')->name('getIndex');

        $router->resource('/partners', PartnersController::class);
        //$router->resource('/information', PartnersController::class);

    });

});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    //$router->resource('pages', PagesController::class);
    $router->resource('pages_v2', PagesV2Controller::class);

    $router->resource('pages_params', PageParamsController::class);
    $router->resource('page_collapse', PageCollapseController::class);
    $router->resource('page_collapse_item', PageCollapseItemController::class);
    $router->resource('page_header_table', PageHeaderTableController::class);
    $router->resource('page_buttons', PageButtonsController::class);
    $router->resource('left_menu', LeftMenuController::class);
    $router->resource('right_menu', RightMenuController::class);
    $router->resource('socials', SocialsController::class);
    $router->resource('options', OptionsController::class);
    $router->resource('forum_new_themes', ForumNewThemesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('news', NewsController::class);
    $router->post('news/forum', 'NewsController@forum_save')->name('save_forum_cfg');
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('resources_categories', ResourcesCategoriesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('resources', ResourcesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('classes', ClassesController::class);
    $router->resource('classes_params', ClassesParamsController::class);
    $router->resource('classes_skills', ClassesSkillsController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('information', InformationsController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('file_categories', FileCategriesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('files', FilesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('fractions_categories', FractionsCategoriesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('fractions', FractionsController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('videos', VideosController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('images', ImagesController::class);
});
Route::group(['namespace' => 'App\Admin\Controllers', 'prefix'=>config('lia.route.prefix'), 'middleware'=>config('lia.route.middleware')], function (Router $router) {
    $router->resource('creation', CreationController::class);
});
