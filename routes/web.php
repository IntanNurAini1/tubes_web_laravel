<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/produk', [ProductController::class, 'index']);
Route::post('/produk/store', [ProductController::class, 'store']);
Route::post('/produk/update/{kode}', [ProductController::class, 'update']);
Route::get('/produk/delete/{kode}', [ProductController::class, 'delete']);
