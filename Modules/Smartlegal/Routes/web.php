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

Route::name('smartlegal.')->group(function () {
    Route::get('/', 'SmartlegalController@index');

    Route::get('admin', 'Admin\TestController@index')->name('test');

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('docstatus', 'DocStatusController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('doctype', 'DocTypeController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('docvariant', 'DocVariantController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('issuer', 'IssuerController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('permission', 'PermissionController')->only(['index', 'edit', 'update']);
        Route::resource('role', 'RoleController')->only(['index', 'edit', 'update']);
        Route::resource('userrole', 'UserRoleController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('department', 'DepartmentController')->only(['index', 'edit', 'update']);

        Route::resource('file', 'FileController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('file/{id}/download', 'FileController@download')->name('file.download');
        Route::get('file/{id}/preview', 'FileController@preview')->name('file.preview');
        
        Route::get('mandatory', 'DocMandatoryController@index')->name('mandatory.index');
        Route::get('menu', 'MenuController@index')->name('menu.index');
    });

    Route::prefix('mytask')->group(function () {
        Route::get('mandatories', 'MyTaskMandatoryController@index')->name('mytask.mandatory.index');
        Route::get('mandatories/{id}', 'MyTaskMandatoryController@show')->name('mytask.mandatory.show');
    });

    Route::prefix('request')->group(function () {
        Route::get('mandatories', 'RequestMandatoryController@index')->name('request.mandatory.index');
    });

    Route::prefix('library')->group(function () {
        Route::get('mandatories', 'LibraryMandatoryController@index')->name('library.mandatory.index');
    });
});
