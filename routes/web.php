<?php
Auth::routes();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::post('/locale/set/{name}', 'LocalizationChangeController')->where('name', '[A-Za-z]+');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Auth::routes();

        Route::get('/', 'HomeController@index')->name('home');
    });
*/

/*Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['auth', 'role:admin|moderator|owner'],
    ],
    function () {
        Route::get('/', 'Admin\DashboardController')->name('dashboard');

        Route::resource('/menu', 'Admin\MainMenuController');

        Route::resource('users', 'Admin\UserController');

        Route::group(
            [
                'middleware' => ['auth', 'role:admin|owner'],
            ],
            function () {



                Route::resource('roles', 'Admin\RoleUserController');


            });

    });*/

