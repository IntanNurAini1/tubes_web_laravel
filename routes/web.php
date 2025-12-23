<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\MaintenanceController;

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
| Kita pakai prefix /produk supaya jelas dan konsisten
*/
Route::get('/produk', [ProductController::class, 'index']);
Route::post('/produk/store', [ProductController::class, 'store']);
Route::post('/produk/update/{kode}', [ProductController::class, 'update']);
Route::get('/produk/delete/{kode}', [ProductController::class, 'delete']);

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
