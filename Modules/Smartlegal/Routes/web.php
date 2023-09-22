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
    Route::get('departments', 'DepartmentController@getAllDepartments')->name('departments');
    Route::get('users', 'UserController@getAllUsers')->name('users');
    Route::get('users/{id}', 'UserController@getUsersByDepartment')->name('users.department');

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('docstatus', 'DocStatusController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('docstatuses', 'DocStatusController@getAllStatuses')->name('docstatuses');

        Route::resource('doctype', 'DocTypeController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('doctypes', 'DocTypeController@getAllTypes')->name('doctypes');

        Route::resource('docvariant', 'DocVariantController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        Route::resource('issuer', 'IssuerController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('issuers', 'IssuerController@getAllIssuers')->name('issuers');

        Route::resource('permission', 'PermissionController')->only(['index', 'edit', 'update']);

        Route::resource('role', 'RoleController')->only(['index', 'edit', 'update']);

        Route::resource('userrole', 'UserRoleController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        Route::resource('department', 'DepartmentController')->only(['index', 'edit', 'update']);

        Route::resource('file', 'FileController')->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('file/{id}/preview', 'FileController@preview')->name('file.preview');
        Route::get('file/{id}/download', 'FileController@download')->name('file.download');
        
        Route::resource('mandatory', 'DocMandatoryController')->only(['index', 'store', 'edit', 'update', 'destroy']);

        Route::get('menu', 'MenuController@index')->name('menu.index');

        Route::resource('approval', 'DocApprovalController')->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('approval/document/{id}', 'DocApprovalController@getLogByDocument')->name('approval.document');
    });

    Route::prefix('mytask')->name('mytask.')->group(function () {
        Route::resource('mandatory', 'MyTaskMandatoryController')->only(['index', 'show', 'edit', 'update']);
        Route::put('mandatory/{id}/approve', 'MyTaskMandatoryController@approve')->name('mandatory.approve');
    });

    Route::prefix('request')->name('request.')->group(function () {
        Route::resource('mandatory', 'RequestMandatoryController')->only(['index', 'store', 'edit', 'update']);
        Route::put('mandatory/{id}/terminate', 'RequestMandatoryController@terminate')->name('mandatory.terminate');
    });

    Route::prefix('library')->name('library.')->group(function () {
        Route::resource('mandatory', 'LibraryMandatoryController')->only('index', 'show');
        Route::get('mandatory/{id}/attachment', 'LibraryMandatoryController@attachment')->name('mandatory.attachment');
        Route::post('mandatory/upload', 'LibraryMandatoryController@upload')->name('mandatory.upload');
    });
});
