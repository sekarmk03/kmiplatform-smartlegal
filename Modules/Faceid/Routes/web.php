<?php

use Illuminate\Support\Facades\Route;

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


Route::name('faceid.')->group(function () {
    Route::get('/', 'FaceidController@index');

    Route::get('/list-karyawan', 'FotoKaryawanController@list')->name('karyawan.list');
    Route::post('/bulk-export', 'FotoKaryawanController@addPersons')->name('karyawan.bulkexport');
    Route::get('/export-karyawan/{id}', 'FotoKaryawanController@export')->name('karyawan.export');
    Route::get('/karyawan/{id}/update/', 'FotoKaryawanController@updatePerson')->name('karyawan.updatePerson');
    Route::get('/karyawan/{id}/delete/', 'FotoKaryawanController@deletePerson')->name('karyawan.deletePerson');
    Route::resource('karyawan', 'FotoKaryawanController');

    Route::get('/logs', 'LogController@index')->name('logs.index');
    Route::get('/list-log', 'LogController@list')->name('logs.list');
    Route::get('/log/{log:id}', 'LogController@show')->name('logs.show');

    Route::get('/list-device', 'DeviceController@list')->name('device.list');
    Route::resource('device', 'DeviceController');

    Route::post('/setting', 'LogController@update')->name('setting');
});
