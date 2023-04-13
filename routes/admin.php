<?php
use App\Http\Controllers\Admin\ManageDBAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageLevelController;
use App\Http\Controllers\Admin\ManageDepartmentController;
use App\Http\Controllers\Admin\ManageMenuController;
use App\Http\Controllers\Admin\ManageModuleController;
use App\Http\Controllers\Admin\ManageSubmenuController;
use App\Http\Controllers\Admin\ManageSubdepartmentController;

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