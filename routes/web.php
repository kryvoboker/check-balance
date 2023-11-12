<?php

use App\Http\Controllers\Cost\CostTrackingController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\User\RegisterController;
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

Route::redirect('/', 'login')
    ->middleware(['web', 'guest', 'auth.session']);

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'auth.session'])
    ->name('home');

// Login start
Route::middleware(['web', 'guest', 'auth.session'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});
// Login end

// Register start
Route::middleware(['web', 'guest', 'auth.session'])->group(function () {
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::view('success_register', 'auth.success_register')->name('success_register');
});
// Register end

// Logout start
Route::get('logout', [LogoutController::class, 'logout'])
    ->middleware(['auth', 'auth.session'])
    ->name('logout');
// Logout end

// Check costs start
Route::resource('costs', CostTrackingController::class)
    ->parameters([
        'cost' => 'cost_id',
    ])
    ->middleware(['auth', 'auth.session']);
// Check costs end
