<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MaintenanceController;

// PRODUCT
Route::get('/', [ProductController::class, 'index']);
Route::post('/store', [ProductController::class, 'store']);
Route::post('/update/{kode}', [ProductController::class, 'update']);
Route::get('/delete/{kode}', [ProductController::class, 'delete']);

// MAINTENANCE
Route::get('/maintenance', [MaintenanceController::class, 'index']);
Route::post('/maintenance/store', [MaintenanceController::class, 'store']);
Route::post('/maintenance/update/{kode}', [MaintenanceController::class, 'update']);
Route::get('/maintenance/delete/{kode}', [MaintenanceController::class, 'delete']);
