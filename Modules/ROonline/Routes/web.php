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

Route::name('roonline.')->middleware('canAccess')->group(function () {
    Route::get('/', 'ROonlineController@index')->name('dashboard');
    Route::post('/postCheckReason', 'ROonlineController@getReasonRO')->name('reason.check');
    Route::get('/ro-chart', 'ROonlineController@ROChart')->name('chart');
    Route::get('/ro-widget', 'ROonlineController@getROWidget')->name('widget');
    Route::get('/ro-maxavg', 'ROonlineController@getMaxAvg')->name('maxAvg');
    Route::get('/rhtemp', 'ROonlineController@getRHTemp')->name('rhtemp');
    Route::post('/export-histories', 'ROonlineController@getExportHistory')->name('export.histories');
    Route::post('/export-rhtemp', 'ROonlineController@getExportRhTemp')->name('export.rhtemp');
    Route::post('/reason', 'ROonlineController@storeReason')->name('reason.store');

    //Prefix: Admin
    Route::group(['prefix' => 'admin'], function(){
        //Management: inspection
        Route::get('/inspections', 'Admin\InspectionController@index')->name('manage.inspection');
        Route::get('/inspections/okp', 'Admin\InspectionController@getOkp')->name('inspection.okp');
        Route::post('/inspections/lot', 'Admin\InspectionController@postLotNumber')->name('inspection.lot');
        Route::get('/inspection/{id}', 'Admin\InspectionController@edit')->name('manage.inspection.edit');
        Route::put('/inspection/{id}', 'Admin\InspectionController@update')->name('manage.inspection.update');

        //Line
        Route::resource('/line', 'Admin\LineController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Area
        Route::resource('/area', 'Admin\AreaController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        
        //Device
        Route::resource('/device', 'Admin\DeviceController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Menu
        Route::resource('menu', 'Admin\MenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('menu/list', 'Admin\MenuController@list')->name('menu.list');

        //Sub Menu
        Route::resource('submenu', 'Admin\SubmenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
    //Log History
    Route::get('/log-history', 'LogHistoryController@index')->name('log-history.index');
    Route::get('/log-history/{id}', 'LogHistoryController@getDetail')->name('log-history.view');

    //>2% RO Value
    Route::resource('above-std', 'HighRoController')->only(['index', 'show']);

    //Access Controll
    Route::resource('/access-control', 'Admin\AccessControlController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    Route::get('/access-control/{id}/users', 'Admin\AccessControlController@getUser')->name('access-control.users');
});

