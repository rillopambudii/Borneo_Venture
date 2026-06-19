<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchandiseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/success/{code}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');

// --- Admin ---
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::view('/admin/galeri', 'admin.gallery')->name('admin.gallery');
    Route::view('/admin/aspek', 'admin.aspek')->name('admin.aspek');
    Route::view('/admin/highlight', 'admin.highlight')->name('admin.highlight');
    Route::view('/admin/tentang', 'admin.tentang')->name('admin.tentang');
});
