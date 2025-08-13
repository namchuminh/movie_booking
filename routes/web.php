<?php

use Illuminate\Support\Facades\Route;



Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/phim-dang-chieu', [\App\Http\Controllers\Web\MovieController::class, 'nowShowing'])
    ->name('movies.now_showing');
Route::get('/phim-sap-chieu', [\App\Http\Controllers\Web\MovieController::class, 'comingSoon'])
    ->name('movies.coming_soon');
Route::get('/phim-trong-thang', [\App\Http\Controllers\Web\MovieController::class, 'thisMonth'])
    ->name('movies.this_month');
Route::get('/lich-chieu', [\App\Http\Controllers\Web\ShowtimeController::class, 'index'])
    ->name('showtimes.index');
Route::get('/khuyen-mai', [\App\Http\Controllers\Web\PromotionController::class, 'index'])
    ->name('promotions.index');
Route::get('/rap-phim/{id}', [\App\Http\Controllers\Web\CinemaController::class, 'show'])
    ->name('cinemas.show');
Route::get('/ho-tro', function () {
    return view('web.contact.index');
})->name('contact');

Route::get('/mua-ve/{id}', [\App\Http\Controllers\Web\TicketController::class, 'show'])
    ->name('tickets.show');
Route::post('/mua-ve/{id}', [\App\Http\Controllers\Web\TicketController::class, 'checkout'])
    ->name('tickets.checkout');
Route::post('/thanh-toan', [\App\Http\Controllers\Web\TicketController::class, 'payment'])
    ->name('tickets.payment');
Route::get('/check-thanh-toan', [\App\Http\Controllers\Web\TicketController::class, 'checkPayment'])
    ->name('tickets.check_payment');
Route::get('/thong-tin-ve', [\App\Http\Controllers\Web\TicketController::class, 'info'])
    ->name('tickets.info');
Route::get('/in-ve/{id}', [\App\Http\Controllers\Web\TicketController::class, 'print'])->name('tickets.print');

Route::post('/dang-nhap', [\App\Http\Controllers\Web\UserController::class, 'login'])->name('login');
Route::get('/khach-hang', [\App\Http\Controllers\Web\UserController::class, 'user'])->name('user');  
Route::put('/khach-hang', [\App\Http\Controllers\Web\UserController::class, 'update'])->name('profile');
Route::get('/dang-xuat', [\App\Http\Controllers\Web\UserController::class, 'logout'])->name('logout');

Route::get('/dang-ky', [\App\Http\Controllers\Web\UserController::class, 'register'])->name('register');
Route::post('/dang-ky', [\App\Http\Controllers\Web\UserController::class, 'registerSubmit'])->name('registerSubmit');



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
