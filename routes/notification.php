<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('notification', [NotificationController::class, 'getNotification'])->name('notification.get');
Route::get('notification/count', [NotificationController::class, 'countNotification'])->name('notification.count');
Route::get('notification/read', [NotificationController::class, 'onclickNotif'])->name('notification.read');
