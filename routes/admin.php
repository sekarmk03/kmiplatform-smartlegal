<?php

use App\Http\Controllers\Admin\ManageCgController;
use App\Http\Controllers\Admin\ManageDBAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageLevelController;
use App\Http\Controllers\Admin\ManageDepartmentController;
use App\Http\Controllers\Admin\ManageJobPositionController;
use App\Http\Controllers\Admin\ManageMenuController;
use App\Http\Controllers\Admin\ManageModuleController;
use App\Http\Controllers\Admin\ManageSubmenuController;
use App\Http\Controllers\Admin\ManageSubdepartmentController;

    Route::name('manage.')->group(function(){
        //Prefix: Manage Users
        Route::resource('user', ManageUserController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::put('/manage-user/{id}/change-password', [ManageUserController::class, 'putChangePassword'])->name('user.change-password');

        //Prefix: Manage Levels
        Route::resource('level', ManageLevelController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('/level/{id}/access', [ManageLevelController::class, 'getAccess'])->name('level.access');
        Route::put('/level/{id}/change', [ManageLevelController::class, 'changeAccess'])->name('level.change');


        //Prefix: Manage Departments
        Route::resource('department', ManageDepartmentController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('department/users', [ManageDepartmentController::class, 'listUsers'])->name('department.users');

        //Prefix: Manage Subdepartments
        Route::resource('subdepartment', ManageSubdepartmentController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::get('subdepartment/list', [ManageSubdepartmentController::class, 'list'])->name('subdepartment.list');

        //Prefix: Manage Menus
        Route::resource('menu', ManageMenuController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Prefix: Manage Submenus
        Route::resource('submenu', ManageSubmenuController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Prefix: Manage Modules
        Route::resource('module', ManageModuleController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        
        //Prefix: Manage Accounts
        Route::resource('dbaccount', ManageDBAccountController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Prefix: Manage Job positions
        Route::resource('jobposition', ManageJobPositionController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

        //Prefix: Manage CG
        Route::resource('cg', ManageCgController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
    });