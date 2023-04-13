<?php

use Alexusmai\LaravelFileManager\FileManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ManageDatabasesController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\DashboardNavigationController;

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
Route::group(['middleware' => 'guest'], function(){
    Route::get('/', [AuthController::class, 'getIndex'])->name('auth.index');
    Route::post('/auth', [AuthController::class, 'postAuth'])->name('post.auth.index');
});

//Auth: Logout
Route::get('/logout', [AuthController::class, 'getLogout'])->name('auth.logout')->middleware('auth');

//Auth
Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [DashboardNavigationController::class, 'getIndex'])->name('dashboard.navigation');
    Route::get('/dashboard/modules/{id_dept}', [DashboardNavigationController::class, 'getModules'])->name('dashboard.navigation.modules');

    //Prefix: Manage Databases
    Route::get('/user/manage-databases/{id}', [ManageDatabasesController::class, 'getIndex'])->name('manage.database.index');
    Route::post('/user/manage-database', [ManageDatabasesController::class, 'storeDatabase'])->name('manage.database.store');
    Route::delete('/user/manage-database/{id}', [ManageDatabasesController::class, 'destroyDatabase'])->name('manage.database.destroy');
    //File Manager
    Route::get('/filemanager', [FileManagerController::class, 'getIndex'])->name('filemanager');
});