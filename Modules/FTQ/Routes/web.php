<?php

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

Route::name('ftq.')->group(function () {
    Route::get('/', 'FTQController@index');
    Route::get('/okp/list', 'FTQController@getOkp')->name('okp.list');
    Route::get('oracle', 'FTQController@getOracle')->name('oracle.list');
    Route::name('verifikasi.')->prefix('verifikasi')->group(function(){
        Route::resource('fat-blend', 'FatBlendVerificationController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    });

    //Group Admin
    Route::name('admin.')->prefix('admin')->group(function(){
        //Management Menu
        Route::resource('menu', 'Admin\MenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('menu/list', 'Admin\MenuController@list')->name('menu.list');

        //Management Sub Menu
        Route::resource('submenu', 'Admin\SubmenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Management Level
        Route::resource('level', 'Admin\LevelController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Management Level Access
        Route::resource('access', 'Admin\LevelAccessController')->only(['index', 'show', 'update']);
        Route::get('access/{id}/users', 'Admin\LevelAccessController@getUser')->name('access.users');

        //Management Custom Parameter
        Route::resource('custom-parameter', 'Admin\CustomParameterController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('custom-parameter/list', 'Admin\CustomParameterController@list')->name('custom-parameter.list');

        //Management Parameter
        Route::resource('parameter', 'Admin\ParameterController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
});
