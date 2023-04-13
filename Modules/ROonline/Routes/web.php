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

Route::get('/', 'ROonlineController@index');
Route::get('/ro-chart', 'ROonlineController@ROChart')->name('roonline.chart');
Route::get('/ro-widget', 'ROonlineController@getROWidget')->name('roonline.widget');
Route::get('/ro-maxavg', 'ROonlineController@getMaxAvg')->name('roonline.maxAvg');

//Prefix: Admin
Route::group(['prefix' => 'admin'], function(){
    //Management: Devices
    Route::get('/devices', 'Admin\DeviceController@index')->name('roonline.manage.device');
    Route::post('/device', 'Admin\DeviceController@store')->name('roonline.manage.device.store');
    Route::get('/device/{id}', 'Admin\DeviceController@edit')->name('roonline.manage.device.edit');
    Route::put('/device/{id}', 'Admin\DeviceController@update')->name('roonline.manage.device.update');
    Route::delete('/device/{id}', 'Admin\DeviceController@destroy')->name('roonline.manage.device.destroy');

    //Management: inspection
    Route::get('/inspections', 'Admin\InspectionController@index')->name('roonline.manage.inspection');
    Route::get('/inspections/okp', 'Admin\InspectionController@getOkp')->name('roonline.inspection.okp');
    Route::get('/inspection/{id}', 'Admin\InspectionController@edit')->name('roonline.manage.inspection.edit');
    Route::put('/inspection/{id}', 'Admin\InspectionController@update')->name('roonline.manage.inspection.update');
    
});
//Log History
Route::get('/log-history', 'LogHistoryController@index')->name('roonline.log-history.index');
Route::get('/log-history/{id}', 'LogHistoryController@getDetail')->name('roonline.log-history.view');

