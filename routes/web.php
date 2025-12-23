<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LogistikController;

Route::get('/', [ProductController::class, 'index']);

Route::post('/store', [ProductController::class, 'store']);

Route::post('/update/{kode}', [ProductController::class, 'update']);

Route::get('/delete/{kode}', [ProductController::class, 'delete']);

Route::get('/logistik', [LogistikController::class, 'index']);
Route::post('/logistik', [LogistikController::class, 'store']);
Route::get('/logistik/{id}/edit', [LogistikController::class, 'edit'])->name('logistik.edit');
Route::put('/logistik/{id}', [LogistikController::class, 'update'])->name('logistik.update');
Route::delete('/logistik/{id}', [LogistikController::class, 'destroy'])->name('logistik.destroy');