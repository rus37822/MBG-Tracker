<?php

use App\Http\Controllers\MbgRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MbgRecordController::class, 'index'])->name('mbg.index');
Route::get('/mbg/form', [MbgRecordController::class, 'index'])->defaults('page', 'form')->name('mbg.form');
Route::get('/mbg/history', [MbgRecordController::class, 'index'])->defaults('page', 'history')->name('mbg.history');
Route::get('/mbg/daily-menu', [MbgRecordController::class, 'dailyMenuUpload'])->name('mbg.daily-menu');
Route::post('/mbg/records', [MbgRecordController::class, 'store'])->name('mbg.store');
Route::post('/mbg/daily-menu', [MbgRecordController::class, 'storeDailyMenu'])->name('mbg.daily-menu.store');
Route::delete('/mbg/daily-menu', [MbgRecordController::class, 'destroyDailyMenu'])->name('mbg.daily-menu.destroy');
Route::delete('/mbg/records/{mbgRecord}', [MbgRecordController::class, 'destroy'])->name('mbg.destroy');
Route::get('/mbg/report/{date}', [MbgRecordController::class, 'exportPdf'])->name('mbg.pdf');
