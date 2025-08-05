<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'loginForm'])->name('admin.loginForm');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'loginSubmit'])->name('admin.loginSubmit');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin_or_staff'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('movies', \App\Http\Controllers\Admin\MovieController::class);
    Route::resource('cinemas', \App\Http\Controllers\Admin\CinemaController::class);
    Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);
    Route::resource('showtimes', \App\Http\Controllers\Admin\ShowtimeController::class);
    Route::resource('seats', \App\Http\Controllers\Admin\SeatController::class);
    Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class);
    Route::resource('booking-histories', \App\Http\Controllers\Admin\BookingHistoryController::class);
    Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class);
    Route::resource('ticket-codes', \App\Http\Controllers\Admin\TicketCodeController::class);
    Route::resource('ticket-promotions', \App\Http\Controllers\Admin\TicketPromotionController::class);
    Route::resource('profiles', \App\Http\Controllers\Admin\ProfileController::class);

    Route::get('/tickets/{id}/print', [\App\Http\Controllers\Admin\TicketController::class, 'print'])->name('tickets.print');
    Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});
