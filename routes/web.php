<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\StudioController as CustomerStudioController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudioController as AdminStudioController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\LaporanController;

// Welcome Page (HARUS DI PALING ATAS)
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.home');
    }
    return view('welcome');
})->name('welcome');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->name('customer.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/studio', [CustomerStudioController::class, 'index'])->name('studio.index');
    Route::get('/studio/{studio}', [CustomerStudioController::class, 'show'])->name('studio.show');

    // Booking Routes
    Route::get('/booking/create/{studio}', [CustomerBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/check-availability', [CustomerBookingController::class, 'checkAvailability'])->name('booking.check');
    Route::post('/booking/store', [CustomerBookingController::class, 'store'])->name('booking.store');
    Route::get('/booking', [CustomerBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [CustomerBookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{booking}/upload-payment', [CustomerBookingController::class, 'uploadPayment'])->name('booking.upload');
    Route::post('/booking/{booking}/cancel', [CustomerBookingController::class, 'cancel'])->name('booking.cancel');

    // Riwayat Booking
    Route::get('/riwayat', [CustomerBookingController::class, 'history'])->name('booking.history');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Studio Management
    Route::resource('studio', AdminStudioController::class);

    // Booking Management
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [AdminBookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{booking}/selesai', [AdminBookingController::class, 'markComplete'])->name('booking.complete');

    // Payment Verification
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/pembayaran/{payment}/verifikasi', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::post('/pembayaran/{payment}/tolak', [PaymentController::class, 'reject'])->name('payment.reject');
    Route::post('/pembayaran/pelunasan', [PaymentController::class, 'storePelunasan'])->name('payment.pelunasan');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});
