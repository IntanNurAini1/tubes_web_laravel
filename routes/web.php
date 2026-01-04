<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AkunController;
Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AkunController::class, 'store'])->name('akun.store');

Route::get('/login', [AkunController::class, 'showLogin'])->name('login');
Route::post('/login', [AkunController::class, 'login'])->name('login.process');

Route::get('/halaman-utama', function () {
    return view('halamanutama');
})->name('halaman.utama');

Route::get('/karyawan', fn () => view('karyawan'));
Route::get('/logistik', fn () => view('logistik'));
// Route::get('/meetings', fn () => view('index'));
Route::get('/maintenance', fn () => view('maintenance'));
Route::get('/produk', fn () => view('produk'));

Route::get('/logout', [AkunController::class, 'logout'])->name('logout');

Route::get('/produk', [ProductController::class, 'index']);
Route::post('/produk/store', [ProductController::class, 'store']);
Route::post('/produk/update/{kode}', [ProductController::class, 'update']);
Route::get('/produk/delete/{kode}', [ProductController::class, 'delete']);

Route::post('/store', [ProductController::class, 'store']);
Route::post('/update/{kode}', [ProductController::class, 'update']);
Route::get('/delete/{kode}', [ProductController::class, 'delete']);
Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::put('/meetings/{id}', [MeetingController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingController::class, 'destroy']);

Route::get('/logistik', [LogistikController::class, 'index']);
Route::post('/logistik', [LogistikController::class, 'store']);
Route::get('/logistik/{id}/edit', [LogistikController::class, 'edit'])->name('logistik.edit');
Route::put('/logistik/{id}', [LogistikController::class, 'update'])->name('logistik.update');
Route::delete('/logistik/{id}', [LogistikController::class, 'destroy'])->name('logistik.destroy');

Route::get('/api/employees-php', [KaryawanController::class, 'index']);
Route::get('/api/employees-php/{nip}', [KaryawanController::class, 'show']);

Route::get('/maintenance', [MaintenanceController::class, 'index']);
Route::post('/maintenance/store', [MaintenanceController::class, 'store']);
Route::post('/maintenance/update/{kode}', [MaintenanceController::class, 'update']);
Route::get('/maintenance/delete/{kode}', [MaintenanceController::class, 'delete']);


