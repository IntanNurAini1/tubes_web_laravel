<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\KaryawanController;

Route::get('/', [ProductController::class, 'index']);

Route::post('/store', [ProductController::class, 'store']);

Route::post('/update/{kode}', [ProductController::class, 'update']);

Route::get('/delete/{kode}', [ProductController::class, 'delete']);

Route::get('/api/employees-php', [KaryawanController::class, 'index']);

Route::get('/api/employees-php/{nip}', [KaryawanController::class, 'show']);