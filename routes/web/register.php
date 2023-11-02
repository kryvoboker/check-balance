<?php

use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'guest', 'auth.session'])->group(function () {
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});

Route::view('success_register', 'auth.success_register')
    ->middleware(['auth', 'auth.session'])
    ->name('success_register');
