<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MbgRecordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'createAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'storeAdminLogin'])->middleware('throttle:5,1')->name('admin.login.store');
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'createRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegistration'])->middleware('throttle:5,1')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::middleware('can:manage-users')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/', [MbgRecordController::class, 'index'])->name('mbg.index');
    Route::get('/mbg/form', [MbgRecordController::class, 'index'])->defaults('page', 'form')->name('mbg.form');
    Route::get('/mbg/history', [MbgRecordController::class, 'index'])->defaults('page', 'history')->name('mbg.history');
    Route::get('/mbg/daily-menu', [MbgRecordController::class, 'dailyMenuUpload'])->name('mbg.daily-menu');
    Route::post('/mbg/records', [MbgRecordController::class, 'store'])->name('mbg.store');
    Route::post('/mbg/daily-menu', [MbgRecordController::class, 'storeDailyMenu'])->name('mbg.daily-menu.store');
    Route::delete('/mbg/daily-menu', [MbgRecordController::class, 'destroyDailyMenu'])->name('mbg.daily-menu.destroy');
    Route::delete('/mbg/records/{mbgRecord}', [MbgRecordController::class, 'destroy'])->name('mbg.destroy');
    Route::get('/mbg/report/{date}', [MbgRecordController::class, 'exportPdf'])->name('mbg.pdf');
});
