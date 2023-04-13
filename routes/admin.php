<?php
<<<<<<< HEAD

use App\Http\Controllers\Admin\ManageCgController;
=======
>>>>>>> 77cbe935 (upload from local to git)
use App\Http\Controllers\Admin\ManageDBAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageLevelController;
use App\Http\Controllers\Admin\ManageDepartmentController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\ManageJobPositionController;
=======
>>>>>>> 77cbe935 (upload from local to git)
use App\Http\Controllers\Admin\ManageMenuController;
use App\Http\Controllers\Admin\ManageModuleController;
use App\Http\Controllers\Admin\ManageSubmenuController;
use App\Http\Controllers\Admin\ManageSubdepartmentController;

<<<<<<< HEAD
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
=======
    //Prefix: Manage Users
    Route::get('/manage-users', [ManageUserController::class, 'getIndex'])->name('manage.user.index');
    Route::post('/manage-user', [ManageUserController::class, 'postUser'])->name('manage.user.store');
    Route::get('/manage-user/{id}', [ManageUserController::class, 'editUser'])->name('manage.user.edit');
    Route::put('/manage-user/{id}', [ManageUserController::class, 'updateUser'])->name('manage.user.update');
    Route::put('/manage-user/{id}/change-password', [ManageUserController::class, 'putChangePassword'])->name('manage.user.change-password');
    Route::delete('/manage-user/{id}', [ManageUserController::class, 'destroyUser'])->name('manage.user.destroy');

    //Prefix: Manage Levels
    Route::get('/manage-levels', [ManageLevelController::class, 'getIndex'])->name('manage.level.index');
    Route::post('/manage-level', [ManageLevelController::class, 'postLevel'])->name('manage.level.store');
    Route::get('/manage-level/{id}/access', [ManageLevelController::class, 'getAccess'])->name('manage.level.access');
    Route::get('/manage-level/{id}', [ManageLevelController::class, 'editLevel'])->name('manage.level.edit');
    Route::put('/manage-level/{id}', [ManageLevelController::class, 'updateLevel'])->name('manage.level.update');
    Route::put('/manage-level/{id}/change', [ManageLevelController::class, 'changeAccess'])->name('manage.level.change');
    Route::delete('/manage-level/{id}', [ManageLevelController::class, 'destroyLevel'])->name('manage.level.destroy');

    //Prefix: Manage Departments
    Route::get('/manage-departments', [ManageDepartmentController::class, 'getIndex'])->name('manage.department.index');
    Route::post('/manage-department', [ManageDepartmentController::class, 'postDepartment'])->name('manage.department.store');
    Route::get('/manage-department/{id}', [ManageDepartmentController::class, 'editDepartment'])->name('manage.department.edit');
    Route::put('/manage-department/{id}', [ManageDepartmentController::class, 'updateDepartment'])->name('manage.department.update');
    Route::delete('/manage-department/{id}', [ManageDepartmentController::class, 'destroyDepartment'])->name('manage.department.destroy');

    //Prefix: Manage Menus
    Route::get('/manage-menus', [ManageMenuController::class, 'getIndex'])->name('manage.menu.index');
    Route::post('/manage-menu', [ManageMenuController::class, 'postMenu'])->name('manage.menu.store');
    Route::get('/manage-menu/{id}', [ManageMenuController::class, 'editMenu'])->name('manage.menu.edit');
    Route::put('/manage-menu/{id}', [ManageMenuController::class, 'updateMenu'])->name('manage.menu.update');
    Route::delete('/manage-menu/{id}', [ManageMenuController::class, 'destroyMenu'])->name('manage.menu.destroy');

    //Prefix: Manage Submenus
    Route::get('/manage-submenus', [ManageSubmenuController::class, 'getIndex'])->name('manage.submenu.index');
    Route::post('/manage-submenu', [ManageSubmenuController::class, 'postSubmenu'])->name('manage.submenu.store');
    Route::get('/manage-submenu/{id}', [ManageSubmenuController::class, 'editSubmenu'])->name('manage.submenu.edit');
    Route::put('/manage-submenu/{id}', [ManageSubmenuController::class, 'updateSubmenu'])->name('manage.submenu.update');
    Route::delete('/manage-submenu/{id}', [ManageSubmenuController::class, 'destroySubmenu'])->name('manage.submenu.destroy');

    //Prefix: Manage Modules
    Route::get('/manage-modules', [ManageModuleController::class, 'getIndex'])->name('manage.module.index');
    Route::post('/manage-module', [ManageModuleController::class, 'storeModule'])->name('manage.module.store');
    Route::get('/manage-module/{id}', [ManageModuleController::class, 'editModule'])->name('manage.module.edit');
    Route::put('/manage-module/{id}', [ManageModuleController::class, 'updateModule'])->name('manage.module.update');
    Route::delete('/manage-module/{id}', [ManageModuleController::class, 'destroyModule'])->name('manage.module.destroy');

    //Prefix: Manage Accounts
    Route::get('/manage-dbaccounts', [ManageDBAccountController::class, 'getIndex'])->name('manage.dbaccount.index');
    Route::post('/manage-dbaccount', [ManageDBAccountController::class, 'storeAccount'])->name('manage.dbaccount.store');
    Route::get('/manage-dbaccount/{id}', [ManageDBAccountController::class, 'editAccount'])->name('manage.dbaccount.edit');
    Route::put('/manage-dbaccount/{id}', [ManageDBAccountController::class, 'updateAccount'])->name('manage.dbaccount.update');
    Route::delete('/manage-dbaccount/{id}', [ManageDBAccountController::class, 'destroyAccount'])->name('manage.dbaccount.destroy');

    //Prefix: Manage Subdepartments
    Route::get('/manage-subdepartments', [ManageSubdepartmentController::class, 'getIndex'])->name('manage.subdepartment.index');
    Route::post('/manage-subdepartment', [ManageSubdepartmentController::class, 'storeSubdepartment'])->name('manage.subdepartment.store');
    Route::get('/manage-subdepartment/{id}', [ManageSubdepartmentController::class, 'editSubdepartment'])->name('manage.subdepartment.edit');
    Route::put('/manage-subdepartment/{id}', [ManageSubdepartmentController::class, 'updateSubdepartment'])->name('manage.subdepartment.update');
    Route::delete('/manage-subdepartment/{id}', [ManageSubdepartmentController::class, 'destroySubdepartment'])->name('manage.subdepartment.destroy');
>>>>>>> 77cbe935 (upload from local to git)
