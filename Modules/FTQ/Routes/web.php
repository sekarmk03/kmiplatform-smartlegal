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

use Modules\FTQ\Http\Controllers\FatBlendVerificationController;

Route::name('ftq.')->group(function () {
    Route::get('/', 'FTQController@index');
    Route::get('/okp/list', 'FTQController@getOkp')->name('okp.list');
    Route::name('verifikasi.')->prefix('verifikasi')->group(function(){
        Route::resource('fat-blend', 'FatBlendVerificationController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
});
