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

Route::name('rois.')->middleware('canAccess')->group(function () {
    Route::get('/', 'ROISController@index')->name('dashboard');
    Route::post('postCheckReason', 'ROISController@getReasonRO')->name('reason.check');
    Route::get('ro-chart', 'ROISController@ROChart')->name('chart');
    Route::get('ro-widget', 'ROISController@getROWidget')->name('widget');
    Route::get('ro-maxavg', 'ROISController@getMaxAvg')->name('maxAvg');
    Route::get('rhtemp', 'ROISController@getRHTemp')->name('rhtemp');
    Route::post('export-histories', 'ROISController@getExportHistory')->name('export.histories');
    Route::post('export-rhtemp', 'ROISController@getExportRhTemp')->name('export.rhtemp');
    Route::post('reason', 'ROISController@storeReason')->name('reason.store');

    //>2% RO Value
    Route::resource('above-std', 'HighRoController')->only(['index', 'show']);

    //Log History
    Route::resource('log-history', 'LogHistoryController')->only(['index', 'show']);

    //Access Controll
    Route::resource('access-control', 'Admin\AccessControlController')->only(['index', 'store', 'edit', 'update', 'destroy']);
    Route::get('access-control/{id}/users', 'Admin\AccessControlController@getUser')->name('access-control.users');

    Route::prefix('admin')->group(function(){
        //Area
        Route::resource('/area', 'Admin\AreaController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        
        //Device
        Route::resource('/device', 'Admin\DeviceController')->only(['index', 'store', 'edit', 'update', 'destroy']); 

        //Line
        Route::resource('/line', 'Admin\LineController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Menu
        Route::resource('menu', 'Admin\MenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('menu/list', 'Admin\MenuController@list')->name('menu.list');

        //Submenu
        Route::resource('submenu', 'Admin\SubmenuController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Management: inspection
        Route::get('/inspections', 'Admin\InspectionController@index')->name('manage.inspection');
        Route::get('/inspections/okp', 'Admin\InspectionController@getOkp')->name('inspection.okp');
        Route::post('/inspections/lot', 'Admin\InspectionController@postLotNumber')->name('inspection.lot');
        Route::get('/inspection/{id}', 'Admin\InspectionController@edit')->name('manage.inspection.edit');
        Route::put('/inspection/{id}', 'Admin\InspectionController@update')->name('manage.inspection.update');
    });
});
