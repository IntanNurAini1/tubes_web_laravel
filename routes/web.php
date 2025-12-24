<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\MaintenanceController;

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index']);
Route::post('/store', [ProductController::class, 'store']);
Route::post('/update/{kode}', [ProductController::class, 'update']);
Route::get('/delete/{kode}', [ProductController::class, 'delete']);
Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::put('/meetings/{id}', [MeetingController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| LOGISTIK
|--------------------------------------------------------------------------
*/
Route::get('/logistik', [LogistikController::class, 'index']);
Route::post('/logistik', [LogistikController::class, 'store']);
Route::get('/logistik/{id}/edit', [LogistikController::class, 'edit'])->name('logistik.edit');
Route::put('/logistik/{id}', [LogistikController::class, 'update'])->name('logistik.update');
Route::delete('/logistik/{id}', [LogistikController::class, 'destroy'])->name('logistik.destroy');

/*
|--------------------------------------------------------------------------
| EMPLOYEE (API)
|--------------------------------------------------------------------------
*/
Route::get('/api/employees-php', [KaryawanController::class, 'index']);
Route::get('/api/employees-php/{nip}', [KaryawanController::class, 'show']);

/*
|--------------------------------------------------------------------------
| MAINTENANCE
|--------------------------------------------------------------------------
*/
Route::get('/maintenance', [MaintenanceController::class, 'index']);
Route::post('/maintenance/store', [MaintenanceController::class, 'store']);
Route::post('/maintenance/update/{kode}', [MaintenanceController::class, 'update']);
Route::get('/maintenance/delete/{kode}', [MaintenanceController::class, 'delete']);
