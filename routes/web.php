<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['ar', 'en'])) {
        if (session()->has('lang')) {
            session()->forget('lang');
        }
        session()->put('lang', $lang);
    } else {
        if (session()->has('lang')) {
            session()->forget('lang');
        }
        session()->put('lang', 'ar');
    }
    return back();
});


Route::prefix('/')->middleware('guest:user')->group(function () {
    Route::get('/login', [AuthController::class, 'Showlogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login_pass');
});

Route::prefix('/')->middleware('auth:user')->group(function () {
    Route::view('/home', 'layout.layout')->name('home');
    Route::resources(['category' => CategoryController::class]);
    Route::resources(['doctor' => DoctorController::class]);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/show/{id}', [ReservationsController::class, 'show'])->name('show');
    Route::get('/print-pdf', [ReservationsController::class, 'generatePDF']);
});


Route::prefix('/')->middleware('lang')->group(function () {
    Route::resources(['/' => ReservationsController::class]);
    Route::post('/data', [ReservationsController::class, 'data'])->name('data');
    Route::get('/check-time-availability', [ReservationsController::class, 'check_time']);
    Route::view('/front', 'frontend.data');
    Route::get('/get-doctor-working-days', [DayController::class, 'index']);
    Route::get('/info/{id}', [DayController::class, 'info']);
});
