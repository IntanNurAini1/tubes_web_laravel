<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MeetingController;

Route::get('/', [ProductController::class, 'index']);

Route::post('/store', [ProductController::class, 'store']);

Route::post('/update/{kode}', [ProductController::class, 'update']);

Route::get('/delete/{kode}', [ProductController::class, 'delete']);
Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::put('/meetings/{id}', [MeetingController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingController::class, 'destroy']);